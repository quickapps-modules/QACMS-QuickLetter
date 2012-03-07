<?php 
class UsersController extends ModNewslettersAppController {
	var $name = 'Users';
	var $uses = array('ModNewsletters.User', 'ModNewsletters.Group', 'ModNewsletters.Cfield', 'ModNewsletters.Sending', 'ModNewsletters.Habtm');
	var $helpers = array('ModNewsletters.Cfield');
	var $components = array('ModNewsletters.Csv');


	function index(){
		$conditions = " 1 = 1 ";
		$joins		= array();
		if ( isset($this->data['User']['filter']) && 
			!empty($this->data['User']['filter']['by']) &&
			!empty($this->data['User']['filter']['condition'])
			){
			$conditions .= " AND User.{$this->data['User']['filter']['by']} ";
			$conditions .= ($this->data['User']['filter']['condition'] == 'equals') ? "= '{$this->data['User']['filter']['value']}'" : "LIKE '%{$this->data['User']['filter']['value']}%'";
		} elseif ( isset($this->data['User']['groupfilter']) ){

			$joins = array(
				array(
						'table' => "{$this->User->tablePrefix}newsletter_habtm", 
						'alias' => 'Habtm', 
						'type' => 'inner',  
						'conditions'=> array('Habtm.user_id = User.id') 
				),
				array(
						'table' => "{$this->User->tablePrefix}newsletter_lists", 
						'alias' => 'Group', 
						'type' => 'inner',  
						'conditions'=> array( 
							'Group.id = Habtm.list_id',
							"Group.id = {$this->data['User']['groupfilter']}" # Filter by Category id 
						)
				)
			);
		}

		$this->paginate = array(
			'conditions' => $conditions,
			'joins' => $joins,
			'limit' => Configure::read('rows_per_page'),
			'order' => array( 'User.created' => 'DESC' )
		);

		$results = $this->paginate('User');
		$this->set('groups', $this->Group->generatetreelist(null, null, null,"&nbsp;&nbsp;&nbsp;"));
		$this->set('results', $results );
		
		if ( isset($this->data['act']) ){
			switch($this->data['act']){
				case "render_items_list":
					$this->render('/elements/users_list');
				break;
			}
		}		
	}

	function add(){
		if ( isset($this->data['User']) ){
			$this->User->set($this->data);
			if ( $this->User->validates() ){
				$this->User->save($this->data);
			} else {
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $this->User->invalidFields());
			}
		}

		$this->set("groups", $this->Group->generatetreelist(null,null,null,"&nbsp;&nbsp;&nbsp;") );
		$this->set("cfields", $this->Cfield->find('all') );
	}

	function edit($id = false){
		if ( isset($this->data['User']) ){
			$this->User->set($this->data);
			if ( $this->User->validates() ){
				$this->User->save($this->data);
			} else {
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $this->User->invalidFields());
			}
		}

		$this->data = $this->User->findById($id);
		$this->set('groups', $this->Group->generatetreelist(null,null,null,"&nbsp;&nbsp;&nbsp;") );
		$this->set("cfields", $this->Cfield->find('all') );
	}
	
	function delete(){
		foreach ( $this->data['Items']['id'] as $id ){
			$this->User->delete($id);
		}
		$this->Sending->deleteAll( array('Sending.user_id' => $this->data['Items']['id'] ) );
		die();
	}

	function unapprove(){
		$this->User->updateAll( array('User.status' => 0), array('User.id' => $this->data['Items']['id'] ) );
		die('ok');
	}

	function approve(){
		$this->User->updateAll( array('User.status' => 1), array('User.id' => $this->data['Items']['id'] ) );
		die('ok');
	}

	function import($action = false){
		
		switch ($action):
			case 'upload': #cargar csv
				$this->Csv->upload($this->params['form']['Filedata']);
			break;
					
			case 'validate': # valida datos
				if ( isset($this->data['Import']) ){
					$errors = false;
					$errors = ( $this->Csv->validates() ) ? false : true;
						
					if ( $errors ){
						header('HTTP/1.1 403 Forbidden');
						$this->cakeError('form_error', $this->Csv->errors);
					}
					
				}
				die(' ');
			break;
					
			case 'prepare': #seleccionar correspondencia de columnas
				$results = $this->Csv->csv_headers( $this->Session->read('Import') );
				$this->set('results', $results);
				$this->set("cfields", $this->Cfield->find('all') );
				$this->render('import_step2');
			break;
			
			case 'import':
			
				#simple validation
				$errors = array();
				if ( !isset($this->data['User']['name']) || empty($this->data['User']['name']) ){
					$errors['name'] = 'Name field can not be empty';
				}
				
				if ( !isset($this->data['User']['email']) || empty($this->data['User']['email']) ){
					$errors['email'] = 'Email field can not be empty';
				}
				
				$req_cfields = $this->Cfield->find('all', array('conditions' => 'Cfield.req = 1', 'recursive' => -1) );
				foreach( $req_cfields as $cfield ){
					if ( !isset($this->data['User']['cdata'][$cfield['Cfield']['id']]) || empty($this->data['User']['cdata'][$cfield['Cfield']['id']]) ){
						$errors['cfield_'.$cfield['Cfield']['id']] = 'Custom field "'.$cfield['Cfield']['lname'].'" can not be empty';
					}
				}
				
				if ( count($errors) > 0){
					header('HTTP/1.1 403 Forbidden');
					$this->cakeError('form_error', $errors);
					die('');
				}
				#########3
			
			
			
			
			
			
				$this->Session->write('Import.errors', null);
				$this->Session->write('Import.oks', null);
				
				$csv_lines = $this->Csv->getLines();
				$i = 0;
				$errors = $oks = array();
				$data = array();
				
				foreach( $csv_lines as $line ){
					
					$data[$i]['User'] = array(
						'name' => $line[$this->data['User']['name']],
						'email' => $line[$this->data['User']['email']]
					);
					
					$data[$i]['Group']['Group'] = $this->Session->read('Import.groups');
					foreach ( $this->data['User']['cdata'] as $cfield_id => $col ){
						$data[$i]['User']['cdata'][$cfield_id]['value'] = (isset($line[$col])) ? $line[$col] : null;
					}
					
					$this->User->set($data[$i]);
					if ( $this->User->validates() ){
						$oks[] = sprintf(_e("Successfully inserted [%s] into %s groups"), $data[$i]['User']['email'], count($data[$i]['Group']['Group']) );
						
					} else {
						$_error = array();
						foreach( $this->User->invalidFields() as $field => $error){
							$_error[] = $error;
						}
						
						$errors[] = implode('<br/>', $_error);
					}
					$i++;
				}
				
				@$this->User->saveAll($data);
				
				$this->Session->write('Import.errors', $errors);
				$this->Session->write('Import.oks', $oks);
				
				die(' ok ');
			break;
			
			case 'results':
				$this->render('import_step3');
			break;
			
			case 'finish':
				$this->Csv->finish();
				die(' ');
			break;
			
			case 'redirect':
				$this->redirect("/{$this->plugin}/users");
			break;
			
			default:
				$this->Csv->finish();
			break;
			
		endswitch;

		$this->set('groups', $this->Group->generatetreelist(null,null,null,"&nbsp;&nbsp;&nbsp;") );
	}
	
	function export( $download = false){
	
	
		if ( $download ){
			Configure::write('debug', 0);
			App::import('Libs', 'File');
			$File = new File(APP.'tmp'.DS.'cache'.DS.'mod_newsletters_exported_users.csv', false);
			if ( $File->exists() ){
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/x-zip-compressed");
				header("Content-Disposition: attachment; filename=mod_newsletters-export-".date(_e('Y-m-d')).".csv");
				header("Content-Transfer-Encoding: binary"); 
				header('Content-length: ' . $File->size());
				
				echo $File->read();
				exit();
			} 
			exit(_e('CSV File not found.'));
		}
	
		if ( $this->data ){
			#mini validation
				$errors = array();
				if ( !in_array('id', $this->data['Export']['Fields']) ){
					$errors['id'] = _e('The subscriber id must be present in all exports, you cannot de-select this field.');
				}
				
				if ( !isset($this->data['Export']['Group']) || count($this->data['Export']['Group']) == 0 ){
					$errors['groups'] = _e('You must select at least one group.');
				}
				
				if ( !isset($this->data['Export']['enclosed']) || empty($this->data['Export']['enclosed']) ){
					$errors['enclosed'] = _e('Encloser symbol can not be empty.');
				}
				
				if ( !isset($this->data['Export']['delimited']) || empty($this->data['Export']['delimited']) ){
					$errors['delimited'] = _e('Delimiter symbol can not be empty.');
				}
				
				if ( count($errors) > 0){
					header('HTTP/1.1 403 Forbidden');
					$this->cakeError('form_error', $errors);
					die('');
				}				
				
			#
		
		
			$user_ids = $this->Habtm->find('all', array(
													'conditions' => array( 'Habtm.list_id' => $this->data['Export']['Group'] ),
													'recursive' => -1,
													'fields' => array('user_id')
												) 
						);
						
			$user_ids = Set::extract('{n}.Habtm.user_id', $user_ids);
			
			$users = $this->User->find('all', array(
				'conditions' => array(
					'User.id' => $user_ids
				),
				'group' => 'User.email'
			));
			
			$_fields = array();
			foreach ( $this->data['Export']['Fields'] as $field ){
				$_fields[] = ( strpos($field, 'cfield-') !== false ) ? r('cfield-', '', $field) : $field;
			}
			
			$out = '';
			$out .= implode(",", $_fields)."\n";
			foreach ( $users as $user ){
				$tmp = array();
				foreach ( $this->data['Export']['Fields'] as $field ){
					$value =  ( strpos($field, 'cfield-') !== false ) ? Set::extract('/Cdata/Cfield[sname='.r('cfield-', '', $field).']/..', $user) : $user['User'][$field];
					$value = ( is_array($value) && isset($value[0]['Cdata']['value']) ) ? $value[0]['Cdata']['value'] : ( is_array($value) ? null : $value);
					$tmp[] = ( !empty($value) ) ? "{$this->data['Export']['enclosed']}{$value}{$this->data['Export']['enclosed']}" : trim(" ") ;
				}
				$out .= implode($this->data['Export']['delimited'], $tmp)."\n";
			}
			$out = stripslashes($out);
			
			App::import('Libs', 'File');
			$File = new File(APP.'tmp'.DS.'cache'.DS.'mod_newsletters_exported_users.csv', true);
			$File->write($out);
			die('ok');
		}
	
	
	$this->set('groups', $this->Group->generatetreelist(null,null,null,"&nbsp;&nbsp;&nbsp;") );
	$this->set("cfields", $this->Cfield->find('all') );
	


	/*
	case "export_list":
		$lids = implode(", ", $_POST['list_ids']);
		$users_q = $dbi->query("SELECT * FROM #__newsletter_users WHERE id IN (SELECT user_id FROM #__newsletter_user_list_relationships WHERE list_id IN ({$lids}) GROUP BY user_id);");
		while ( $line = $dbi->fetchNextObject($users_q) ){
			$users[] = Set::reverse($line);
		}
		
		foreach( $users as $key => $data ){
			$cdata_q = $dbi->query("SELECT * FROM #__newsletter_cdata WHERE user_id = {$data['id']}");
			while ( $line = $dbi->fetchNextObject($cdata_q) ){
				$users[$key][$dbi->queryUniqueValue("SELECT field_sname FROM #__newsletter_cfields WHERE id = {$line->cfield_id}")] = $line->value;
			}
		}
		
		if ( count($_POST['export']['custom']) > 0 ){
			$fields = array_merge($_POST['export']['standard'], $_POST['export']['custom'] );
		} else {
			$fields = $_POST['export']['standard'];
		}
		
		$out = "";
		$out .= implode(",", $fields)."\n";
		
		foreach ( $users as $user ) {
			foreach ( $fields as $field ) {
				$tmp[] = ( isset($user[$field]) && !empty($user[$field]) ) ? "{$_POST['csv']['fields_enclosed']}".$user[$field]."{$_POST['csv']['fields_enclosed']}" : trim(" ") ;
			}
			$out .= implode($_POST['csv']['fields_delimited'], $tmp)."\n";
			unset($tmp);
		}
		$out = stripslashes($out);
		
		$_APP['Header']	.= '<meta http-equiv="refresh" content="2; url=index.php?module=mod_8&view=users&tab=export&act=download_exported_csv" />';
		cache("mod_8-newsletter-export.csv", $out);
		
	break;
	
	case "download_exported_csv":
		$path_to_file	=  ROOT.DS."inc".DS."cache".DS."mod_8-newsletter-export.csv";
		
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/x-zip-compressed");
		header("Content-Disposition: attachment; filename=webmanager-newsletter-export-".date("Y-m-d").".csv");
		header("Content-Transfer-Encoding: binary"); 
		header('Content-length: ' . @filesize($path_to_file));
		die(file_get_contents($path_to_file));
	break;	
	
	
	
	*/
	
	
	
	
	
	
	
	
	}


}

?>