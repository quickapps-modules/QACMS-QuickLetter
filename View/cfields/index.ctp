<?php echo $javascript->link("tablekit.js")."\n"; ?>
<div align="center"
	class="centermain"><!-- navigation bar -->
<table width="100%" class="navigation-menu" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50%" align="left" valign="middle" class="left-col"><?php echo $html->bread_crumb(); ?></td>
		<td align="right" valign="middle" class="right-col"><?php echo $this->element('nav_bar'); ?></td>
	</tr>
</table>
<!-- end navigation bar -->

<?php echo $this->element('users_sub_nav'); ?>
<div class="main">


<h1 class="main-title"><?php __e('Custom Fields'); ?></h1>



    <div id="formContainer"></div>




<table width="100%">
	<tr>
		<td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<!-- users list -->
				<tr>
					<td align="left" valign="top"><b><?php __e('With Selected'); ?>:</b>&nbsp;
					<select name="actions_select" id="actions_select" onChange="actions_select(this.value);">
						<option value="0"><?php __e("Select Action"); ?></option>
						<option value="cfields/delete" text="<?php __e("Delete custom fields and all related data"); ?>"><?php __e("Delete"); ?></option>
					</select>
					</td>
				</tr>

				<tr>
					<td align="left" valign="top">
						<div id="items_list">
							<?php echo $this->element('cfields_list'); ?>
						</div>
						
						<br/>
						<input type="button" onclick="reorder_cfieds();" class="primary_lg right" value="<?php __e('Rorder'); ?>" />

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>








</div>
</div>




