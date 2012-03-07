<?php
class NewslettersConfig extends ModNewslettersAppModel {
	var $name	=	'NewslettersConfig';
	var $useTable	= "module_configs";
	var $primaryKey = 'item';

	var $validate = array(	'messages_per_refresh' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('comparison', '>', 0), 'message' => "Invalid Messages Per Refresh."),
							'pause_between_refreshes' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('comparison', '>', 0), 'message' => "Invalid Pause Between Refreshes."),
							'queue_timeout' => array(
								'comparision' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('comparison', '>', 0), 'message' => "Invalid Queue Timeout."),
								'queue_vs_pause' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('queue_vs_pause'), 'message' => "Invalid Queue Timeout, must be higher than 'Pause Between Refreshes'.")
		)
	);

	function beforeValidate(){

		if ( !isset($this->data['NewslettersConfig']['act']) || $this->data['NewslettersConfig']['act'] != 'email_setup' ){
			$this->validate = false;
		} else {
			switch ( $this->data['NewslettersConfig']['delivery_method'] ){
				case "smtp":
					$validate = array(	'SMTP_address' => array( 'required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => ("Invalid SMTP address.") ),
										'SMTP_user' => array( 'required' => true, 'allowEmpty' => false, 'rule' =>  array('validate_smtp_login', $this->data['NewslettersConfig']['SMTP_auth']), 'message' => ("Invalid SMTP user.")),
										'SMTP_password' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('validate_smtp_login', $this->data['NewslettersConfig']['SMTP_auth']), 'message' => ("Invalid SMTP password."))
					);
					break;

				case "gmail":
					$validate = array(	'GMAIL_address' => array( 'required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => ("Invalid Gmail server address.") ),
										'GMAIL_port' => array( 'required' => true, 'allowEmpty' => false, 'rule' =>  array('numeric'), 'message' => ("Invalid Gmail server port.")),
										'GMAIL_user' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('minLength', 3), 'message' => ("Invalid Gmail user.")),
										'GMAIL_password' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('minLength', 3), 'message' => ("Invalid Gmail password."))
					);
					break;

				default:
					$validate = array();
					break;
			}

			$this->validate = array_merge($this->validate, $validate);
				

		}
		return true;
	}

	function validate_smtp_login($check, $use_auth){
		@$check = isset($check['SMTP_user']) ? $check['SMTP_user'] : $check['SMTP_password'];
		if ( $use_auth == 'true' ){
			return ( strlen( trim($check) ) > 0 );
		}
		return true;
	}

	function queue_vs_pause($check){
		return $check >  $this->data['NewslettersConfig']['pause_between_refreshes'];
	}
}
?>