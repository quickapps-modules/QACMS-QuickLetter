<?php
class TemplatesController extends QuickLetterAppController {
    var $uses = array('QuickLetter.Template');

    function admin_index() {
        $results = $this->paginate('Template');

        $this->set('results', $results);
    }

    function admin_delete() {
        $this->Template->delete($id);
        $this->redirect($this->referer());
    }

    function admin_edit($id = false) {
        if (isset($this->data['Template'])) {
            if ($this->Template->save($this->data)) {
                $this->flashMsg(__t('Template has been saved!'), 'success');
            } else {
                $this->flashMsg(__t('Template could not be saved!'), 'error');
            }
        }

        $this->set('result', $this->Template->findById($id));
    }

    function render_template($id) {
        $template_path = Configure::read('_UPLOAD_FOLDER').Configure::read('_APP.user_setup.uploadFolder')."/templates/template-{$id}/template-{$id}.html";
        die(file_get_contents($template_path));
    }

    function add($form = false) {
        if (isset($this->data['Template']) && !$form) {
            $this->Template->set($this->data);
            if ($this->Template->validates()) {
                $out = $this->Template->save($this->data, false);
            } else {
                header('HTTP/1.1 403 Forbidden');
                $this->cakeError('form_error', $this->Template->invalidFields());
            }

            exit();
        }
        
        $this->autoRender = true;
    }
}