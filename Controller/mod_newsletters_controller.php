<?php
class ModNewslettersController extends ModNewslettersAppController {

	var $name = 'ModNewsletters';
	var $uses = array();

	function index(){
		$this->redirect("/{$this->plugin}/messages");
	}

}
?>
