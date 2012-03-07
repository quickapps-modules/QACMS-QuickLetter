<form action="" id="deleteListForm" name="deleteListForm" method="post"
	onsubmit="return false;"><input name="data[Group][id]" type="hidden"
	value="<?php e($listData['Group']['id']); ?>"> <input
	name="data[delete_form]" type="hidden" value="dummy">
<table width="100%" border="0" cellspacing="0" cellpadding="3"
	align="center">
	<tr>
		<td align="left"><b><?php __e("Deleting List"); ?></b></td>
	</tr>
	<tr>
		<td align="left">
		<hr />
		</td>
	</tr>

	<tr>
		<td align="left">&nbsp;</td>
	</tr>

	<tr>
		<td align="left">
		<div style="padding: 15px;"><?php __e("Please confirm that you wish to delete the following list"); ?>:</div>
		</td>
	</tr>

	<tr>
		<td align="left">
		<blockquote><b>- <span class="sent-error"><?php e($listData['Group']['name']); ?></span></b></blockquote>
		</td>
	</tr>

	<tr>
		<td align="left"><?php if ( count($listData['User']) > 0 ){	?>
		<div style="margin: 15px 0 15px 0; padding: 15px;"><?php printf(_e("There are %s user residing under %s:"), count($listData['User']), $listData['Group']['name'] ); ?>
		<blockquote><input name="data[handle_users]" checked="checked"
			onClick="<?php echo (  $availables_lists > 0 ) ? "$('users_list_parent').hide();" : "" ; ?>"
			type="radio" value="delete">&nbsp;<?php __e("<b>Delete</b> all subscribers residing in this list."); ?>
			<?php if (  count($availables_lists)-1 > 0 ) { ?> <br />
		<input name="data[handle_users]" value="move"
			onClick="$('users_list_parent').show();" type="radio">&nbsp;<?php __e("<b>Move</b> all subscribers residing in this list."); ?><br />
		<select id="users_list_parent" name="data[move_to]"
			style="margin-left: 20px; display: none;">
			<?php
			foreach($availables_lists as $id => $name){
				if ( $id != $listData['Group']['id'] ){
					$_name	= r("&nbsp;", "", $name);
					$sep	= r($_name, "", $name);
					e("<option value=\"{$id}\">{$sep} {$_name}</option>\n");
				}
			}
			?>
		</select> <?php } else { ?> <br />
		<span style="font-size: 10px;"><?php __e("Unable to move users, as there are no other top level lists."); ?></span>
		<?php } ?></blockquote>
		</div>
		<?php } ?></td>
	</tr>
	<tr>
		<td align="right">
		<button class="primary_lg right"
			onClick="delete_group('deleteListForm'); return false;"><?php __e("Confirm"); ?></button>
		</td>
	</tr>
</table>
</form>
