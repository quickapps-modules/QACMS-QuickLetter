<?php
class Sending extends QuickLetterAppModel {
    var $name    =    'Sending';
    var $useTable    = 'newsletter_sending';

    var $belongsTo = array(
            'NUser' => array(
                'className' => 'QuickLetter.User',
                'foreignKey'  => 'user_id'
        )
    );
}