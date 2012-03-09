<?php
class Group extends QuickLetterAppModel {
    var $name    =    'Group';
    var $useTable    = "newsletter_lists";


    var $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'QuickLetter.User',
            'with' => 'QuickLetter.Habtm',
            'foreignKey'  => 'list_id',
            'associationForeignKey'  => 'user_id',
            'fields' => array('id')
    )
    );

    var $actsAs = array('Tree' => array('parent' => 'parent_id', 'left' => 'lft', 'right' => 'rgt'));
}

?>