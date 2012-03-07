
<div id="sub-nav">
<div>
<ul>
	<li class="title" id="title-description"><a href="#"><?php echo ( $this->params['action'] == 'edit' && $this->params['controller'] == 'users' ) ? _e('Editing User') : (($this->params['action'] == 'add' &&  $this->params['controller'] == 'users') ? _e('Add User') : _e("Suscribers")); ?></a></li>

	<li class="spacer">&nbsp;</li>

	<li class="<?php echo ($this->params['controller'] == 'users' && $this->action == 'index') ? ' selected ' : ''; ?>">
	<a href="<?php echo $html->url("/{$this->plugin}/users/"); ?>"
	<?php $html->tooltip(_e('Users List')); ?>><?php __e("Users List"); ?></a>
	</li>

	<li	class="<?php echo ($this->params['controller'] == 'cfields') ? ' selected ' : ''; ?>">
	<a href="<?php echo $html->url("/{$this->plugin}/cfields"); ?>"
		<?php $html->tooltip(_e('Manage custom fields')); ?>><?php __e("Manage Fields"); ?></a>
	</li>

	<li	class="<?php echo ($this->action == 'import') ? ' selected ' : ''; ?>">
	<a href="<?php echo $html->url("/{$this->plugin}/users/import"); ?>"
	<?php $html->tooltip(_e('Import users from CSV file')); ?>><?php __e("Import"); ?></a>
	</li>

	<li	class="<?php echo ($this->action == 'export') ? ' selected ' : ''; ?>">
	<a href="<?php echo $html->url("/{$this->plugin}/users/export"); ?>"
	<?php $html->tooltip(_e('Export users to CSV file')); ?>><?php __e("Export"); ?></a>
	</li>


	<?php if ( $this->params['controller'] == 'cfields' ) { ?>
	<li style="float: right;"><a href="" onclick="cfield_form(false); return false;"><b><?php __e("Add Field"); ?></b>
		<?php echo $html->image("add_ico.gif", array('border' => 0, 'align' => 'absmiddle') ); ?></a>
	</li>
	<?php } elseif( $this->params['controller'] == 'users' && $this->action == 'index') { ?>
	<li style="float: right;"><a href="<?php echo $html->url("/{$this->plugin}/users/add"); ?>"><b><?php __e("Add User"); ?></b>
		<?php echo $html->image("add_ico.gif", array('border' => 0, 'align' => 'absmiddle') ); ?></a>
	</li>
	<?php } ?>


</ul>
</div>
</div>
