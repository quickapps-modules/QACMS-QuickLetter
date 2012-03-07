<?php

App::import('Lib', 'ModNewsletters.phpmailer.phpmailer');

class NL_Mailer extends PHPMailer {

	function NL_Mailer() {
		if(!Configure::read('Newsletter.config.delivery_method')) {
			$this->SetError(_e("The 'delivery_method' constant is not defined which means the loader wasn't called."));
			return false;
		}

		$this->PluginDir = dirname(__FILE__).DS."phpmailer".DS;

		switch(Configure::read('Newsletter.config.delivery_method')) {
			case "mail" :
				$this->IsMail();
		  break;

			case "smtp" :
				$this->IsSMTP();
				$this->Host         = Configure::read('Newsletter.config.SMTP_address');
				$this->SMTPAuth     = Configure::read('Newsletter.config.SMTP_auth');
				if($this->SMTPAuth) {
			  $this->Username   = Configure::read('Newsletter.config.SMTP_user');
			  $this->Password   = Configure::read('Newsletter.config.SMTP_password');
				}
				$this->SMTPKeepAlive  = ( Configure::read('SMTP_keep_alive') == 'no' ) ? false : true;
		  break;

			case "gmail" :
				$this->IsSMTP();
				$this->Host         	= Configure::read('Newsletter.config.GMAIL_address');
				$this->Port     		= Configure::read('Newsletter.config.GMAIL_port');
				$this->SMTPAuth 		= true;
				$this->Username   		= Configure::read('Newsletter.config.GMAIL_user');
				$this->Password   		= Configure::read('Newsletter.config.GMAIL_password');
		  break;
		}
		
		$this->CharSet = Configure::read('_CHARSET');

		$this->ClearAddresses();
	}



}

?>