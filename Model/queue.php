<?php
class Queue extends ModNewslettersAppModel {
	var $name	=	'Queue';
	var $useTable	= "newsletter_queue";
	var $virtualFields = array(
		'percentage' => "CEILING((Queue.progress / Queue.total) * 100)"
		);

	var $belongsTo = array(
		'Message' => array(
			'className'		=> 'ModNewsletters.Message',
			'foreignKey'	=> 'message_id',
			'fields' => array('id', 'name'),
			'dependent' => true
		),
		'Group' => array(
			'className' => 'ModNewsletters.Group',
			'foreignKey' => 'target',
			'fields' => array('name')
		)
	);

}

?>