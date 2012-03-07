<div align="center" class="centermain"><!-- navigation bar -->
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



<div class="main">
<table width="100%">
	<tr>
		<td width="100%" align="left" valign="top"><?php echo $this->element('users_sub_nav'); ?>
		</td>
	</tr>

	<tr>
		<td align="left" valign="top">


		<div align="center" class="centermain">
		<div id="tabs">
		<div class="tab"><a href="#"><?php  __e("Import Mailing List"); ?></a></div>
		</div>

		<div class="module">
		<div class="module-head">&nbsp;</div>
		<div class="module-wrap">
		<div class="form-container">
		<form method="post"	id="importForm" >
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr>
				<td colspan="2" align="left" valign="top"><b><?php __e("Newsletter Field Names"); ?></b></td>
				<td width="50%" align="left" valign="top"><b><?php __e("Imported Column Names"); ?></b></td>
			</tr>

			<tr>
				<td align="left" valign="top">* <?php __e('Email'); ?></td>
				<td align="center" valign="top">=</td>
				<td align="left" valign="top">
				<select id="email" name="data[User][email]">
					<option value="">-- <?php __e('Do not import'); ?> --</option>
					<?php $i=0; foreach ( $results as $col ) { ?>
					<option value="<?php e($i); ?>"
					<?php echo ( $col == 'email' && $session->read('Import.firstrowfields') ) ? ' selected="selected" ' : ''; ?>><?php echo _e("Column")." {$i} [{$col}]"; ?></option>
					<?php $i++; } ?>
				</select>
				</td>
			</tr>

			<tr>
				<td align="left" valign="top">* <?php __e('Name'); ?></td>
				<td align="center" valign="top">=</td>
				<td align="left" valign="top">
				<select id="name" name="data[User][name]">
					<option value="">-- <?php __e("Do not import"); ?> --</option>
					<?php $i=0; foreach ( $results as $col ) { ?>
					<option value="<?php e($i); ?>"	<?php echo ( $col == 'name' && $session->read('Import.firstrowfields') ) ? ' selected="selected" ' : ''; ?>><?php echo _e("Column")." {$i} [{$col}]"; ?></option>
					<?php $i++; } ?>
				</select>
				</td>
			</tr>

			<tr>
				<td colspan="3" align="left" valign="top">
				<hr />
				</td>
			</tr>

			<?php foreach ( $cfields as $cfield ) { ?>
			<tr>
				<td width="48%" align="left" valign="top"><?php echo ($cfield['Cfield']['req'] == 1) ? "* " : " "; echo $cfield['Cfield']['lname']; ?></td>
				<td width="2%" align="center" valign="top">=</td>
				<td align="left" valign="top">
				<select	name="data[User][cdata][<?php e($cfield['Cfield']['id']); ?>]">
					<option value="">-- <?php __e("Do not import"); ?> --</option>
					<?php $i=0; foreach ( $results as $col ) { ?>
					<option value="<?php e($i); ?>"	<?php echo ( $col == $cfield['Cfield']['sname'] && $this->data['Import']['options']['firstrowfields'] == 1) ? ' selected="selected" ' : ''; ?>><?php echo __e("Column")." {$i} [{$col}]"; ?></option>
					<?php $i++; } ?>
				</select>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="3" align="right" valign="top">
					<input type="button" class="primary_lg" onclick="window.location.href= base_url+'mod_newsletters/users/import';" value="<?php __e("« Load Data"); ?>" />
					<input type="button" class="primary_lg" onclick="import_csv('import', 'results');" value="<?php __e("Import »"); ?>" />
				</td>
			</tr>


		</table>

		</form>
		</div>
		</div>
		<div class="module-footer">
		<div>&nbsp;</div>
		</div>
		</div>


		</div>
		</td>
	</tr>
</table>
</div>
</div>