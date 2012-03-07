<?php 
class Cdata extends ModNewslettersAppModel {
    var $name		= 'Cdata';
	var $useTable	= 'newsletter_cdata';
	
	var $belongsTo = array(
		'Cfield' => array(
			'className' 			=> 'ModNewsletters.Cfield',
			'dependent'				=> false
		)
	);							
}	
?>