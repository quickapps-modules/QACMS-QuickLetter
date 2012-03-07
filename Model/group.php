<?php
class Group extends ModNewslettersAppModel {
	var $name	=	'Group';
	var $useTable	= "newsletter_lists";
	
	
	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'ModNewsletters.User',
			'with' => 'ModNewsletters.Habtm',
			'foreignKey'  => 'list_id',
			'associationForeignKey'  => 'user_id',
			'fields' => array('id')
	)
	);

	var $actsAs = array( 'Tree' => array('parent' => 'parent_id', 'left' => 'lft', 'right' => 'rgt') );
}

?>