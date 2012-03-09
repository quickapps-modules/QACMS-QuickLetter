<?php
class User extends QuickLetterAppModel {
    var $name    =    'User';
    var $useTable    = 'newsletter_users';

    var $hasMany = array(
        'Cdata' => array(
            'className' => 'QuickLetter.Cdata',
            'foreignKey' => 'foreignKey',
            'dependent' => true

        )
    );

    var $hasAndBelongsToMany = array(
        'Group' => array(
            'className' => 'QuickLetter.Group',
            'joinTable' => 'newsletter_user_list_relationships',
            'foreignKey' => 'user_id',
            'with' => 'QuickLetter.Habtm',
            'associationForeignKey'  => 'list_id',
            'fields' => array('id', 'name', 'description')
        )

    );

    var $validate = array(
        'name' => array('required' => true, 'allowEmpty' => false, 'rule' => array('between', 3, 100), 'message' => "Invalid user's name."),

        'email' => array(
            'email' => array(
                'required' => true,
                'allowEmpty' => false,
                'rule' => 'email',
                'message' => 'Invalid email',
                'last' => true
            ),
            'unique' => array(
                'required' => true,
                'allowEmpty' => false,
                'rule' => 'isUnique',
                'message' => 'Email already in use'
            )
        ),

        'groups' => array('required' => true, 'allowEmpty' => false, 'rule' => array('comparison', '>', 0) , 'message' => "You must select at least one group."),
    );


    var $actsAs = array(
        'QuickLetter.Cfield' => array(
            'cfield_model' => 'QuickLetter.Cfield',
            'cdata_model' => 'QuickLetter.Cdata',
            'label' => false,
            'attributes' => array('class' => 'text')
        )
    );


    function beforeValidate() {
        $this->data['User']['groups'] = (isset($this->data['Group']['Group'])) ? count($this->data['Group']['Group']) : 0;
        return true;
    }

}

?>