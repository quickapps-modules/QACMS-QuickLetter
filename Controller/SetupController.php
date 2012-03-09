<?php
class SetupController extends QuickLetterAppController {
    var $name = 'Setup';
    var $uses = array('ModuleConfig', 'QuickLetter.NewslettersConfig'); // NewslettersConfig for validation ONLY

    function index() {

        if ($this->data['ModuleConfig']) {
            $data = array();
            foreach ($this->data['ModuleConfig'] as $item => $value) {
                if ($item != 'act') {
                    $data[]['ModuleConfig'] = array(
                            'key' => $item,
                            'value' => $value
                    );
                }
            }
            $this->NewslettersConfig->set(array('NewslettersConfig' => $this->data['ModuleConfig']));
            if ($this->NewslettersConfig->validates()) {
                $this->ModuleConfig->saveAll($data);
                Cache::clear();
            } else {
                header('HTTP/1.1 403 Forbidden');
                $this->cakeError('form_error', $this->NewslettersConfig->invalidFields());
            }

        }

        $this->set('results', $this->ModuleConfig->find('all', array('conditions' => 'ModuleConfig.product_id = 8') ));
    }

}
?>