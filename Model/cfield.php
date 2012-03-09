<?php
class Cfield extends QuickLetterAppModel {
    var $name        = 'Cfield';
    var $useTable     = 'newsletter_cfields';
    var $order        = array('Cfield.belongsTo' => 'ASC', 'Cfield.ordering' =>  'ASC') ;


    var $validate = array(    'type' => array('required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 200), 'message' => 'Invalid field type.'),

                            'sname' => array(
                                'alphaNumeric' => array('required' => true, 'allowEmpty' => false, 'rule' => array('custom', '/^[a-z0-9_]{3,16}$/i'), 'message' => 'Short name must only contain letters and numbers. between 3-16 characters are required (character \'_\' is allowed).'),
                                'isUnique' =>       array('required' => true, 'allowEmpty' => false, 'rule' => 'isUnique', 'message' => 'Short name invalid or already in use.')
                            ),

                            'length' => array('required' => false, 'allowEmpty' => true, 'rule' => 'numeric' , 'message' => 'Max length must be a number.')
    );

    function beforeValidate() {
        if (in_array($this->data['Cfield']['type'],
                array('hidden', 'select', 'radio', 'checkbox'))
            ) {
            $this->validate['options'] = array('required' => true, 'allowEmpty' => false, 'rule' => array('validate_cfield_options') , 'message' => 'Options required for this type of field.');
        }
        return true;
    }

    function validate_cfield_options($check) {
        $text = $check['options'];
        if (strlen(trim($text)) < 1) {
            return false;
        } else {
            $fix_lf    = str_replace("\r", "\n", trim($text));
            $fix_lf    = str_replace("\n\n", "\n", $fix_lf);
            $options    = explode("\n", $fix_lf);
            if (@count($options) < 1) {
                return false;
            } else {
                foreach ($options as $option) {
                    $pieces = explode("=", $option);
                    if (@count($pieces) < 1) {
                        return false;
                    } else {
                        if (strlen(trim($pieces[0])) < 1) {
                            return false;
                        } else {
                            if (strlen(trim($pieces[1])) < 1) {
                                return false;
                            }
                        }
                    }
                }
            }
        }

        return true;
    }


}
?>