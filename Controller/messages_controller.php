<?php
class MessagesController extends ModNewslettersAppController {

	var $uses = array(	'ModNewsletters.User', 'ModNewsletters.Message', 'ModNewsletters.Cfield', 'ModNewsletters.Group', 'ModNewsletters.Habtm', 'ModNewsletters.Queue');

	var $components = array('Newsletter');

	function index(){
		/* uses:= 'ModNewsletters.User'
		 for($i=0; $i<100; $i++){
		 $list = rand(18,20);
		 $html = rand(0,1);
		 $data = array(
		 'name' => "AAAAAAA",
		 'email' => "example{$i}@demos.newsletter.com",
		 'html_email' => $html,
		 'gender' => 'male',
		 'status' => 1
		 );
		 $this->User->saveAll($data);
		 $data2 = array('user_id' => $this->User->id, 'list_id' => 1);
		 $this->UserList->saveAll($data2);
		 }
		 */

		$conditions = " 1 = 1 ";
		if ( isset($this->data['Message']['filter']) ){
			$conditions .= " AND Message.{$this->data['Message']['filter']['by']} ";
			$conditions .= ($this->data['Message']['filter']['condition'] == 'equals') ? "= '{$this->data['Message']['filter']['value']}'" : "LIKE '%{$this->data['Message']['filter']['value']}%'";
		}
		
		$this->paginate = array(
			'conditions' => $conditions,
			'limit' => Configure::read('rows_per_page')
		);

		$results = $this->paginate('Message');
		$this->set('results', $results);
		
		
		if ( isset($this->data['act']) ){
			switch($this->data['act']){
				case "render_items_list":
					$this->render('/elements/messages_list');
					break;
			}
		}
		
		
	}

	function edit($id){
		$this->set('placeholders', $this->Cfield->find('all', array('recursive' => -1, 'fields' => array('sname') ) ) );
		$this->set('groups', $this->Group->generatetreelist(null, null, null,"&nbsp;&nbsp;&nbsp;"));
		$this->set('messageData', $this->Message->findById($id));
	}

	function compose(){
		$this->set('placeholders', $this->Cfield->find('all', array('recursive' => -1, 'fields' => array('sname') ) ) );
		$this->set('groups', $this->Group->generatetreelist(null, null, null,"&nbsp;&nbsp;&nbsp;"));
	}
	
	function delete(){
		$this->Message->deleteAll( array('Message.id' => $this->data['Items']['id'] ) );
		$this->Queue->deleteAll( array('Queue.message_id' => $this->data['Items']['id'] ) );
		die();
	}

	/* update and send messages*/
	function send(){
		$this->data['Group']['Group'] = ( isset($this->data['Group']['Group']) ) ? $this->data['Group']['Group'] : array();
		switch ($this->data['Message']['send_type']){
			case 'update':
				case 'draft':
					case 'queue':
						$data = $this->data; /*untouched data*/
						$this->Message->set( $this->data );
						if ( $this->Message->validates() ){
							$out = $this->Message->save($data, false);
						} else {
							header('HTTP/1.1 403 Forbidden');
							$this->cakeError('form_error', $this->Message->invalidFields());
						}
					break;
		}

		if ( $this->data['Message']['send_type'] == 'queue' ){
			$target = implode(', ', $this->data['Group']['Group']);
			Configure::write('debug', 2);
			$user_ids = $this->Habtm->find('all', array('recursive' => -1, 'conditions' => array('Habtm.list_id' => $this->data['Group']['Group']) ) );
			$user_ids = Set::extract('/Habtm/user_id', $user_ids);
			$total = 
				$this->User->find('all', 
					array(
						'conditions' => 
							array(
								'User.id' => $user_ids,
								'User.status' => 1
							),
						'group' => array('User.email'),
						'recursive' => -1,
						'fields' => array('User.id')
					)
			
			);
			
			$queue['Queue'] = array(
				'message_id' => $this->Message->id,
				'date' => date('Y-m-d H:i:s'),
				'touch' => 0,
				'target' => $target,
				'progress' => 0,
				'total' => count($total),
				'status' => 'Preparing'
			);

			$this->Queue->save($queue);
				
			App::import('Helper', 'Html');
			die( HtmlHelper::url("/{$this->plugin}/queue/index/{$this->Queue->id}/queue", true) );
		} elseif ( $this->data['Message']['send_type'] == 'draft'){
			die("{$this->Message->id}");
		} elseif ( $this->data['Message']['send_type'] == 'test' ){
			$mails = explode(',', $this->data['Message']['test_mails']);
			$mailNotFound = array();
			
			foreach ( $mails as $mail){
				if ( $this->User->find('count', array('conditions' => array('User.email' => trim($mail) ) ) ) != 1 ){
					$mailNotFound[] = $mail;
				}
			}
			
			if ( count($mailNotFound) > 0 ) {
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', array('mails_not_found' => 'Emails do not exists: '. implode(',', $mailNotFound) ) );
			} else {
				/* ENVIAR */
				
				App::import('Lib', 'ModNewsletters.mailer');
					
				$mail             = new NL_Mailer();
				$mail->Priority   = 1;
				$mail->Encoding   = "8bit";
					
				$from_pieces		= explode("\" <", $this->data['Message']['from_field']);
				$mail->From       	= substr($from_pieces[1], 0, (@strlen($from_pieces[1])-1));
				$mail->FromName    	= substr($from_pieces[0], 1, (@strlen($from_pieces[0])));
			
				if ( strlen(trim(Configure::read('Newsletter.config.message_replyto_address'))) >0 )
					$mail->AddReplyTo(NewsletterComponent::tag_r(Configure::read('Newsletter.config.message_replyto_address')));
						
				foreach( $mails as $email){
					$user = $this->User->find('first', array(
						'conditions' => array('User.email' => $email)
					));
					
						
					$mail->Subject = NewsletterComponent::tag_r($this->data['Message']['subject'], $user['User']);
					if( $user['User']['html_email '] == 1 && strlen(trim($this->data['Message']['body_html'])) > 0) { // HTML version
						$mail->Body		= NewsletterComponent::tag_r($this->data['Message']['body_html']."<br/><br/><br/>".$this->data['Message']['footer'], $user['User']);
						$mail->AltBody	= NewsletterComponent::tag_r($this->data['Message']['body_text']."\n\n\n".$this->data['Message']['footer'], $user['User']);
					} else {
						$mail->Body    = NewsletterComponent::tag_r($this->data['Message']['body_text']."\n\n\n".$this->data['Message']['footer'], $user['User']);
					}

					$mail->ClearAddresses();
					$mail->AddAddress($user['User']['email'], $user['User']['name'] );
					if ( !$mail->Send() ){
						e('Error: '.$mail->ErrorInfo.'<br/>');
					}
				}
				die('ok');
			}
		}
	}

	function preview(){
		$this->autoRender = true;
		$this->data['Message']['from_field'] = $this->Newsletter->tag_r($this->data['Message']['from_field']);
		$this->data['Message']['subject'] = $this->Newsletter->tag_r($this->data['Message']['subject']);
		$this->data['Message']['test_mails'] = (isset($this->data['Message']['test_mails'])) ? $this->Newsletter->tag_r($this->data['Message']['test_mails']) : null;
		$this->data['Message']['body_html'] = $this->Newsletter->tag_r($this->data['Message']['body_html']);
		$this->data['Message']['body_text'] = $this->Newsletter->tag_r($this->data['Message']['body_text']);
		$this->data['Message']['footer'] = $this->Newsletter->tag_r($this->data['Message']['footer']);
	}

	function import_articles(){
		$this->autoRender = true;
		$posts = Classregistry::init('ModBlogs.Post')->find('all', array('fields' => array('id', 'title') ) );
		$this->set('posts', $posts);
	}

	function import_news(){
		$this->autoRender = true;
		$news = Classregistry::init('ModNews.News')->find('all', array('fields' => array('id', 'title') ) );
		$this->set('news', $news);
	}

	function news_preview($id){
		$this->autoRender = true;
		$news = Classregistry::init('ModNews.News')->findById($id);
		$this->set('news', $news);
	}

	function article_preview($id){
		$this->autoRender = true;
		$post = Classregistry::init('ModBlogs.Post')->findById($id);
		$this->set('post', $post);
	}

	function html2plain(){
		die($this->__html2text($this->data['Message']['body_html']));
	}

	function __html2text($html){
		$tags = array (
		0 => '~<h[123][^>]+>~si',
		1 => '~<h[456][^>]+>~si',
		2 => '~<table[^>]+>~si',
		3 => '~<tr[^>]+>~si',
		4 => '~<li[^>]+>~si',
		5 => '~<br[^>]+>~si',
		6 => '~<p[^>]+>~si',
		7 => '~<div[^>]+>~si',
		);
		$html = preg_replace($tags, "\n", $html);
		$html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si', ' - ', $html);
		$html = preg_replace('~<[^>]+>~s', '',$html);
		// reducing spaces
		$html = preg_replace('~ +~s', ' ', $html);
		$html = preg_replace('~^\s+~m', '', $html);
		$html = preg_replace('~\s+$~m', '', $html);
		// reducing newlines
		$html = preg_replace('~\n+~s', "\n", $html);
		$html = r('&nbsp;', '', $html);
		return $html;
	}
}
?>