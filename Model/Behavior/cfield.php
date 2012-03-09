<?php
class CfieldBehavior extends ModelBehavior {

/**
 * wysiwyg ids
 *
 * @var array
 */
    var $wysiwyg = array(); # guarda las id's de todos los campos tipo textarea que usan editor HTML, "cfield-x"

/**
 * Defaults
 *
 * @var array
 * @access protected
 */
    var $_defaults = array(
        'cfield_model' => 'Cfield',
        '__cfield_model_alias' => 'Cfield',

        'cdata_model' => 'Cdata',
        '__cdata_model_alias' => 'Cdata',

        'belongsTo' => null, #indica si el campo pertenece al un modelo

        'validateCfield' => true,
        'cfield_recursive' => 2


    );

    function cfieldRecursive(&$Model, $r) {
        $this->settings[$Model->alias]['cfield_recursive'] = $r;
    }

    function setup(&$Model, $config = array()) {
        if (!is_array($config)) {
            $config = array('model' => $config);
        }
        $settings = array_merge($this->_defaults, $config);

        $mAlias = explode('.', $settings['cfield_model']);
        $mAlias = isset($mAlias[1]) ? $mAlias[1] : $mAlias;

        $settings['__cfield_model_alias'] = $mAlias;
        $this->settings[$Model->alias] = $settings;
    }

    function cfieldNoValidate(&$Model) {
        $this->settings[$Model->alias]['validateCfield'] = false;
    }

    function bindCfield(&$Model) {
        $conditions = !empty($this->settings[$Model->alias]['belongsTo']) ?
            "Cdata.belongsTo = '{$this->settings[$Model->alias]['belongsTo']}' " :
            '';

        $Model->bindModel(
            array(
                'hasMany' => array(
                    'Cdata' => array(
                        'className' => $this->settings[$Model->alias]['cdata_model'],
                        'foreignKey' => 'foreignKey',
                        'dependent' => true, /*!important*/
                        'conditions' => $conditions
                    )
                )
            )
        );
    }

    function unbindCfield(&$Model) {
        $Model->unbindModel(
            array(
                'hasMany' => array(    'Cdata'    )
            )
        );
    }

    function beforeValidate(&$Model) {
        if (isset($Model->data[$Model->alias]) && $this->settings[$Model->alias]['validateCfield']) {

            $belongsTo = (isset($this->settings[$Model->alias]['belongsTo']) && !empty($this->settings[$Model->alias]['belongsTo']))  ? "{$this->settings[$Model->alias]['__cfield_model_alias']}.belongsTo = '{$this->settings[$Model->alias]['belongsTo']}' AND " : "";
            $cfields = Classregistry::init($this->settings[$Model->alias]['cfield_model'])->find('all',
                        array('conditions' => "{$belongsTo}
                        ({$this->settings[$Model->alias]['__cfield_model_alias']}.validate_on = 'create' OR
                          {$this->settings[$Model->alias]['__cfield_model_alias']}.validate_on = 'update' OR
                          {$this->settings[$Model->alias]['__cfield_model_alias']}.req = 1
                        )")
                    );

            foreach ($cfields as $cfield) {
                if ($cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['type'] != 'linebreak') {
                    $rule = !empty($cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['pattern']) ?
                            $cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['pattern'] :
                            'notEmpty';

                    $value = (isset($Model->data[$Model->alias]['cdata'][$cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['id']]['value'])) ?
                                 $Model->data[$Model->alias]['cdata'][$cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['id']]['value'] :
                                 null;

                    $value = is_array($value) ? implode(',', $value) : $value; /*?*/

                    $message = !empty($cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['validation_message']) ?
                                $cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['validation_message']  :
                                sprintf(__t("%s, Required"), $cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['lname']);


                    if ((is_array($rule) && $rule[0] == 'isUnique') || (is_string($rule) && $rule == 'isUnique')) {
                        $Cdata = Classregistry::init($this->settings[$Model->alias]['cdata_model']);
                        if ($Cdata->find('count',
                            array(
                                'conditions' => array(
                                    'value' => $value,
                                    'foreignKey <>' => ( (isset($Model->data[$Model->alias]['id'])) ? $Model->data[$Model->alias]['id'] : null   )
                                )
                            )
                        ) > 0) {
                            $Model->validationErrors[$cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['lname']]  = $message;
                        }
                    } else {
                        $rule = (function_exists('json_decode') && preg_match("/^\[.*\]/i", $rule)) ? json_decode($rule) : $rule;

                        $on = (in_array($cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['validate_on'], array('create', 'update'))) ?
                                $cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['validate_on'] : null;

                        $Model->validate["cfield_{$cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['id']}"] =
                            array(    'required' => true,
                                    'allowEmpty' => false,
                                    'rule' => $rule,
                                    'on' => $on,
                                    'message' => $message);

                        $Model->data[$Model->alias]["cfield_{$cfield[$this->settings[$Model->alias]['__cfield_model_alias']]['id']}"] = $value;
                    }
                }
            }
        }
    }

    function beforeDelete(&$Model, $cascade) {
        $this->bindCfield($Model);
        return true;
    }

    function afterSave(&$Model, $created) {
        if (!$this->settings[$Model->alias]['validateCfield'] || !isset($Model->data[$Model->alias]['cdata']))
            return;

        $Cdata = Classregistry::init($this->settings[$Model->alias]['cdata_model']);

        foreach ($Model->data[$Model->alias]['cdata'] as $field_id => $data) {
            $value = (is_array($data['value'])) ? implode(', ', $data['value']) : $data['value'];
            if (empty($value))
                continue;

            $id = null;
            if (isset($Model->data[$Model->alias]['cdata'][$field_id]['id'])) {
                $id = $Model->data[$Model->alias]['cdata'][$field_id]['id'];
            } elseif (!$created) {
                $id = $Cdata->find('first',
                    array('conditions' => array(
                                            'foreignKey' => $Model->id,
                                            'cfield_id' => $field_id
                                        )
                    )
                );
                $id = (!empty($id)) ? $id[$this->settings[$Model->alias]['__cdata_model_alias']]['id'] : null;
            }

            $data = array(
                $this->settings[$Model->alias]['__cdata_model_alias'] => array(
                    'id' => $id,
                    'foreignKey'    => $Model->id,
                    'cfield_id'        => $field_id,
                    'value'            => $value,
                    'belongsTo'        => $this->settings[$Model->alias]['belongsTo']
                )
            );

            $Cdata->saveAll($data, array('validate' => false));
        }
    }

    function beforeFind(&$Model, $query) {
        $this->bindCfield($Model);
        $query['recursive'] = $this->settings[$Model->alias]['cfield_recursive'];
        return $query;
    }

    function afterFind(&$Model, $results) {
        if (isset($results[0][$Model->alias])) {
            foreach ($results as $rkey => $record) {
                foreach ($record['Cdata'] as $key => $cdata) {
                    $_cfield = $cdata['Cfield'];
                    unset($cdata['Cfield']);

                    $f = $this->renderCfield($Model, $_cfield, $cdata, $this->settings[$Model->alias], $Model);

                    $results[$rkey]['Cdata'][$key]['Cfield']['preview'] = $f;
                }
            }
        }

        Configure::write($Model->alias.'.wysiwyg_ids', $this->wysiwyg);
        return $results;
    }


    /**
     * Renderiza campos de formulario dinámicos.
     *
     * @param array $fdata:Array  - Datos del elemento de formulario (tipo, max long, etc).
     * @param boolean $cdata:String - Datos (contenido) del elemento a renderizar.
     * @param boolean $options:Array - array con opciones.
     * @link
     */
    function renderCfield(&$Model, $fdata, $_cdata = null, $settings = array(), &$Model) {
        /*
            array(
                'Model' => array(
                    'cdata' => array(
                        'id' => array(# field_id
                            'value' => :String #Valor del campo
                            'id' => :Integer #Id del registro en Cdata (opcional, utilizado en caso de actualizacion de datos)
                        )
                    )
                )
            )
        */

        if (!is_array($fdata) || empty($fdata))
            return;


        $settings = array_merge(
            array(
                'field' => true, # true = renderiza el elemento de formulario, false = renderiza el contenido -> $cadata debe ser indicado
                'model' => null, # used in !field mode, Name of the Model which will process the form data
                'label' => true,
                'attributes' => array()
            )
        , (array) $settings);

        if (!$settings['field'] && empty($cdata))
            return false;

        $out = '';
        $cdata = (is_array($_cdata)) ? $_cdata['value'] : $_cdata;
        $cdata = (    empty($cdata) &&
                    isset($Model->data['cdata'][$fdata['id']]['value'])  &&
                    !empty($Model->data['cdata'][$fdata['id']]['value'])
                )
                    ? $Model->data['cdata'][$fdata['id']]['value'] : $cdata;

        $model = ($settings['field'] && is_null($settings['model'])) ? $Model->alias : $settings['model'];
        $cdata_id = (isset($_cdata['id']) && is_numeric($_cdata['id']) && $_cdata['id'] > 0) ? " <input type=\"hidden\" name=\"data[{$model}][cdata][{$fdata['id']}][id]\" value=\"{$_cdata['id']}\" >\n" : "";

        $attributes = '';
        $label = ($settings['label']) ? "<label class=\"cdata-label\">{$fdata['lname']}:</label> " : "";

        if (is_array($settings['attributes'])) {
            foreach ($settings['attributes'] as $key => $value) { $attributes .= " {$key}=\"{$value}\" "; }
        } elseif (is_string($settings['attributes'])) {
            $attributes .= $settings['attributes'];
        }

        switch ($fdata['type']) {
            case "checkbox" :
                if ($fdata['options'] != '') {
                    $options = explode("\n", $fdata["options"]);
                    $values    = (($cdata) ? explode(", ", $cdata) : array()); ### OJO EL ESPACIO :  ",_"
                    $out .= (!$settings['field']) ? "{$label}<br/>" : "";
                    foreach ($options as $option) {
                        $pieces = explode("=", $option);
                        $out .= (!$settings['field']) ? "&nbsp;&nbsp;- <span {$attributes}>{$pieces[1]}: </span>".(  (  @in_array($pieces[0], $values) ) ? " Si " : " No ")."<br/>\n" : "<input {$attributes} type=\"checkbox\" id=\"cfield-{$fdata['id']}\" name=\"data[{$model}][cdata][{$fdata['id']}][value][]\" value=\"{$pieces[0]}\" ".(  (  @in_array($pieces[0], $values) ) ? " checked=\"checked\"" : "")."> - {$pieces[1]}<br/>\n";
                    }
                    $out .= $cdata_id;
                }
            break;

            case "hidden" :
                $out .=  (!$settings['field']) ? "<span {$attributes}>{$fdata["options"]}</span><br/>\n" : " <input {$attributes} type=\"hidden\" id=\"cfield-{$fdata['id']}\" name=\"data[{$model}][cdata][{$fdata['id']}][value]\" value=\"{$fdata["options"]}\" >\n";
                $out .= $cdata_id;
            break;

            case "linebreak" :
                $out .= "<hr {$attributes} />\n";
            break;

            case "radio" :
                if ($fdata["options"] != '') {
                    $out .= (!$settings['field']) ? "<br/>" : "";
                    $values    = (($cdata) ? explode(", ", $cdata) : array()); ### OJO EL ESPACIO :  ",_"
                    $options = explode("\n", $fdata["options"]);
                    foreach ($options as $option) {
                        $pieces = explode("=", $option);
                        $out .= (!$settings['field']) ? "{$label} <span {$attributes}>&nbsp;&nbsp;- {$pieces[1]}: </span>".(  (  @in_array($pieces[0], $values) ) ? _(" Si ") : _(" No "))."<br/>\n" : "{$label} <input {$attributes} type=\"radio\" name=\"data[{$model}][cdata][{$fdata['id']}][value]\" id=\"cfield-{$fdata['id']}\" value=\"{$pieces[0]}\" ".( ($cdata == $pieces[0]) ? " checked=\"checked\"" : "")."> - {$pieces[1]}<br/>\n";
                    }
                    $out .= $cdata_id;
                }
            break;

            case "select" :
                if ($fdata["options"] != "") {
                    $options = explode("\n", $fdata['options']);
                    if (!$settings['field']) {
                        $out .= "{$label}<br/><span {$attributes}>{$fdata["options"]}</span><br/>\n";
                    } else {
                        $out .= "{$label} <select {$attributes} name=\"data[{$model}][cdata][{$fdata['id']}][value]\" id=\"cfield-{$fdata['id']}\">\n";
                        foreach ($options as $option) {
                            $pieces = explode("=", $option);
                            $pieces[0] = trim($pieces[0]);
                            $out .= "<option value=\"{$pieces[0]}\" ".( ($cdata == $pieces[0]) ? " selected=\"selected\"" : "").">{$pieces[1]}</option>\n";
                        }
                        $out .= "</select>\n";
                    }

                    $out .= $cdata_id;
                }
            break;

            case "textarea" :
                $out .= (!$settings['field']) ? "{$label}<br/><div class=\"cdata_textarea\" {$attributes}>{$cdata}</div><br/>\n" : "{$label}<br/><textarea {$attributes} id=\"cfield-{$fdata['id']}\" name=\"data[{$model}][cdata][{$fdata['id']}][value]\" style=\"width: 98%; height: 75px\">{$cdata}</textarea>\n";
                $out .= $cdata_id;

                if ($fdata['wysiwyg'] && $settings['field'] )
                    $this->wysiwyg[] = "cfield-{$fdata['id']}";

            break;

            case "textbox" :
                $out .= (!$settings['field']) ?  "{$label}<span {$attributes}>{$cdata}</span>\n" : "{$label}<input {$attributes} type=\"text\" id=\"cfield-{$fdata['id']}\" name=\"data[{$model}][cdata][{$fdata['id']}][value]\" value=\"{$cdata}\"".((strlen($fdata['length']) > 0) ? " ".( ($fdata['length'] > 0)   ? "maxlength=\"{$fdata['length']}\"" : ""   ) : "")." />\n";
                $out .= $cdata_id;
            break;

            default :
                $out .= "&nbsp;";
            break;
        }

        return $out;
    }

}
?>