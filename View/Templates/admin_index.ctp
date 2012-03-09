<?php
    $tSettings = array(
        'columns' => array(
            __d('quick_letter', 'Title') => array(
                'value' => '<a href="{url}/admin/quick_letter/templates/edit/{Template.id}{/url}">{Template.title}</a>',
                'tdOptions' => array('width' => '40%', 'align' => 'left'),
                'sort' => 'Template.title'
            ),
            __d('quick_letter', 'Description') => array(
                'value' => '{Template.description}',
                'sort' => 'Template.description'
            )
        ),
        'noItemsMessage' => __t('There are no templates to display'),
        'paginate' => true,
        'headerPosition' => 'top',
        'tableOptions' => array('width' => '100%', 'class' => 'templates-list'),
    );

    echo $this->Html->table($results, $tSettings);