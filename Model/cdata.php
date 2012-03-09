<?php
class Cdata extends QuickLetterAppModel {
    var $name        = 'Cdata';
    var $useTable    = 'newsletter_cdata';

    var $belongsTo = array(
        'Cfield' => array(
            'className'             => 'QuickLetter.Cfield',
            'dependent'                => false
        )
    );
}
?>