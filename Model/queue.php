<?php
class Queue extends QuickLetterAppModel {
    var $name    =    'Queue';
    var $useTable    = "ql_queue";
    var $virtualFields = array('percentage' => "CEILING((Queue.progress / Queue.total) * 100)");
    var $belongsTo = array(
        'Message' => array(
            'className' => 'QuickLetter.Message',
            'foreignKey' => 'message_id',
            'fields' => array('id', 'name'),
            'dependent' => true
        ),
        'Group' => array(
            'className' => 'QuickLetter.Group',
            'foreignKey' => 'target',
            'fields' => array('name')
        )
    );
}