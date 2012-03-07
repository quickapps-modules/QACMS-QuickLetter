<?php
if ( $_GET['fedit']  ){
	$_GET['fedit'] = intval($_GET['fedit']);
	$fieldData = $dbi->queryUniqueObject("SELECT * FROM #__newsletter_cfields WHERE id = {$_GET['fedit']}");
	if ( $fieldData->id <= 0 ){
		unset($fieldData, $_GET['fedit']);
	}
}
?>
<table width="50%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td>
		<div id="addFieldContainer" style="<?php echo ( $fieldData ) ? "": ' display:none; '; ?>">
		<div align="center" class="centermain">
		<div id="tabs">
		<div class="tab"><a href="#"><?php echo ( $fieldData ) ? __e("Editing Field") : __e("Add New Field"); ?></a></div>
		</div>
		<div class="module">
		<div class="module-head">&nbsp;</div>
		<div class="module-wrap">
		<form method="post" id="addFieldForm" action=""><input name="act"
			type="hidden"
			value="<?php echo ( isset($fieldData) ) ? "update_cfield" : "add_cfield"; ?>">
			<?php if ( isset($fieldData) ) { ?><input name="cfield_id"
			type="hidden" value="<?php e($fieldData->id); ?>"><?php } ?>
		<div id="addFieldFormErrors" style="display: none; text-align: left;"
			class="formErrors"></div>
		<table width="100%" align="center" cellspacing="5">
			<tr>
				<td width="41%" align="left" valign="middle"><strong
				<?php $html->tooltip(__e("This is the type of custom field that you are looking at adding. Currently you can select a number of different HTML field types as well as a linebreak.")) ?>><?php __e("Field Type"); ?>:</strong><br />
				</td>
				<td width="59%" align="left" valign="middle"><select
					name="field_type" style="width: 129px">
					<option value="checkbox"
					<?php echo ( isset($fieldData) && $fieldData->field_type == "checkbox") ? ' selected="selected" ': ''; ?>>Checkbox</option>
					<option value="hidden"
					<?php echo ( isset($fieldData) && $fieldData->field_type == "hidden") ? ' selected="selected" ': ''; ?>>Hidden
					Field</option>
					<option value="linebreak"
					<?php echo ( isset($fieldData) && $fieldData->field_type == "linebreak") ? ' selected="selected" ': ''; ?>>Linebreak</option>
					<option value="radio"
					<?php echo ( isset($fieldData) && $fieldData->field_type == "radio") ? ' selected="selected" ': ''; ?>>Radio
					Buttons</option>
					<option value="select"
					<?php echo ( isset($fieldData) && $fieldData->field_type == "select") ? ' selected="selected" ': ''; ?>>Select
					Box</option>
					<option value="textarea"
					<?php echo ( isset($fieldData) && $fieldData->field_type == "textarea") ? ' selected="selected" ': ''; ?>>Textarea</option>
					<option value="textbox"
					<?php echo ( isset($fieldData) && $fieldData->field_type == "textbox") ? ' selected="selected" ': ''; ?>>Textbox</option>
				</select></td>
			</tr>
			<tr>
				<td align="left" valign="middle"><strong
				<?php $html->tooltip(__e("This is a short name for the field that must be all lowercase, all one word and no special characters. This field must also be unique because it is what you will use to call this field in a custom e-mail placeholder!")) ?>><?php __e("Field Short Name"); ?>:</strong></td>
				<td align="left" valign="middle"><input type="text" class="text-box"
					style="width: 125px" name="field_sname"
					value="<?php echo ( isset($fieldData) ) ? $fieldData->field_sname : ''; ?>"
					maxlength="16" /></td>
			</tr>
			<tr>
				<td align="left" valign="middle"><strong
				<?php $html->tooltip(__e("This is the title or longer name for your custom field. This could also be a question.")); ?>><?php __e("Field Display Name"); ?>:</strong></td>
				<td align="left" valign="middle"><input type="text" class="text-box"
					style="width: 360px" name="field_lname"
					value="<?php echo ( isset($fieldData) ) ? $fieldData->field_lname : ''; ?>"
					maxlength="64" /></td>
			</tr>
			<tr>
				<td align="left" valign="middle">&nbsp;</td>
				<td align="left" valign="middle">&nbsp;</td>
			</tr>
			<tr>
				<td align="left" valign="top"><strong
				<?php $html->tooltip(__e("This is the options or defined value(s) of your custom field. If you are using a checkbox, radio button or select box you will want to specify your options here.<br/><br/><strong>Example:</strong><br/>blue=Blue<br/>red=Red<br/>green=Green")); ?>><?php __e("Field Options"); ?>:</strong><br />
				<?php __e("(required for radio buttons, select boxes, check boxes and hidden field valued only.)"); ?>
				</td>
				<td align="left" valign="middle"><textarea name="field_options"
					style="width: 360px; height: 125px"><?php echo ( isset($fieldData) ) ? $fieldData->field_options : ''; ?></textarea></td>
			</tr>
			<tr>
				<td align="left" valign="middle"><strong
				<?php $html->tooltip(__e("This is only used if your Field Type is a textbox. This will limit the subscriber to typing X number of characters in your textbox.")); ?>><?php __e("Maxlength"); ?>:</strong><br />
				<?php __e("(used only for text boxes)"); ?></td>
				<td align="left" valign="middle"><input type="text" class="text-box"
					style="width: 50px" name="field_length"
					value="<?php echo ( isset($fieldData) ) ? $fieldData->field_length : ''; ?>"
					maxlength="12" /></td>
			</tr>
			<tr>
				<td align="left" valign="middle"><strong
				<?php $html->tooltip(__e("Specify whether you want this custom field to be a required field or you can have it set to be optional.")); ?>><?php __e("Required Field"); ?>:</strong><br />
				<?php __e("(is this field required when users sign-up?)"); ?></td>
				<td align="left" valign="middle"><select name="field_req"
					style="width: 54px">
					<option value="1"
					<?php echo ( isset($fieldData) && $fieldData->field_req == 1 ) ? ' selected="selected" ' : ''; ?>><?php __e("Yes"); ?></option>
					<option value="0"
					<?php echo ( isset($fieldData) && $fieldData->field_req == 0 ) ? ' selected="selected" ' : ''; ?>><?php __e("No"); ?></option>
				</select></td>
			</tr>
			<tr>
				<td align="left" valign="middle">&nbsp;</td>
				<td align="right" valign="middle"><input type="button"
					value="<?php __e("Cancel"); ?>"
					onclick="<?php echo ( !$fieldData ) ? "Effect.toggle('addFieldContainer', 'slide');" : "window.location.href='index.php?module={$_APP['Data']['product_id']}&view=users&tab=fields'; "; ?>" />
				<input type="button"
					value="<?php echo ( !$fieldData ) ? __e("Add Field") : __e("Update Field"); ?>"
					onclick="add_field('addFieldForm', <?php echo ( !$fieldData ) ? "false" :"true"; ?>);" />
				</td>
			</tr>
		</table>
		</form>
		</div>
		<div class="module-footer">
		<div>&nbsp;</div>
		</div>
		</div>
		</div>
		</div>
		</td>
	</tr>
</table>












					<?php if ( !$fieldData ){ ?>
<div id="fields_container">
<form method="post" id="cfieldsForm" action=""><input name="act"
	type="hidden" value="reorder_cfields">
<table width="100%" cellspacing="5" class="adminlist">
	<tr>
		<th width="5%" align="center">&nbsp;</th>
		<th width="23%" align="left"><?php __e("Field Name"); ?></th>
		<th width="57%" align="left"><?php __e("Field Preview"); ?></th>
		<th width="15%" align="left"><?php __e("Order"); ?></th>
	</tr>

	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><strong><?php __e("User Name"); ?>: *</strong></td>
		<td colspan="2" align="left">
		<div style="margin: 10px 0 10px 0;"><input type="text" name="name"
			id="name"></div>
		</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><strong><?php __e("E-mail Address"); ?>: *</strong></td>
		<td colspan="2" align="left">
		<div style="margin: 10px 0 10px 0;"><input type="text" name="email"
			id="email"></div>
		</td>
	</tr>

	<tr>
		<td colspan="4">
		<hr />
		</td>
	</tr>

	<?php
	$result = $dbi->query("SELECT `table`.* FROM #__newsletter_cfields AS `table` WHERE `table`.id > 0 ORDER BY `table`.field_order ASC");
	$num_rows	= $dbi->numRows($result);


	if ( $num_rows > 0){//mostrar si hay registros
		$j = 0;
		while ($line = $dbi->fetchNextObject($result)) {
			?>
	<tr class="row<?php echo $j; ?>">
		<td align="left"><a
			href="<?php e("index.php?module={$_APP['Data']['product_id']}&view=users&tab=fields&fedit={$line->id}"); ?>"><img
			src="<?php e("{$_APP['Paths']['Theme']}"); ?>/img/edit_ico.gif"
			border="0" /></a> <a href=""
			onClick="delete_field('<?php e($line->id); ?>'); return false;"><img
			src="<?php e("{$_APP['Paths']['Theme']}"); ?>/img/delete_ico.gif"
			border="0" /></a></td>

		<td align="left"><strong><?php e($line->field_lname); ?> <?php echo ($line->field_req) ? "*" : "";?></strong></td>

		<td align="left">
		<div style="margin: 10px 0 10px 0;"><?php e(newsletter::render_cfield(Set::reverse($line))); ?></div>
		</td>

		<td align="left"><select name="order[<?php e($line->id); ?>]">
		<?php for ( $i=1; $i <= $num_rows; $i++) { ?>
			<option
			<?php echo  ($i == $line->field_order) ? ' selected="selected" ': "";?>><?php e($i); ?></option>
			<?php } ?>
		</select></td>
	</tr>
	<?php
	$j = ($j == 0) ? 1 : 0;
		}

	}else{//si no hay registros que mostrar:
		?>
	<tr>
		<td align="center" colspan="4"><br />
		<?php __e("You have no custom fields."); ?><br />
		</td>
	</tr>
	<?php }?>

	<tr class="row1">
		<th colspan="4" align="right"><?php if ( $num_rows > 0){ ?><input
			type="button" onClick="reorder_cfields('cfieldsForm'); return false;"
			value="<?php __e("Update Order"); ?>"><?php } ?></th>
	</tr>
</table>

</form>
</div>
	<?php } ?>