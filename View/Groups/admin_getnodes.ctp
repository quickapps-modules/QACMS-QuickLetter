<?php
$data = array();

foreach ($nodes as $node) {
    $del = ($node['Group']['id'] != 1) ? $html->image("/{$this->plugin}/img/delete_mini.gif", array('border' => 0, 'onclick' => "javascript: delete_list_form({$node['Group']['id']});")) : "";
    $data[] = array(
        "text" => "<span class='inPlaceEdit' id='node_{$node['Group']['id']}'>{$node['Group']['name']}</span> {$del}",
        "id" => $node['Group']['id'],
        "cls" => "folder",
        "leaf" => ($node['Group']['lft'] + 1 == $node['Group']['rgt'])
    );
}

echo $javascript->object($data);

?>