<?php
App::uses('phpmailer', 'QuickLetter.Lib/phpmailer');

class QLMailer extends PHPMailer {
    public function __construct() {
        if (!Configure::read('QuickLetter.settings.delivery_method')) {
            $this->SetError(__t("The 'delivery_method' constant is not defined which means the loader wasn't called."));

            return false;
        }

        $this->PluginDir = dirname(__FILE__) . DS . 'phpmailer' . DS;

        switch (Configure::read('QuickLetter.settings.delivery_method')) {
            case "mail" :
                $this->IsMail();
            break;

            case "smtp" :
                $this->IsSMTP();
                $this->Host = Configure::read('QuickLetter.settings.SMTP_address');
                $this->SMTPAuth = Configure::read('QuickLetter.settings.SMTP_auth');

                if ($this->SMTPAuth) {
                    $this->Username = Configure::read('QuickLetter.settings.SMTP_user');
                    $this->Password = Configure::read('QuickLetter.settings.SMTP_password');
                }
                
                $this->SMTPKeepAlive  = (Configure::read('SMTP_keep_alive') == 'no') ? false : true;
            break;

            case "gmail" :
                $this->IsSMTP();
                $this->Host = Configure::read('QuickLetter.settings.GMAIL_address');
                $this->Port = Configure::read('QuickLetter.settings.GMAIL_port');
                $this->SMTPAuth = true;
                $this->Username = Configure::read('QuickLetter.settings.GMAIL_user');
                $this->Password = Configure::read('QuickLetter.settings.GMAIL_password');
            break;
        }

        $this->CharSet = Configure::read('_CHARSET');

        $this->ClearAddresses();
    }
}