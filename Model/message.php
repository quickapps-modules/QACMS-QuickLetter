<?php
class Message extends ModNewslettersAppModel {
	var $name		= 'Message';
	var $useTable	= 'newsletter_messages';

	var $validate = array(
		'name' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid internal title."),
		'subject' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid title."),
		'from_field' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('email'), 'message' => "Invalid 'from' email."),
		'priority' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('numeric'), 'message' => "Select priority level."),
		'body_text' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('minLength', 8), 'message' => "Invalid plain text."),
		'list_count' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('comparison', '>', 0) , 'message' => "You must select at least one group.")
	);

	function beforeValidate(){
		App::import('Component', 'ModNewsletters.Newsletter');
		$from_pieces  = explode("\" <", NewsletterComponent::tag_r($this->data['Message']['from_field']));
		$this->data['Message']['name'] = ($this->data['Message']['send_type'] == 'test' && empty($this->data['Message']['name']) ) ? "dummy" : $this->data['Message']['name'];
		
		@$this->data['Message']['from_field'] = ( isset($from_pieces[1]) ) ?
			trim(str_replace(array('<', '>'), array('', ''), $from_pieces[1])) :
			( (is_array($from_pieces)) ? $from_pieces[0] : $from_pieces )
			;
		App::import('Component', 'Newsletter');
		$this->data['Message']['from_field'] = NewsletterComponent::tag_r($this->data['Message']['from_field']);
				
		$this->data['Message']['list_count'] = ( $this->data['Message']['send_type'] == 'queue' ) ? count($this->data['Group']['Group']) : 1;
		return true;
	}
}

?>