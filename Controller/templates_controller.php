<?php
class TemplatesController extends ModNewslettersAppController {
	var $name = 'Templates';
	var $uses = array('ModNewsletters.Template');

	function index(){
		$conditions = " 1 = 1 ";

		$this->paginate = array(
			'conditions' => $conditions,
			'limit' => Configure::read('rows_per_page')
		);

		$results = $this->paginate('Template');
		$this->set('results', $results);
		
		if ( isset($this->data['act']) ){
			switch($this->data['act']){
				case "render_items_list":
					$this->render('/elements/templates_list');
				break;
			}
		}		
		
	}

	function list_js(){
		$this->layout = "";
		$this->autoRender = true;
		$this->set('templates', $this->Template->find('all') );
	}
	
	function delete(){
		foreach ( $this->data['Items']['id'] as $id ){
			$this->Template->delete($id);
		}
		die();
	}

	function edit($id = false){
		if ( isset($this->data['Template'] ) ){
			$this->Template->set( $this->data );
			if ( $this->Template->validates() ){
				$out = $this->Template->save($this->data, false);
			} else {
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $this->Template->invalidFields());
			}
		}
		$this->autoRender = true;
		$this->set('template', $this->Template->findById($id) );
	}

	function render_template($id){
		$template_path	= Configure::read('_UPLOAD_FOLDER').Configure::read('_APP.user_setup.uploadFolder')."/templates/template-{$id}/template-{$id}.html";
		die(file_get_contents($template_path));
	}

	function add($form = false){
		if ( isset($this->data['Template']) && !$form ){
			$this->Template->set( $this->data );
			if ( $this->Template->validates() ){
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
?>