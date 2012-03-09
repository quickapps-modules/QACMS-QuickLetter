<?php
class QuickLetterAppController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        App::uses('QuickLetter', 'QuickLetter.Lib');

        $vars = Cache::read('newsletters_config');

        if (!$vars) {
            $vars = $this->Variable->find('all',
                array(
                    'conditions' => array(
                        'Variable.name LIKE' => 'newsletters_%s'
                   )
               )
           );

            Cache::write('newsletters_config', $vars);
        }

        foreach ($vars as $var) {
            Configure::write("Modules.Newsletters.config.{$var['Variable']['name']}", $var['Variable']['value']);
        }

        Configure::write('Modules.QuickLetter.settings.domain', env('HTTP_HOST'));
        Configure::write('Modules.QuickLetter.settings.website', substr(strtolower(env('SERVER_PROTOCOL')), 0, strpos(low(env('SERVER_PROTOCOL')), '/')) . '://'. env('HTTP_HOST'));
    }
}