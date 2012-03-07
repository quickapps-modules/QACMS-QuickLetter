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


<h1 class="main-title"><?php __e("Message's Templates"); ?></h1>


<div class="main">
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	align="center">
	<!-- users list -->
	<tr>
		<td align="left" valign="top"><b><?php __e('With Selected'); ?>:</b>&nbsp;
			<select name="actions_select" id="actions_select" onChange="actions_select(this.value);">
				<option value="0"><?php __e("Select Action"); ?></option>
				<option value="templates/delete" text="<?php __e("Delete templates"); ?>"><?php __e("Delete"); ?></option>
			</select>
		</td>
	</tr>

	<tr>
		<td align="left" valign="top">
		<div id="items_list"><?php e($this->element('templates_list')); ?></div>
		</td>
	</tr>
</table>

</div>


</div>

<?php echo $javascript->link("tiny_mce/tiny_mce.js")."\n"; ?>
<div id="template_edit_dialogue" class="dialogue-wrap"
	style="display: none;">
<div class="dialogue">
<div class="dialogue-content" style="width: 800px">
<div class="wrap">
<div id="template_edit_dialogue_wrap"></div>
<fieldset class="nopad">
<button type="button" class="primary_lg right"
	onclick="Messaging.kill('template_edit_dialogue');"><?php __e('Close'); ?></button>
</fieldset>
</div>
</div>
</div>
</div>


<div id="template_errors_dialogue" class="dialogue-wrap"
	style="display: none;">
<div class="dialogue">
<div class="dialogue-content" style="width: 400px">
<div class="wrap">
<div id="template_errors_dialogue_wrap"></div>
<fieldset class="nopad">
<button type="button" class="primary_lg right"
	onclick="Messaging.kill('template_errors_dialogue');"><?php __e('Close'); ?></button>
</fieldset>
</div>
</div>
</div>
</div>
