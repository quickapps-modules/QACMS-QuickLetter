<?php
class Template extends ModNewslettersAppModel {
	var $name	=	'Template';
	var $useTable	= "newsletter_templates";


	var $validate = array(
		'name' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid name."),
		'description' => array( 'required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => "Invalid description."),
		'content' => array( 'required' => true, 'allowEmpty' => false, 'rule' => 'notEmpty', 'message' => "Invalid content.")
	);

	function afterSave($created){
		$base_path = Configure::read('_UPLOAD_FOLDER'). Configure::read('_APP.user_setup.uploadFolder') . "/templates/template-{$this->id}/";
		$fpath = "template-{$this->id}.html";
		
		if ( $created ){
			$Folder = new Folder;
			$Folder->create(realpath($base_path));
		}
		
		$File = new File($base_path . $fpath, true, 777);
		$File->write($this->data['Template']['content']);
		
		$File->close();
	}
	
	function beforeDelete(){
		$Folder = new Folder;
		$folder = Configure::read('_UPLOAD_FOLDER').Configure::read('_APP.user_setup.uploadFolder')."/templates/template-{$this->id}/";
		$Folder->delete($folder);
		return true;
	}

}
?>