<div align="center" class="centermain">
<div id="tabs">
<div class="tab"><a href="#"><?php __e("Import Mailing List"); ?></a></div>
</div>
<div class="module">
<div class="module-head">&nbsp;</div>
<div class="module-wrap"><?php if ( $_APP['Action'] == 'export_list' && count($errors) == 0 ) { ?>
<div
	style="border: 1px solid #669900; background: #F0FFD1; text-align: left; padding: 10px;">
<?php printf(__e("Your Comma Separated Values (.csv) export file should begin downloading automatically; however, if it does not please click %s to download it."), "<a href=\"index.php?module=mod_8&view=users&act=download_exported_csv\">".__e("<b>here</b>")."</a>"); ?>
</div>
<?php } else { ?>


<form action="" method="post">

<table width="100%" border="0" cellspacing="5" cellpadding="0">
	<tr>
		<td colspan="3" align="left" valign="top"><?php __e("Please select which fields you would like to be included with this export using the form below"); ?>:</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top"><input name="act"
			type="hidden" id="act" value="export_list" /></td>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top"><b>Standard Exportable
		Fields</b></td>
		<td width="50%" align="left" valign="top"><b>Custom Exportable Fields</b></td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top"><input name="export[standard][]"
			type="checkbox" id="id" value="id" checked="checked"
			onclick="alert('<?php __e("The subscriber id must be present in all exports, you cannot de-select this field."); ?>'); return false" />
		<b>id</b></td>
		<td align="left" valign="top"><?php __e("ID of the subscriber in the database."); ?></td>
		<td rowspan="4" align="left" valign="top">

		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<?php
		$query  = $dbi->query("SELECT `id`, `field_sname`, `field_lname`, `field_type` FROM `#__newsletter_cfields` ORDER BY `field_order` ASC");
		while ( $cfield = $dbi->fetchNextObject($query) ){
			?>
			<tr>
				<td width="30%" align="left"><input
					name="export[custom][<?php echo $cfield->id; ?>]" type="checkbox"
					value="<?php echo $cfield->field_sname; ?>" /> <b><?php echo $cfield->field_sname; ?></b></td>
				<td width="70%" align="left"><?php echo $cfield->field_lname; ?></td>
			</tr>
			<?php } ?>

		</table>

		</td>
	</tr>
	<tr>
		<td align="left" valign="top"><input name="export[standard][]"
			type="checkbox" id="name" value="name" /> <b>name</b></td>
		<td align="left" valign="top"><?php __e("Name of the subscriber."); ?></td>
	</tr>
	<tr>
		<td align="left" valign="top"><input name="export[standard][]"
			type="checkbox" id="email" value="email" /> <b>email</b></td>
		<td align="left" valign="top"><?php __e("E-mail address of the subscriber."); ?></td>
	</tr>
	<tr>
		<td width="10%" align="left" valign="top"><input
			name="export[standard][]" type="checkbox" id="created"
			value="created" /> <b>created</b></td>
		<td width="40%" align="left" valign="top"><?php __e("Date the subscriber joined your database."); ?></td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top"><b>CSV Export Options</b></td>
		<td align="left" valign="top"><b>Export Groups</b></td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top"><?php __e("Fields Enclosed By"); ?>:</td>
		<td align="left" valign="top"><input name="csv[fields_enclosed]"
			type="text" value="&quot;" size="3" /></td>
		<td align="left" valign="top">Please select the group or groups that
		you would like to export subscribers from:</td>
	</tr>
	<tr>
		<td align="left" valign="top"><?php __e("Fields Delimited By"); ?>:</td>
		<td align="left" valign="top"><input name="csv[fields_delimited]"
			type="text" value="," size="3" /></td>
		<td align="left" valign="top"><select id="list_ids" name="list_ids[]"
			size="5" multiple="multiple" style="width: 99%;">
			<?php
			uses('class.mptt');
			$mptt = new mptt("#__newsletter_lists");
			$lists = array();
			$q = $dbi->query("SELECT id FROM #__newsletter_lists WHERE level = 1 ORDER BY lft ASC");
			while ( $line = $dbi->fetchNextObject($q) ){
				$lists[] = $mptt->tree($line->id, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
			}
			foreach($lists as $level){
				foreach($level as $list){
					e("<option value=\"{$list['data']['id']}\">{$list['separator']} {$list['data']['name']}</option>\n");
				}
			}
			?>
		</select></td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="right" valign="top"><input type="submit"
			value="<?php __e("Export List"); ?>" /></td>
	</tr>
</table>

</form>
			<?php } ?></div>
<div class="module-footer">
<div>&nbsp;</div>
</div>
</div>
</div>
