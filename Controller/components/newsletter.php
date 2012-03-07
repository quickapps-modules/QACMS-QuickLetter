<?php

class NewsletterComponent extends Object {
	var $controller;

	function startup( &$controller ) {
		$this->controller =& $controller;
	}

	function tag_r($text, $user_data = null){
		$text = eregi_replace('\[SUBSCRIBEURL\]', Configure::read('Newsletter.config.subscribe_url'), $text);
		$text = eregi_replace('\[UNSUBSCRIBEURL\]', Configure::read('Newsletter.config.unsubscribe_url'), $text);
		$text = eregi_replace('\[PREFERENCESURL\]', Configure::read('Newsletter.config.preferences_url'), $text);
		$text = eregi_replace('\[CONFIRMATIONURL\]', Configure::read('Newsletter.config.confirmation_url'), $text);

		$text = preg_replace('/\[DOMAIN\]/i', Configure::read('Newsletter.config.domain'), $text);
		$text = preg_replace('/\[WEBSITE\]/i',  Configure::read('Newsletter.config.website'), $text);

		@$text = NewsletterComponent::get_custom_data($text, $user_data);

		return trim($text);
	}

	function get_custom_data($text, $user_data = null){
		if ( $user_data != null && is_array($user_data) ){
			$text = eregi_replace('\[userid\]', $user_data['id'], $text);
			$text = eregi_replace('\[username\]', $user_data['name'], $text);
			$text = eregi_replace('\[useremail\]', $user_data['email'], $text);
			$text = eregi_replace('\[usergender\]', $user_data['gender'], $text);
			$text = eregi_replace('\[userkey\]', $user_data['key'], $text);
			$text = eregi_replace('\[usercreated\]', $user_data['created'], $text);
			$text = eregi_replace('\[usermodified\]', $user_data['modified'], $text);
				
			/* Special custom field tags */
			$cdatas = Classregistry::init('ModNewsletters.Cdata')->find('all', array('conditions' => "Cdata.foreignKey = {$user_data['id']}") );
			foreach ( $cdatas as $cdata ){
				$text = eregi_replace("\[{$cdata['Cfield']['sname']}\]", $cdata['Cdata']['value'], $text);
			}
		}

		return $text;
	}

	function send_iframe($id, $iframe_action){
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
		echo "\t<head>\n";
		echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n";
		echo "\t</head>\n";
		echo "<body>\n";


		if ( !$id ){
			echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
			echo "\talert('"._e("Failed to locate a queue identifier in your request.\\n\\nPlease ensure you provide a valid queue identifier to the engine.")."');\n";
			echo "</script>\n";
			echo "</body>\n";
			echo "</html>\n";
			exit;
		} else {
			App::import('Helper', 'Html');
			$html = new HtmlHelper;
			$this->controller->Queue->bindModel(
				array('belongsTo' => array(
										'Message' => array(
											'className' => 'ModNewsletters.Message'
										)
									)
				)
			);
			
			$queueData = $this->controller->Queue->findById($id);
		}

		switch ($iframe_action){

			case "cancel":
				$this->controller->Sending->deleteAll("Sending.queue_id = {$queueData['Queue']['id']}");
				$this->controller->Queue->save( array( 'Queue' => array('status' => 'Cancelled', 'id' => $queueData['Queue']['id'])) );
				$this->controller->Sending->optimize();

				echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
				echo "\tparent.document.getElementById('buttonHTML').innerHTML  = '';\n";
				echo "\tparent.document.getElementById('progressText').innerHTML = '"._e("Successfully cancelled... returning to the queue message in 5 seconds.")."';\n";
				echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-blue\">"._e("Successfully cancelled... returning to the message centre in 5 seconds.")."</span><br/>';\n";
				echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
				echo "\tsetTimeout('parent.window.location=\'".$html->url("/{$this->controller->plugin}/messages")."\'', 5000);";
				echo "</script>\n";

				break;
					
			case "pause":
				$this->controller->Queue->save( array( 'Queue' => array('status' => 'Paused', 'touch' => time(), 'id' => $queueData['Queue']['id'] )) );
				$this->controller->Sending->optimize();

				echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
				echo "\tparent.document.getElementById('buttonHTML').innerHTML  = '<button class=\"primary_lg\" onclick=\"$(\'workerFrame\').src = \'".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/resume")."\';\">"._e("Resume")."</button>';\n";
				echo "\tparent.document.getElementById('progressText').innerHTML  = '"._e("This send has been paused.")."';\n";
				echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-blue\">"._e("This send has been paused.")."</span><br/>';\n";
				echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
				echo "</script>\n";
					
				@flush();
				@ob_flush();
				break;
					
			case "resume":
				$this->controller->Queue->save( array( 'Queue' => array('status' => 'Resuming', 'touch' => time(), 'id' => $queueData['Queue']['id'] )));

				echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
				echo "\tparent.document.getElementById('buttonHTML').innerHTML  = '';\n";
				echo "\tparent.document.getElementById('progressText').innerHTML  = '"._e("Resuming the send. Please wait...")."';\n";
				echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">"._e("Resuming the send. Please wait...")."</span><br/>';\n";
				echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
				echo "\twindow.location='".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/send", true)."';";
				echo "</script>\n";

				@flush();
				@ob_flush();
				break;
					
			case "queue": /* poner en cola */
				if ($queueData['Queue']['status'] == 'Complete' ){

					echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
					echo "\tparent.document.getElementById('progressBar').style.display = 'none'\n";
					echo "\tparent.document.getElementById('progressText').innerHTML = '"._e("This queue has been sent!...")."';\n";
					echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-error\">"._e("This queue has been sent!...")."</span><br/>';\n";
					echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
					echo "\tparent.document.getElementById('buttonHTML').innerHTML  = '<button class=\"primary_lg\" onclick=\" window.location.href = \\'".$html->url("/{$this->controller->plugin}/queue", true)." \\'\">"._e("Finish")."</button>';\n";
					echo "</script>\n";
					echo "</body>\n";
					echo "</html>\n";
					exit;
				}
					
				$this->controller->Queue->save(array( 'Queue' => array('status' => 'Preparing', 'id' => $queueData['Queue']['id'] )));

				echo "<script language=\"JavaScript\" type=\"text/javascript\">parent.document.getElementById('progressText').innerHTML = '"._e("Preparing data to generate the queue. Please wait...")."';</script>\n";
				echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">"._e("Preparing data to generate the queue. Please wait...")."</span><br/>';\n";
				echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
				echo "</script>\n";
				@flush();
				@ob_flush();

				sleep(1);


				echo "<script language=\"JavaScript\" type=\"text/javascript\">parent.document.getElementById('progressText').innerHTML = '"._e("Inserting queue data into the database. Please wait...")."';</script>\n";
				echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">"._e("Inserting queue data into the database. Please wait...")."</span><br/>';\n";
				echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
				echo "</script>\n";
				@flush();
				@ob_flush();

				### prevent browser refreshes ###
				$this->controller->Sending->deleteAll("Sending.queue_id = {$queueData['Queue']['id']}");
				#################################

				## si un poco feo, pero no hay forma
				$query = $this->controller->Sending->query("INSERT INTO `{$this->controller->Sending->tablePrefix}newsletter_sending` (`html`, `email`, `user_id`, `queue_id`)
							SELECT `User`.`html_email`,`User`.`email`, `User`.`id`, {$queueData['Queue']['id']} FROM `{$this->controller->Sending->tablePrefix}newsletter_users` AS `User` WHERE `User`.`status` = 1 AND `User`.`id` IN (SELECT `user_id` FROM `{$this->controller->Sending->tablePrefix}newsletter_habtm` AS `Habtm` WHERE `Habtm`.`list_id` IN ({$queueData['Queue']['target']}) ) GROUP BY `User`.`email`");

				if ( empty($query) ){
					$this->controller->Queue->delete($queueData['Queue']['id']);
					$this->controller->Sending->deleteAll("Sending.queue_id = {$queueData['Queue']['id']}");
						
					echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
					echo "\tparent.document.getElementById('progressText').innerHTML = '"._e("No users to load into queue.")."';\n";
					echo "\talert('"._e("There were no users in any of the lists you selected to load into the sending queue.\\n\\nPlease choose a list to send to which contains users.")."');\n";
					echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-error\">"._e("There were no users in any of the lists you selected to load into the sending queue. Please choose a list to send to which contains users.")."</span><br/>';\n";
					echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
					echo "</script>\n";
					echo "</body>\n";
					echo "</html>\n";
					exit;
				}

				$num = $this->controller->Sending->find('count', array('conditions' => "Sending.queue_id =  {$queueData['Queue']['id']}") );
				if ( $num <= 0 ){

					$this->controller->Queue->delete($queueData['Queue']['id']);
					$this->controller->Sending->deleteAll("Sending.queue_id = {$queueData['Queue']['id']}"); ### no requerido..pero por seguridad...

					echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
					echo "\tparent.document.getElementById('progressText').innerHTML = '"._e("No users to load into queue.")."';\n";
					echo "\talert('"._e("There were no users in any of the lists you selected to load into the sending queue.\\n\\nPlease choose a list to send to which contains users.")."');\n";
					echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-error\">"._e("There were no users in any of the lists you selected to load into the sending queue.\\n\\nPlease choose a list to send to which contains users.")."</span><br/>';\n";
					echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
					echo "</script>\n";
					echo "</body>\n";
					echo "</html>\n";
					exit;
				}


				echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
				echo "function readyToGo() {\n";
				echo "\tvar is_confirmed = confirm('".sprintf(_e("Your message has been successfully queued and is ready to be sent to %s unique e-mail address.\\n\\nIf you would like to proceed to send this message press OK, otherwise click Cancel to cancel the queue and return to the message centre."), $num )."');\n";
				echo "\tif (is_confirmed == true) {\n";
				echo "\t\twindow.location='".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/send", true)."';\n";
				echo "\t\treturn;\n";
				echo "\t} else {\n";
				echo "\t\twindow.location='".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/cancel", true)."';\n";
				echo "\t\treturn;\n";
				echo "\t}\n";
				echo "}\n\n";
				echo "parent.document.getElementById('progressText').innerHTML = '".sprintf(_e("Successfully inserted %s address into the sending queue."),$num )."';\n";
				echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">".sprintf(_e("Successfully inserted %s address into the sending queue."),$num )."</span><br/>';\n";
				echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
				echo "readyToGo();\n";
				echo "</script>\n";
				@flush();
				@ob_flush();


				break;
					
					
			case "send":### envia los email de la tabla sending
				if ( !empty($queueData['Message']) ){

					if( $queueData['Queue']["status"] != "Sending") {
						$this->controller->Queue->save(array( 'Queue' => array('id' => $queueData['Queue']["id"], 'status' => 'Sending', 'touch' => time() ) ) );
					}
						
					echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
					echo "\tparent.document.getElementById('progressBar').style.display = ''\n";
					echo "\tparent.document.getElementById('progressText').innerHTML = '"._e("Sending messages. Please wait...")."';\n";
					echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">"._e("Sending messages. Please wait...")."</span><br/>';\n";
					echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
					echo "\tparent.document.getElementById('buttonHTML').innerHTML  	= '<button class=\"primary_lg\" onclick=\"$(\'workerFrame\').src = \'".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/pause", true)."\'\">"._e("Pause")."</button> &nbsp; <button class=\"primary_lg\" onclick=\"$(\'workerFrame\').src = \'".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/cancel", true)."\'\">"._e("Cancel")."</button>';\n";
					echo "</script>\n";
					@flush();
					@ob_flush();

					App::import('Lib', 'ModNewsletters.mailer');
						
					$mail             = new NL_Mailer();
					$mail->Priority   = $queueData['Message']["priority"];
					$mail->Encoding   = "8bit";
						
					$from_pieces		= explode("\" <", $queueData['Message']['from_field']);
					$mail->From       	= NewsletterComponent::tag_r(substr($from_pieces[1], 0, (@strlen($from_pieces[1])-1)));
					$mail->FromName    	= NewsletterComponent::tag_r(substr($from_pieces[0], 1, (@strlen($from_pieces[0]))));
						
					if ( strlen(trim(Configure::read('Newsletter.config.message_replyto_address'))) >0 )
						$mail->AddReplyTo(NewsletterComponent::tag_r(Configure::read('Newsletter.config.message_replyto_address')));
						
					$progress  = $queueData['Queue']['progress'];
					$errors    = 0;
					$sending = $this->controller->Sending->find('all', array('conditions' => "Sending.queue_id = {$queueData['Queue']['id']}", 'order' => 'Sending.user_id ASC', 'limit' => "{$progress},".Configure::read('Newsletter.config.messages_per_refresh')) );
					
					if ( count($sending) <= 0 ) {
						## COMPLETED ##
						$this->controller->Queue->save(array( 'Queue' => array('status' => 'Complete', 'id' => $queueData['Queue']['id'])));
						$this->controller->Sending->deleteAll("Sending.queue_id = {$queueData['Queue']['id']}"); ### no requerido..pero por seguridad...
							
						echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
						echo "\tparent.document.getElementById('progressText').innerHTML = '".sprintf(_e("Completed sending your message to %s users. Click finish to continue."), $queueData['Queue']['total'])."';\n";
						echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\"><b>".sprintf(_e("Completed sending your message to %s users. Click finish to continue."), $queueData['Queue']['total'])."</b></span><br/>';\n";
						echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
						echo "\tparent.document.getElementById('buttonHTML').innerHTML  = '<button class=\"primary_lg\" onclick=\" window.location.href = \\'".$html->url("/{$this->controller->plugin}/queue")." \\'\">"._e("Finish")."</button>';\n";
						echo "</script>\n";
						echo "</body>\n";
						echo "</html>\n";

						exit;

					} else {
						##### START SENDING #####
						foreach ( $sending as $row ){
							$progress++;
							if ( $row['Sending']['sent'] == 0){
								/* FIX */
								
								$mail->Subject = NewsletterComponent::tag_r($queueData['Message']['subject'], $row['NUser']);

								if( $row['Sending']['html'] == 1 && strlen(trim($queueData['Message']['body_html'])) > 0) { // HTML version
									$mail->Body		= NewsletterComponent::tag_r($queueData['Message']['body_html']."<br/><br/><br/>" . nl2br($queueData['Message']['footer']), $row['NUser']);
									$mail->AltBody	= NewsletterComponent::tag_r($queueData['Message']['body_text']."\n\n\n".$queueData['Message']['footer'], $row['NUser']);
								} else {
									$mail->Body    = NewsletterComponent::tag_r($queueData['Message']['body_text']."\n\n\n".$queueData['Message']['footer'], $row['NUser']);
								}

								$mail->ClearAddresses();
								$mail->AddAddress($row['NUser']['email'], $row['NUser']['name'] );

								if( $mail->Send()  ) {## Sent OK
									$this->controller->Sending->updateAll( array('Sending.sent' => 1), "Sending.id = {$row['Sending']['id']}");
										
										
									/**
									 *	Actualiza el envio de la cola tras cada envio exitoso
									 *	(OPCIONAL) a veces es mejor no saturar de consultas la BD...
									 *
									 $this->Queue->save(array( 'Queue' => array('progress' => $progress, 'touch' => time(), 'id' => $queueData['Queue']['id'])) );
									*/
										
									$percentage = (ceil(($progress / $queueData['Queue']['total']) * 100));
									echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
									echo "\tparent.document.getElementById('progressStatus').style.width = '{$percentage}%';\n";
									if($percentage > 3) {
										echo "\tparent.document.getElementById('progressStatus').innerHTML = '{$percentage}%';\n";
									} else {
										echo "\tparent.document.getElementById('progressStatus').innerHTML = '';\n";
									}
									echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">".sprintf(_e("Success to send email to: %s"), $row['Sending']['email'])."</span><br/>';\n";
									echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
									echo "</script>\n";
										
								} else {
									$errors++;
									echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
									echo "\tparent.document.getElementById('progressStatus').innerHTML = '';\n";
									echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-error\">".sprintf(_e("Failed sending to %s: ".$mail->ErrorInfo), $row['Sending']['email'])."</span><br/>';\n";
									echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
									echo "</script>\n";
								}
								$mail->ClearCustomHeaders();
								@flush();
								@ob_flush();
							}
						} ## end foreach


						## ALL DONE
						if($mail->Mailer == "smtp") $mail->SmtpClose();
						$this->controller->Queue->save(array( 'Queue' => array('progress' => $progress, 'touch' => time(), 'id' => $queueData['Queue']['id'])) );
							
						$total_batches	= ceil($queueData['Queue']['total'] / Configure::read('Newsletter.config.messages_per_refresh') );
						$sent_batch		= ($total_batches - (ceil(($queueData['Queue']['total'] - $progress) / Configure::read('Newsletter.config.messages_per_refresh'))));

						if($sent_batch != $total_batches) {
							echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
							echo "\tparent.document.getElementById('progressText').innerHTML = '".sprintf(_e("Sent batch %s of %s... pausing for %s seconds."), $sent_batch, $total_batches, Configure::read('Newsletter.config.pause_between_refreshes') )."';\n";
							echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">".sprintf(_e("Sent batch %s of %s... pausing for %s seconds."),$sent_batch, $total_batches, Configure::read('Newsletter.config.pause_between_refreshes') )."</span><br/>';\n";
							echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
							echo "\tsetTimeout('window.location=\'".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/send")."\'', ".(Configure::read('Newsletter.config.pause_between_refreshes') * 1000).");";
							echo "</script>\n";
						} else {
							echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
							echo "\tparent.document.getElementById('buttonHTML').innerHTML  = '';\n";
							echo "\tparent.document.getElementById('progressText').innerHTML = '".sprintf(_e("Sent batch %s of %s."), $sent_batch, $total_batches)."';\n";
							echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">".sprintf(_e("Sent batch %s of %s."), $sent_batch, $total_batches)."</span><br/>';\n";
							echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
							echo "\twindow.location = '".$html->url("/{$this->controller->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/send")."';";
							echo "</script>\n";
						}

						$this->controller->Sending->optimize();

					}

				} else {
					echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
					echo "\tparent.document.getElementById('progressText').innerHTML = '"._e("The required session details were not available, please try again.")."';\n";
					echo "\tparent.document.getElementById('logsBox').innerHTML += '<span class=\"sent-ok\">"._e('The required session details were not available, please try again.')."</span><br/>';\n";
					echo "\tparent.document.getElementById('logsBox').scrollTop = parent.document.getElementById('logsBox').scrollHeight;\n";
					echo "\talert('"._e('The required session details were not available, please try again.')."');\n";
					echo "</script>\n";
					echo "</body>\n";
					echo "</html>\n";
					exit;
				}
				break;
					
					
		}
	}
}
?>