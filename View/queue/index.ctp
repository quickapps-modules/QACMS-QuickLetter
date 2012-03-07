
<script language="JavaScript" type="text/javascript">
	Messaging.kill('');
	Event.observe(window, 'load', function() { Messaging.kill(''); } );
	$('messenger-wrap').hide();
</script>


<?php echo $javascript->link("tablekit.js")."\n"; ?>
<div align="center"
	class="centermain"><!-- navigation bar -->
<table width="100%" class="navigation-menu" cellpadding="0"
	cellspacing="0" border="0">
	<tr>
		<td width="50%" align="left" valign="middle" class="left-col"><?php echo $html->bread_crumb(); ?>
		</td>

		<td align="right" valign="middle" class="right-col"><?php echo $this->element('nav_bar'); ?>
		</td>
	</tr>
</table>
<!-- end navigation bar -->



<h1 class="main-title"><?php __e("Queue Manager"); ?></h1>


<div class="main">
<table width="100%">
	<tr>
		<td width="50%" align="left" valign="top"><b><?php __e('With Selected'); ?>:</b>&nbsp;
			<span id="checkbox_actions">
				<select id="actions_select"	onChange="actions_select(this.value);">
					<option value="0"><?php __e("Select Action"); ?></option>
					<option value="queue/delete" text="<?php __e("Delete queue"); ?>"><?php __e("Delete"); ?></option>
				</select>
			</span>
			<span id="radio_actions" style="display: none;">
				<select	id="actions_select"	onChange="radio_queue_actions_select(this.value);">
					<option value="0"><?php __e("Select Action"); ?></option>
					<option value="resume"><?php __e("Resume"); ?></option>
					<option value="cancel"><?php __e("Cancel"); ?></option>
				</select>
			</span>
		</td>
	</tr>
</table>

<div id="items_list"><?php e($this->element('queue_list')); ?></div>

</div>


</div>

<?php if ( isset($iframe_action) ){ ?>
	<div id="queue_sending_dialogue" class="dialogue-wrap">
		<div class="dialogue">
			<div class="dialogue-content" style="width: 600px">
				<div class="wrap">
					<div id="queue_sending_dialogue_wrap">
						<h1><?php __e("Sending Queue"); ?></h1>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" align="left"><iframe id="workerFrame" style="<?php echo (Configure::read() > 0) ? "width: 100%; height: 200px;": "width: 0px; height: 0px;" ; ?> border: 0px #000000 solid; margin: 0px" src="<?php echo $html->url("/{$this->plugin}/queue/send_iframe/{$queueData['Queue']['id']}/{$iframe_action}"); ?>"></iframe>
								</td>
							</tr>
							<tr>
								<td width="36%" height="51" align="left">
									<div id="progressText" style="width: 95%" class="progress-text"></div>
								</td>
								<td width="64%" align="left">
								<div id="progressBar">
								<div id="progressStatus">&nbsp;</div>
								</div>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="left">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="left">
								<div id="buttonHTML">&nbsp;</div>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="left"><b><?php __e("Logs"); ?></b></td>
							</tr>

							<tr>
								<td colspan="2" align="center">
									<div id="logsBox" style="width: 98%; height: 80px; border: 1px solid #ccc; overflow: auto; text-align: left; padding: 5px;"	align="left"></div>
								</td>
							</tr>
						</table>


					</div>

				</div>
			</div>
		</div>
	</div>
<?php } ?>