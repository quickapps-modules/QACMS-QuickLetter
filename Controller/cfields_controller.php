<?php
class CfieldsController extends ModNewslettersAppController {

	var $name = 'Cfields';
	var $uses = array('ModNewsletters.Cfield');
	var $helpers = array('ModNewsletters.Cfield');

	
	function index(){
		$results = $this->Cfield->find('all' );
		$this->set('results', $results);
		
		if ( isset($this->data['act']) && $this->data['act'] == 'render_items_list' ){
			$this->autoRender = false;
			$this->render('/elements/cfields_list');
		}
	}
	
	function delete(){
		$ids = $this->data['Items']['id']; // array()
		/* no funciona delte en cascada
		$this->Cfield->bindModel(
			array(
				'hasMany' => array(
					'Cdata' => array(
						'className' => 'ModNewsletters.Cdata',
						'dependent' => true
					)
				)
			)
		);
		*/
		$this->Cfield->deleteAll(
			array(
				'Cfield.id' => $ids
			)
		);
		
		Classregistry::init('ModNewsletters.Cdata')->deleteAll(
			array(
				'Cdata.cfield_id' => $ids
			)
		);
		
		
		die('ok');
	
	}
	
	function reorder(){
		foreach($this->data['Cfield']['ordering'] as $id => $ordering){
			$data['Cfield'] = array(
				'id' => $id,
				'ordering' => $ordering
			);
			
			$this->Cfield->save($data);
		
		}
		
		$results = $this->Cfield->find('all' );
		$this->set('results', $results);
		
		$this->render('/elements/cfields_list');
	
	}
	
	function add(){
		$this->autoRender = true;
		if ( $this->data ){
			$this->Cfield->set($this->data);
			
			if ( $this->Cfield->validates() ){
				$this->Cfield->saveAll();
				
				$results = $this->Cfield->find('all' );
				$this->set('results', $results);
				$this->autoRender = false;
				$this->render('/elements/cfields_list');
			} else {
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $this->Cfield->invalidFields());
			}
			
		}
	}
	
	function edit($id){
		$this->autoRender = true;
		if ( $this->data ){
			$this->Cfield->set($this->data);
			
			if ( $this->Cfield->validates() ){
				$this->Cfield->saveAll();
				
				$results = $this->Cfield->find('all' );
				$this->set('results', $results);
				$this->autoRender = false;
				$this->render('/elements/cfields_list');
			} else {
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $this->Cfield->invalidFields());
			}			
			
		}
		
		$this->data = $this->Cfield->findById($id);
		
	}
	
	
}
?>