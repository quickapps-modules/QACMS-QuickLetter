<?php echo $javascript->link("/{$this->plugin}/js/prototabs.js")."\n"; ?>

<div align="center" class="centermain"><!-- navigation bar -->
<table width="100%" class="navigation-menu" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50%" align="left" valign="middle" class="left-col"><?php echo $html->bread_crumb(); ?></td>
		<td align="right" valign="middle" class="right-col"><?php echo $this->element('nav_bar'); ?></td>
	</tr>
</table>
<!-- end navigation bar -->


<h1 class="main-title"><?php __e("Composing Newsletter"); ?></h1>

<br />


<div class="main">
<?php 
$news_module = in_array('3', Set::extract("/Module/product_id", $_MODULES));
$blogs_module = in_array('6', Set::extract("/Module/product_id", $_MODULES));
if ( $news_module || $blogs_module ) {
?>
<div id="alert" style="<?php echo ( !isset($_COOKIE["alert_news_or_articles_exists_{$this->plugin}"]) ) ? "" : "display:none;"; ?>">
	<div class="green">
		<div class="tr"></div>
		<div class="content">
			<div class="fixed icon" align="left">
				<div class="radBttn"><a class="rb_sup" href="#"	onclick="suppress_warning('<?php e("news_or_articles_exists_{$this->plugin}"); ?>'); return false;"	title="<?php __e("Suppress warning"); ?>"> <span><?php __e("Suppress this warning"); ?></span></a></div>
				<?php
				$msg = "";
				$msg .= $news_module ? _e("News Module Detected, you can import news.") : "";
				$msg .= "&nbsp;";
				$msg .= $blogs_module ? _e("Blogs Module Detected, you can import articles.") : "";
				__e($msg);
				?>
			</div>
		</div>
		<div class="bl"><div class="br"></div></div>
	</div>
</div>
<!-- alert --> <?php } ?>


<div class="form-container">
	<form id="send_form" method="post" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td colspan="2" align="left" valign="top"><div align="center" class="centermain">
			    <div id="tabs">
			      <div class="tab"><a href="#">
			        <?php __e("Newsletter's Content"); ?>
			        </a></div>
		        </div>
			    <div class="module">
			      <div class="module-head">&nbsp;</div>
			      <div class="module-wrap">
			        <table width="100%" border="0" cellspacing="5" cellpadding="0">
			          <tr>
			            <td align="left"><b>
			              <?php __e('Internal Title'); ?>
			              <a href="#" <?php $html->tooltip(_e('This is an internal identifier for you, the administrator, so you can easily identify this message in the Message Centre. This field will never been seen by an end-user, it is available to the administrator.')); ?>>[?]</a>:</b></td>
			            <td align="left"><input style="width: 50%" type="text" class="text" name="data[Message][name]" id="name" value="" />
			              <?php if ( $news_module ) { ?>
			              <div class="radBttn" id="import_news_btn" style="float: right;"><a href="" onClick="import_news(); return false;"><span>
			                <?php __e("+ Import News"); ?>
			                </span></a></div>
			              <br>
			              <?php } ?></td>
		              </tr>
			          <tr>
			            <td width="14%" align="left"><b><?php __e('Subject'); ?>:</b></td>
			            <td width="86%" align="left"><input style="width: 50%" class="text" type="text" name="data[Message][subject]" id="subject" value="" />
			              <?php if ( $blogs_module ) { ?>
			              <div class="radBttn" id="import_article_btn" style="float: right;"><a href="" onClick="import_article(); return false;"><span>
			                <?php __e("+ Import Article"); ?>
			                </span></a></div>
			              <br>
			              <?php } ?></td>
		              </tr>
			          <tr>
			            <td align="left"><b>
			              <?php __e('&laquo;From&raquo; field'); ?>
			              <a href="#" <?php $html->tooltip(_e('This is the from name and e-mail address that the end user will see when viewing your message.')); ?>>[?]</a>: </b></td>
			            <td align="left"><input style="width: 50%" type="text" class="text" name="data[Message][from_field]" id="from_field"	value='<?php echo '"'.Configure::read('Newsletter.config.message_from_name').'" <'.Configure::read('Newsletter.config.message_from_address').'>'; ?>' /></td>
		              </tr>
			          <tr>
			            <td align="left"><b>
			              <?php __e('Priority'); ?>
			              :</b></td>
			            <td align="left"><select name="data[Message][priority]"
							id="priority">
			              <option value="1">
			                <?php __e('Highest'); ?>
			                </option>
			              <option value="3">
			                <?php __e('Normal'); ?>
			                </option>
			              <option value="5">
			                <?php __e('Lowest'); ?>
			                </option>
			              </select></td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left">&nbsp;</td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left">&nbsp;</td>
		              </tr>
			          <tr>
			            <td align="left"><b>
			              <?php __e('Plain Text Message'); ?>
			              :</b></td>
			            <td align="right"><div class="radBttn" id="import_article_btn" style="float: right;"><a href="" onClick="html2plain(); return false;"><span>
			              <?php __e("+ Copy from HTML"); ?>
			              </span></a></div>
			              <br></td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left"><textarea rows="10" style="width: 99%;" name="data[Message][body_text]" id="plain_message"></textarea></td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left">&nbsp;</td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left">&nbsp;</td>
		              </tr>
			          <tr>
			            <td align="left"><b>
			              <?php __e('HTML Message'); ?>
			              :</b></td>
			            <td align="right"><div class="radBttn" id="import_article_btn" style="float: right;"><a href="" onClick="save_template(); return false;"><span>
			              <?php __e("+ Save as Template"); ?>
			              </span></a></div>
			              <br></td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left"><textarea rows="5"	name="data[Message][body_html]" id="html_message" style="width: 99%;"></textarea></td>
		              </tr>
			          <tr>
			            <td align="left">&nbsp;</td>
			            <td align="left">&nbsp;</td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left"><b>
			              <?php __e('Footer'); ?>
			              :</b></td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left"><textarea name="data[Message][footer]"	rows="5" id="footer" style="width: 99%;"><?php echo Configure::read('Newsletter.config.message_footer'); ?></textarea></td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left">&nbsp;</td>
		              </tr>
			          <tr>
			            <td colspan="2" align="left"><button id="msg_draft_btn" class="primary_lg" onClick="send_message('draft'); return false;">
			              <?php __e('Save as Draft'); ?>
			              </button></td>
		              </tr>
		            </table>
		          </div>
			      <div class="module-footer">
			        <div>&nbsp;</div>
		          </div>
		        </div>
		      </div></td>
		  </tr>
			<tr>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
		  </tr>
			<tr>
				<td width="50%" align="left" valign="top"><div align="center" class="centermain">
				  <div id="tabs">
				    <div class="tab"><a href="#">
				      <?php __e('Quick Help'); ?>
				      </a></div>
			      </div>
				  <div class="module">
				    <div class="module-head">&nbsp;</div>
				    <div class="module-wrap">
				      <table width="100%" border="0" cellspacing="0" cellpadding="0">
				        <tr>
				          <td><?php __e('To send a message fill out the information. The minimum requirement for a valid message is the information in the "Newsletter\'s Content" tab. To finish your message and send it for real, choose the "Lists" tab, select your lists and click the button "Send Message to Selected Mailinglists"'); ?></td>
			            </tr>
				        <tr>
				          <td><hr /></td>
			            </tr>
				        <tr>
				          <td><b><?php __e('Placeholders'); ?>:</b></td>
			            </tr>
				        <tr>
				          <td><?php __e('You can use certain Placeholders in your values. Placeholders look like [SOMETEXT], where SOMETEXT can be different. Some useful placeholders are:'); ?></td>
			            </tr>
				        <tr>
				          <td align="left"><ul>
				            <li>[WEBSITE] -
				              <?php __e('the address you type for your website.'); ?>
			                </li>
				            <li>[DOMAIN] -
				              <?php __e('the text you type for your domain.'); ?>
			                </li>
				            <li>[SUBSCRIBEURL] -
				              <?php __e('the location of the subscribe page.'); ?>
			                </li>
				            <li>[UNSUBSCRIBEURL] -
				              <?php __e('the location of the unsubscribe page.'); ?>
			                </li>
				            <li>[PREFERENCESURL] -
				              <?php __e('he location of the page where users can update their details.'); ?>
			                </li>
				            <li>[CONFIRMATIONURL] -
				              <?php __e('the location of the page where users have to confirm their subscription.'); ?>
			                </li>
				            </ul>
				            <div class="radBttn" style="float: right;"><a href=""
							onClick="Effect.toggle('placeholders_list', 'blind', { duration: 0.2 }); return false;"><span>
				              <?php __e("+ More Placeholders"); ?>
				              </span></a></div>
				            <br>
				            <div id="placeholders_list" style="display: none;">
				              <ul>
				                <li>[userid] - <?php __e("this will input the database ID of the user"); ?></li>
				                <li>[username] - <?php __e("this will input the users full name"); ?></li>
				                <li>[useremail] - <?php __e("this will input the users e-mail address"); ?></li>
				                <li>[usergender] - <?php __e("this will input the users gender"); ?></li>
				                <li>[userkey] - <?php __e("this will input the activation KEY"); ?></li>
				                <li>[usercreated] - <?php __e("this will input the date that the user signed up to the list"); ?></li>
				                <li>[usermodified] - <?php __e("this will input the date that the user modified the profile"); ?></li>
				                <li style="list-style: none;">&nbsp;</li>
				                <li style="list-style: none;">&nbsp;</li>
				                <li style="list-style: none;"><b><?php __e("Custom Placeholders"); ?>:</b></li>
				                <?php
								foreach ( $placeholders as $cfield ) {
									?>
				                <li>[<?php e($cfield['Cfield']['sname']); ?>] - <?php __e("this is a custom placeholder that can be used in any template, message body or message subject"); ?></li>
				                <?php } ?>
			                  </ul>
			                </div></td>
			            </tr>
			          </table>
			        </div>
				    <div class="module-footer">
				      <div>&nbsp;</div>
			        </div>
			      </div>
			    </div></td>
				<!-- left -->

				<td width="50%" align="left" valign="top"><div align="center" class="centermain">
				<div id="tabs">
				<div class="tab"><a href="#"><?php __e('Lists'); ?></a></div>
				</div>
				<div class="module">
				<div class="module-head">&nbsp;</div>
				<div class="module-wrap">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left"><?php __e('Please select the lists you want to send it to:'); ?></td>
					</tr>
					<tr>
						<td align="left">
						<div id="lists_checkboxes" style="margin: 10px 0 0 10px;"><?php e($this->element('groups_checkboxes')); ?>
						</div>
						<br />
						<button class="primary_lg"
							onClick="send_message('queue'); return false;"><?php __e('Send Message to Selected Mailinglists'); ?></button>
						</td>
					</tr>
				</table>
				</div>
				<div class="module-footer">
				<div>&nbsp;</div>
				</div>
				</div>
				</div>

				<div align="center" class="centermain">
				<div id="tabs">
				<div class="tab"><a href="#"><?php __e('Test Message'); ?></a></div>
				</div>
				<div class="module">
				<div class="module-head">&nbsp;</div>
				<div class="module-wrap">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="23%" align="left"><?php __e('To email address(es)'); ?>:</td>
						<td width="77%" align="left"><input type="text" class="text" name="data[Message][test_mails]" id="test_mails" style="width: 95%;"></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="left"><span style="font-size: 9px;"><?php __e('(comma separate addresses - all must be users)'); ?></span></td>
					</tr>
					<tr>
						<td colspan="2" align="left">&nbsp;</td>
					</tr>

					<tr>
						<td colspan="2" align="left">
						<button class="primary_lg"
							onClick="send_message('test'); return false;"><?php __e('Send Test Message'); ?></button>
						</td>
					</tr>

				</table>



				</div>
				<div class="module-footer">
				<div>&nbsp;</div>
				</div>
				</div>
				</div>
				<!-- test block --></td>
				<!-- right -->

			</tr>
		</table>

	</form>
</div>
</div>
</div>
<?php echo $javascript->link("tiny_mce/tiny_mce.js")."\n"; ?>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "html_message",
		theme : "advanced",
		
		plugins : "imagemanager,filemanager,preview,table,inlinepopups,media,contextmenu,fullscreen,advimage, pagebreak, template",
		pagebreak_separator : "<!-- readmore -->",
		language : "<?php echo Configure::read('Config.language_1'); ?>",
		convert_urls : false,
		
		imagemanager_rootpath : "../../../../<?php e(Configure::read('_UPLOAD_FOLDER').Configure::read('_APP.user_setup.uploadFolder')); ?>/images",
		filemanager_rootpath : "../../../../<?php e(Configure::read('_UPLOAD_FOLDER').Configure::read('_APP.user_setup.uploadFolder')); ?>/images",
		
		template_external_list_url: base_url+'mod_newsletters/templates/list_js',
		
		height : "480",
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,formatselect,fontselect,fontsizeselect,|, media, fullscreen, preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,template,|,insertfile,insertimage",
		theme_advanced_toolbar_location : "external",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false
	});
	
	
</script>
<div id="message_edit_dialogue" class="dialogue-wrap" style="display: none;">
	<div class="dialogue">
		<div class="dialogue-content" style="width: 670px">
			<div class="wrap">
				<div id="message_edit_dialogue_wrap"></div>
				<fieldset class="nopad">
				<button type="button" class="primary_lg right"
					onclick="Messaging.kill('message_edit_dialogue');"><?php __e("Close"); ?></button>
				</fieldset>
			</div>
		</div>
	</div>
</div>


<div id="add_template_errors_dialogue" class="dialogue-wrap" style="display: none;">
	<div class="dialogue">
		<div class="dialogue-content" style="width: 400px">
			<div class="wrap">
				<div id="add_template_errors_dialogue_wrap"></div>
				<fieldset class="nopad">
				<button type="button" class="primary_lg right"
					onclick="Messaging.kill('add_template_errors_dialogue');"><?php __e("Close"); ?></button>
				</fieldset>
			</div>
		</div>
	</div>
</div>
