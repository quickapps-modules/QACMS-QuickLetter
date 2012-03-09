<?php
class QuickLetterController extends QuickLetterAppController {
    public $uses = array();

    public function admin_index() {
        $this->redirect('/admin/quick_letter/messages');
    }
}