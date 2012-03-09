
<div id="sub-nav">
<div>
<ul>
    <li class="title" id="title-description"><a href="#"><?php echo ($this->params['action'] == 'edit' && $this->params['controller'] == 'users') ? __t('Editing User') : (($this->params['action'] == 'add' &&  $this->params['controller'] == 'users') ? __t('Add User') : __t("Suscribers")); ?></a></li>

    <li class="spacer">&nbsp;</li>

    <li class="<?php echo ($this->params['controller'] == 'users' && $this->action == 'index') ? ' selected ' : ''; ?>">
    <a href="<?php echo $html->url("/{$this->plugin}/users/"); ?>"
    <?php $html->tooltip(__t('Users List')); ?>><?php echo __t(("Users List"); ?></a>
    </li>

    <li    class="<?php echo ($this->params['controller'] == 'cfields') ? ' selected ' : ''; ?>">
    <a href="<?php echo $html->url("/{$this->plugin}/cfields"); ?>"
        <?php $html->tooltip(__t('Manage custom fields')); ?>><?php echo __t(("Manage Fields"); ?></a>
    </li>

    <li    class="<?php echo ($this->action == 'import') ? ' selected ' : ''; ?>">
    <a href="<?php echo $html->url("/{$this->plugin}/users/import"); ?>"
    <?php $html->tooltip(__t('Import users from CSV file')); ?>><?php echo __t(("Import"); ?></a>
    </li>

    <li    class="<?php echo ($this->action == 'export') ? ' selected ' : ''; ?>">
    <a href="<?php echo $html->url("/{$this->plugin}/users/export"); ?>"
    <?php $html->tooltip(__t('Export users to CSV file')); ?>><?php echo __t(("Export"); ?></a>
    </li>


    <?php if ($this->params['controller'] == 'cfields') { ?>
    <li style="float: right;"><a href="" onclick="cfield_form(false); return false;"><b><?php echo __t(("Add Field"); ?></b>
        <?php echo $html->image("add_ico.gif", array('border' => 0, 'align' => 'absmiddle')); ?></a>
    </li>
    <?php } elseif ($this->params['controller'] == 'users' && $this->action == 'index') { ?>
    <li style="float: right;"><a href="<?php echo $html->url("/{$this->plugin}/users/add"); ?>"><b><?php echo __t(("Add User"); ?></b>
        <?php echo $html->image("add_ico.gif", array('border' => 0, 'align' => 'absmiddle')); ?></a>
    </li>
    <?php } ?>


</ul>
</div>
</div>
