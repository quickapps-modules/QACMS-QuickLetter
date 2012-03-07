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

<?php echo $this->element('users_sub_nav'); ?>
<div class="main">
<table width="100%">


	<tr>
		<td align="left" valign="top">


		<div align="center" class="centermain">
		<div id="tabs">
		<div class="tab"><a href="#" onclick="Effect.toggle('searchForms', 'slide'); return false;"
			style="cursor: pointer;"><?php __e("Quick Search"); ?></a></div>
		</div>
		<div class="module">
		<div class="module-head">&nbsp;</div>
		<div class="module-wrap" id="searchForms" style="<?php echo ( isset($this->data['User']) ) ? '' : 'display: none;'; ?>">

		<table width="100%" cellspacing="5">
			<!-- search -->
			<tr>
				<td align="left" valign="middle">

				<form name="filter" method="post" action="">
				<table width="100%" cellspacing="5">
					<tr>
						<td width="14%" align="left"><b><?php __e("User Search"); ?>:</b></td>
						<td width="17%" align="left">
						<?php echo $form->select('User.filter.by', array(
													'name' => _e("Name Field"),
													'gender' => _e("Gender"),
													'email' => _e("E-Mail Address")
						)); ?>
						</td>
						<td width="12%" align="left">
						<?php echo $form->select('User.filter.condition', array(
													'contains' => _e("Contains"),
													'equals' => _e("Equals")
						)); ?>
						</td>
						<td width="44%" align="left"><?php echo $form->text('User.filter.value', array('class' => 'text-box', 'style' => 'width: 165px') ); ?>	</td>
						<td width="13%" align="left" style="text-align: right;"><input class="primary_lg" type="submit" value="Search" /></td>
					</tr>
				</table>
				</form>

				</td>
			</tr>
			<tr>
				<td align="left" valign="middle">
				<form id="changelist" method="post" action="">
				<table width="100%" cellspacing="5">
					<tr>
						<td width="14%" align="left"><b><?php __e("Show Group"); ?>:</b></td>
						<td width="86%" align="left"><?php
							foreach($groups as $id => $name){
								$_name	= r("&nbsp;", "", $name);
								$sep	= r($_name, "", $name);
								$arr[$id] = "{$sep} {$_name}";
							}
							echo $form->select('User.groupfilter', $arr, false, array('escape' => false, 'onchange' => '$("changelist").submit();') );
							?>
						</td>
					</tr>
				</table>
				</form>
				</td>
			</tr>
		</table>
		<!-- search --></div>
		<div class="module-footer">
		<div>&nbsp;</div>
		</div>
		</div>
		</div>


		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<!-- users list -->
			<tr>
				<td align="left" valign="top"><b><?php __e('With Selected'); ?>:</b>&nbsp;
				<select name="actions_select" id="actions_select"
					onChange="actions_select(this.value);">
					<option value="0"><?php __e("Select Action"); ?></option>
					<option value="users/delete" text="<?php __e("Delete users"); ?>"><?php __e("Delete"); ?></option>
					<option value="users/approve" text="<?php __e("Approve users"); ?>"><?php __e("Approve"); ?></option>
					<option value="users/unapprove" text="<?php __e("Unapprove users"); ?>"><?php __e("Unapprove"); ?></option>
				</select>
				</td>
			</tr>

			<tr>
				<td align="left" valign="top">
				<div id="items_list"><?php e($this->element('users_list')); ?></div>
				</td>
			</tr>
		</table>
		<!-- users list --></td>
	</tr>
</table>


</div>
</div>

