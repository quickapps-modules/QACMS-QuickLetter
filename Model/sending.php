<?php
class Sending extends ModNewslettersAppModel {
	var $name	=	'Sending';
	var $useTable	= 'newsletter_sending';

	var $belongsTo = array(
			'NUser' => array(
				'className' => 'ModNewsletters.User',
				'foreignKey'  => 'user_id'
		)
	);

}
?>