<?php
foreach( $groups as $id => $name){

	$_name	= r("&nbsp;", "", $name);
	$sep	= r($_name, "", $name);
	$checked = ( isset($this->data['User']) && in_array($id, Set::extract("/id", $this->data['Group']) ) ) ? ' checked="checked" ': '  ';

	e("{$sep} <input type='checkbox' value='{$id}' name='data[Group][Group][]' {$checked} /> &nbsp; {$_name}<br/>");
}

?>
