<?php
class GroupsController extends QuickLetterAppController {
    var $uses = array('QuickLetter.Group', 'QuickLetter.Habtm', 'QuickLetter.User');
    var $name = 'Groups';

    function index() {
        $this->set('groups', $this->Group->generatetreelist(null,null,null,"&nbsp;&nbsp;&nbsp;"));
    }

    function delete($form = false) {
        if ($form) {
            $this->set('listData', $this->Group->findById($this->data['Group']['id']));
            $this->set('availables_lists', $this->Group->generatetreelist(null,null,null,"&nbsp;&nbsp;&nbsp;"));
            $this->render('delete_form');
        }

        if (isset($this->data['delete_form']) && isset($this->data['Group']['id'])) {
            if (isset($this->data['handle_users']) && $this->data['handle_users'] == 'delete') {
                $ids = $this->Habtm->find('all', array('fields' => array('user_id') ,'recursive' => -1, 'conditions' => "QuickLetter.list_id = {$this->data['id']}"));
                $ids = implode(", ", Set::extract("/Habtm/user_id", $ids));
                $this->User->deleteAll("User.id IN ({$ids})");
            } elseif (isset($this->data['handle_users']) && $this->data['handle_users'] == 'move') { // move
                $this->Habtm->updateAll(array('Habtm.list_id' => $this->data['move_to']), "Habtm.list_id = {$this->data['Group']['id']}");
            }
            $this->Group->removefromtree($this->data['Group']['id'], true);
        }
    }

    function getnodes() {
        $this->autoRender = true;
        $parent = intval($this->params['form']['node']);
        $nodes = array();


        if ($parent == 'root') {
            $roots = $this->Group->find('all', array('conditions' => "Group.parent_id = 0", 'order' => "Group.lft ASC"));
            foreach ($roots as $root) {
                $nodes[] = $root;
            }
        } else {
            $nodes = $this->Group->children($parent, true);
        }
        // send the nodes to our view
        $this->set('nodes', $nodes);
    }

    function reorder() {

        $node = intval($this->params['form']['node']);
        $delta = intval($this->params['form']['delta']);

        if ($delta > 0) {
            $this->Group->movedown($node, abs($delta));
        } elseif ($delta < 0) {
            $this->Group->moveup($node, abs($delta));
        }

        exit('1');
    }


    function reparent() {

        $node = intval($this->params['form']['node']);
        $parent = intval($this->params['form']['parent']);
        $position = intval($this->params['form']['position']);

        $this->Group->id = $node;
        $this->Group->saveField('parent_id', $parent);

        if ($position == 0) {
            $this->Group->moveup($node, true);
        } else {
            $count = $this->Group->childcount($parent, true);
            $delta = $count-$position-1;
            if ($delta > 0) {
                $this->Group->moveup($node, $delta);
            }
        }

        // send success response
        exit('1');

    }


    function edit() {
        $itemId            = explode("_", $this->params['form']['editorId']);
        $list_id    = $itemId[1];
        $name            = $this->params['form']['value'];
        $data['Group'] = array(
            'id' => $list_id,
            'name' => $name
        );

        $this->Group->save($data);
        die($name);
    }


    function add() {
        $this->Group->save($this->data);
    }


    function render_list() {
        $this->index();
        $this->render("/elements/groups_{$this->data['render_type']}");
    }



}
?>