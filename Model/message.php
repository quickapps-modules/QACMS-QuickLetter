<?php
class Message extends QuickLetterAppModel {
    var $name        = 'Message';
    var $useTable    = 'ql_messages';

    var $validate = array(
        'name' => array('required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid internal title."),
        'subject' => array('required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid title."),
        'from_field' => array('required' => true, 'allowEmpty' => false, 'rule' => array('email'), 'message' => "Invalid 'from' email."),
        'priority' => array('required' => true, 'allowEmpty' => false, 'rule' => array('numeric'), 'message' => "Select priority level."),
        'body_text' => array('required' => true, 'allowEmpty' => false, 'rule' => array('minLength', 8), 'message' => "Invalid plain text."),
        'list_count' => array('required' => true, 'allowEmpty' => false, 'rule' => array('comparison', '>', 0) , 'message' => "You must select at least one group.")
    );

    function beforeValidate() {
        $from_pieces  = explode("\" <", QuickLetterComponent::tagReplace($this->data['Message']['from_field']));
        $this->data['Message']['name'] = ($this->data['Message']['send_type'] == 'test' && empty($this->data['Message']['name'])) ? "dummy" : $this->data['Message']['name'];

        if (isset($from_pieces[1])) {
            $this->data['Message']['from_field'] = trim(str_replace(array('<', '>'), array('', ''), $from_pieces[1]));
        } elseif (is_array($from_pieces)) {
            $this->data['Message']['from_field'] = $from_pieces[0];
        } else {
            $this->data['Message']['from_field'] = $from_pieces;
        }

        $this->data['Message']['from_field'] = QuickLetterComponent::tagReplace($this->data['Message']['from_field']);
        $this->data['Message']['list_count'] = ($this->data['Message']['send_type'] == 'queue') ? count($this->data['Group']['Group']) : 1;
       
        return true;
    }
}