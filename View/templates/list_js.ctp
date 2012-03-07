var tinyMCETemplateList = [


<?php

$out = array();
foreach ( $templates as $template ){
	$out[] = "\t['{$template['Template']['name']}', '".$html->url("/{$this->plugin}/templates/render_template/{$template['Template']['id']}")."', '{$template['Template']['description']}']";
}
echo implode(", \n", $out);

?>

];
