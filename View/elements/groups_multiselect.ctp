<select id="groups" name="data[Import][groups]" size="5"
	multiple="multiple" style="width: 300px;">
	<?php
	foreach($groups as $id => $name){
		$_name	= r("&nbsp;", "", $name);
		$sep	= r($_name, "", $name);
		e("<option value=\"{$id}\">{$sep} {$_name}</option>\n");
	}
	?>
</select>
