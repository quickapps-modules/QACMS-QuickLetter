<?php
class QueueController extends ModNewslettersAppController {
	var $name = 'Queue';
	var $uses = array('ModNewsletters.Queue', 'ModNewsletters.Sending');
	var $components = array('ModNewsletters.Newsletter');


	function beforeFilter(){
		parent::beforeFilter();
		/**
		 * Check for messages which have timed out.
		 */
		$t = time() - Configure::read('Newsletter.config.queue_timeout');
		$this->Queue->updateAll( array('Queue.status' => "'Stalled'"), array('Queue.touch <' => "{$t}", 'Queue.status' => "Sending") );
	}

	function index($id = null, $iframe_action = 'queue'){
	
		$conditions = " 1 = 1 ";
		$this->paginate = array(
			'conditions' => $conditions,
			'limit' => Configure::read('rows_per_page')
		);

		$results = $this->paginate('Queue');
		$this->set('stalled', $this->Queue->find('all', array('conditions' => "Queue.status = 'Stalled' ") ) );
		$this->set('results', $results);


		if ( isset($this->data['act']) ){
			switch($this->data['act']){
				case "render_items_list":
					$this->render('/elements/queue_list');
					break;
			}
		}

		if ( !empty($id) ){
			@ini_set("error_reporting",  E_ALL ^ E_NOTICE);
			@ini_set("magic_quotes_runtime", 0);
			@ini_set("allow_url_fopen", 1);

			@set_time_limit(300);
				
			$this->set('iframe_action', $iframe_action);
			$this->set('queueData', $this->Queue->findById($id) );

		}
	}

	function delete(){
		$this->Queue->deleteAll( array('Queue.id' => $this->data['Items']['id'] ) );
		$this->Sending->deleteAll( array('Sending.queue_id' => $this->data['Items']['id'] ) ); ##por si acaso
	}


	function send_iframe($id = false, $iframe_action = false){
		$this->layout = '';
		$this->autoRender = false;
		$this->Newsletter->send_iframe($id, $iframe_action);
	}

}
?>