<?php
class Template extends QuickLetterAppModel {
    var $name    =    'Template';
    var $useTable    = "newsletter_templates";
    var $validate = array(
        'name' => array('required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid name."),
        'description' => array('required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid description."),
        'content' => array('required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => "Invalid content.")
    );

    function afterSave($created) {
        $base_path = ROOT . DS . 'webroot' . DS . 'files' . DS . 'quick_letter' . DS . 'templates' . DS . "template-{$this->id}" . DS;
        $fpath = "template-{$this->id}.html";

        if ($created) {
            $Folder = new Folder;
            $Folder->create($base_path);
        }

        $File = new File($base_path . $fpath, true, 777);
        
        $File->write($this->data['Template']['content']);
        $File->close();
    }

    function beforeDelete() {
        $Folder = new Folder;
        $folder = ROOT . DS . 'webroot' . DS . 'files' . DS . 'quickletter' . DS . 'templates' . DS . "template-{$this->id}" . DS;
        
        $Folder->delete($folder);

        return true;
    }
}