<?php 
class CfieldHelper extends AppHelper {
	var $wysiwyg = array(); # guarda las id's de todos los campos tipo textarea que usan editor HTML
	
	
	/**
	 * Renderiza campos de formulario dinámicos.
	 *
	 * @param array $fdata:Array  - Datos del elemento de formulario (tipo, max long, etc).
	 * @param boolean $cdata:String - Datos (contenido) del elemento a renderizar.
	 * @param boolean $options:Array - array con opciones.
	 * @link 
	 */
	function render($fdata, $_cdata = null, $settings = array() ){
		/*
			array(
				'Model' => array(
					'cdata' => array(
						'id' => array( # field_id
							'value' => :String #Valor del campo
							'id' => :Integer #Id del registro en Cdata (opcional, utilizado en caso de actualizacion de datos)
						)
					)
				)
			)
		*/
		if ( !is_array($fdata) )
			return;
		
		
		$settings = array_merge(
			array(
				'field' => true, # true = renderiza el elemento de formulario, false = renderiza el contenido -> $cadata debe ser indicado
				'model' => null, # used in !field mode, Name of the Model which will process the form data
				'label' => false, 
				'attributes' => array()
			)
		, (array)$settings );
		
		if ( !$settings['field'] && empty($cdata) )
			return false;
		
		$out = '';
		$cdata = ( isset($_cdata['value']) ) ? $_cdata['value'] : $_cdata;
		$model = ( $settings['field'] && is_null($settings['model']) ) ? $this->params['models'][0] : $settings['model'];
		$cdata_id = ( isset($_cdata['id']) && is_numeric($_cdata['id']) && $_cdata['id'] > 0 ) ? " <input type=\"hidden\" name=\"data[{$model}][cdata][{$fdata['id']}][id]\" value=\"{$_cdata['id']}\" >\n" : "";
		
		$attributes = '';
		$label = ($settings['label']) ? "<label class=\"cdata-label\">{$fdata['lname']}:</label> " : "";
		
		if ( is_array($settings['attributes']) ){
			foreach ( $settings['attributes'] as $key => $value ){ $attributes .= " {$key}=\"{$value}\" "; }
		} elseif ( is_string($settings['attributes']) ) {
			$attributes .= $settings['attributes'];
		}
		
		switch($fdata['type']) {
			case "checkbox" :
				if($fdata['options'] != '') {
					$options = explode("\n", $fdata["options"]);
					$values    = (($cdata) ? explode(", ", $cdata) : array()); ### OJO EL ESPACIO :  ",_"
					$out .= (!$settings['field']) ? "{$label}<br/>" : "";
					foreach($options as $option) {
						$pieces = explode("=", $option);
						$out .= (!$settings['field']) ? "&nbsp;&nbsp;- <span {$attributes}>{$pieces[1]}: </span>".(   (   @in_array($pieces[0], $values)  ) ? " Si " : " No ")."<br/>\n" : "<input {$attributes} type=\"checkbox\" id=\"cfield-{$fdata['id']}\" name=\"data[{$model}][cdata][{$fdata['id']}][value][]\" value=\"{$pieces[0]}\" ".(   (   @in_array($pieces[0], $values)  ) ? " checked=\"checked\"" : "")."> - {$pieces[1]}<br/>\n";
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
				if($fdata["options"] != '') {
					$out .= (!$settings['field']) ? "<br/>" : "";
					$values    = (($cdata) ? explode(", ", $cdata) : array()); ### OJO EL ESPACIO :  ",_"
					$options = explode("\n", $fdata["options"]);
					foreach($options as $option) {
						$pieces = explode("=", $option);
						$out .= (!$settings['field']) ? "{$label} <span {$attributes}>&nbsp;&nbsp;- {$pieces[1]}: </span>".(   (   @in_array($pieces[0], $values)  ) ? _(" Si ") : _(" No "))."<br/>\n" : "{$label} <input {$attributes} type=\"radio\" name=\"data[{$model}][cdata][{$fdata['id']}][value]\" id=\"cfield-{$fdata['id']}\" value=\"{$pieces[0]}\" ".(  ($cdata == $pieces[0]) ? " checked=\"checked\"" : "" )."> - {$pieces[1]}<br/>\n";
					}
					$out .= $cdata_id;
				}
			break;
			
			case "select" :
				if($fdata["options"] != "") {
					$options = explode("\n", $fdata['options']);
					if ( !$settings['field'] ) {
						$out .= "{$label}<br/><span {$attributes}>{$fdata["options"]}</span><br/>\n";
					} else {
						$out .= "{$label} <select {$attributes} name=\"data[{$model}][cdata][{$fdata['id']}][value]\" id=\"cfield-{$fdata['id']}\">\n";
						foreach($options as $option) {
							$pieces = explode("=", $option);
							$pieces[0] = trim($pieces[0]);
							$out .= "<option value=\"{$pieces[0]}\" ".(  ($cdata == $pieces[0]) ? " selected=\"selected\"" : "" ).">{$pieces[1]}</option>\n";
						}
						$out .= "</select>\n";
					}
					
					$out .= $cdata_id;
				}
			break;
			
			case "textarea" :
				$out .= ( !$settings['field'] ) ? "{$label}<br/><div class=\"cdata_textarea\" {$attributes}>{$cdata}</div><br/>\n" : "{$label}<br/><textarea {$attributes} id=\"cfield-{$fdata['id']}\" name=\"data[{$model}][cdata][{$fdata['id']}][value]\" style=\"width: 98%; height: 75px\">{$cdata}</textarea>\n";
				$out .= $cdata_id;
				
				if ( $fdata['wysiwyg'] && $settings['field']  )
					$this->wysiwyg[] = "cfield-{$fdata['id']}";
				
			break;
			
			case "textbox" :
				$out .= ( !$settings['field'] ) ?  "{$label}<span {$attributes}>{$cdata}</span>\n" : "{$label}<input {$attributes} type=\"text\" id=\"cfield-{$fdata['id']}\" name=\"data[{$model}][cdata][{$fdata['id']}][value]\" value=\"{$cdata}\"".((strlen($fdata['length']) > 0) ? " ".(  ($fdata['length'] > 0)   ? "maxlength=\"{$fdata['length']}\"" : ""    ) : "")." />\n";
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