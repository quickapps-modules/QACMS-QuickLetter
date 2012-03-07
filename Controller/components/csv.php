<?php
class CsvComponent extends Object {
	var $controller;
	var $errors = array();
	var $csvHeaders = arraY();

	function startup( &$controller ) {
		$this->controller = &$controller;
	}

	function upload($file_data = false, $options = array('folder' => false, 'file_name' => 'csvimport_mod_newsletters')){
		$folder = (!$options['folder']) ? APP."tmp".DS."cache".DS : $options['folder'];
		if ( is_string($file_data) ){
			if ( !empty($file_data) ){
				$createCsv = fopen($folder."csvimport_mod_newsletters.csv", 'w+');
				if  ( $createCsv ) {
					fputs($createCsv, $file_data);
					fclose($createCsv);
				} else {
					$this->errors['csvtext'] = _e("File Upload Error.");
					return false;
				}
			} else {
				$this->errors['csvtext'] = _e("Empty csv data.");
				return false;
			}
		} else {
			App::import('Lib', 'ModNewsletters.upload');
			$file_data					= (!$file_data) ? $controller->data['Import']['csvfile'] : $file_data;
			$handle						= new Upload($file_data);
			$handle->file_overwrite		= true;
			$handle->file_new_name_body	= $options['file_name'];
			$handle->file_new_name_ext 	= "csv";
			$handle->Process($folder);
				
			$old_mask = umask(0);
			if (!$handle->processed){
				$this->errors['csvfile'] = _e("File Upload Error.");
				return false;
			}
			umask($old_mask);
			return true;
		}
	}
	
	function validates($upload = false){

		if ( !isset($this->controller->data['Import']['type']) ||
		($this->controller->data['Import']['type'] == 'csv' && !file_exists(APP."tmp".DS."cache".DS."csvimport_mod_newsletters.csv")) ||
		($this->controller->data['Import']['type'] == 'text' && empty($this->controller->data['Import']['csvtext'])) ){
				
			$this->errors['csvsource'] = _e("There is no file in the filesystem to import, please try again.");
		}

		if ( !isset($this->controller->data['Import']['groups']) || count($this->controller->data['Import']['groups']) == 0 ) {
			$this->errors['groups'] = _e("You must select at least one group to import these subscribers into under 'Imported Data Destination'.");
		}

		if ( !isset($this->controller->data['Import']['fields_enclosed']) ||empty($this->controller->data['Import']['fields_enclosed']) ) {
			$this->errors['fields_enclosed'] = _e("Invalid 'Enclosed By'");
		}

		if ( !isset($this->controller->data['Import']['fields_delimited']) || empty($this->controller->data['Import']['fields_delimited']) ) {
			$this->errors['fields_delimited'] = _e("Invalid 'Delimited By'");
		}
		if ( $upload ) {
			$to_upload = ( $this->controller->data['Import']['type'] == 'csv' ) ? $this->controller->data['Import']['csvfile'] : $this->data['Import']['csvtext'];
			$this->upload_file($to_upload);
		}
		
		$sess = array(
			'groups' => @$this->controller->data['Import']['groups'],
			'escape' => stripslashes(html_entity_decode($this->controller->data['Import']['fields_enclosed'])),
			'delimiter' => stripslashes(html_entity_decode($this->controller->data['Import']['fields_delimited'])),
			'firstrowfields' => $this->controller->data['Import']['options']['firstrowfields']
		);
		
		$this->controller->Session->write('Import', $sess);

		return (count($this->errors) == 0 );
	}

	function csv_headers($options = array() ){
		$options = array_merge(
			array(	'file' => false,
					'delimiter' => ',',
					'escape' => '"'
			),
			(array)$options
		);
	
		App::import('Lib', 'ModNewsletters.Cvs');
		$options['file'] = (!$options['file']) ? APP."tmp".DS."cache".DS."csvimport_mod_newsletters.csv" : $options['file'];
		$csv = new File_CSV_DataSource;
		$csv->settings(   array('delimiter' => $options['delimiter'], 'escape' => $options['escape']) );
		if ( $csv->load($options['file']) ) {
			return $this->csvHeaders = $csv->getHeaders();
		}
		
		return false;
	}
	
	function getLines( $options = array() ){
		$sess = $this->controller->Session->read('Import');
		$merge =  !empty($sess) ? $sess : $options;
		$options = array_merge(
			array(	'file' => false,
					'delimiter' => ',',
					'escape' => '"'
			),
			(array)$merge
		);
		
		App::import('Lib', 'ModNewsletters.Cvs');
		$options['file'] = (!$options['file']) ? APP."tmp".DS."cache".DS."csvimport_mod_newsletters.csv" : $options['file'];
		$csv = new File_CSV_DataSource;
		$csv->settings(   array('delimiter' => $options['delimiter'], 'escape' => $options['escape']) );
		if ( $csv->load($options['file']) ) {
			$array = $csv->getrawArray();
			if ( $this->controller->Session->read('Import.firstrowfields') ) {
				$array = array_splice($array, 1, count($array));
			}
			
			return $array;
		}
		
		return false;
	}

	function import($file = false){
		$file = (!$file) ? APP."tmp".DS."cache".DS."csvimport_mod_newsletters.csv" : $file;

	}
	
	function finish(){
		$this->controller->Session->delete('Import');
		@unlink(APP."tmp".DS."cache".DS."csvimport_mod_newsletters.csv");
		return true;
	}


}
?>