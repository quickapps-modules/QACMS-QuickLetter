<?php 
class UninstallComponent extends Object {
	var $controller;

	function startup( &$controller ) {
		$this->controller = &$controller;
	}
	
	function beforeUninstall(){
		echo 'ModNewsletters.beforeUninstall<br/>';
	}
	
	function afterUninstall(){
		echo 'ModNewsletters.afterUninstall<br/>';
	}
}
?>