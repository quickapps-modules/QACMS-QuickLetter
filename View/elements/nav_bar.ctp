
<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
    <tr valign="middle" align="center">
        <td><a <?php $html->tooltip(__t("Compose a new message")); ?>
            class="toolbar <?php echo ($this->params['controller'] == 'messages' && $this->action == 'compose') ? ' selected ' : ''; ?>"
            href="<?php echo $html->url("/{$this->plugin}/messages/compose"); ?>"><span><?php echo $html->image("/{$this->plugin}/img//compose.gif", array('border' => 0, 'align' => 'middle')); ?><br />
            <?php echo __t(("Compose"); ?></span></a></td>
        <td><a <?php $html->tooltip(__t("Message centre")); ?>
            class="toolbar <?php echo ($this->params['controller'] == 'messages' && $this->action == 'index') ? ' selected ' : ''; ?>"
            href="<?php echo $html->url("/{$this->plugin}/messages"); ?>"><span><?php echo $html->image("/{$this->plugin}/img/msgs.gif", array('border' => 0, 'align' => 'middle')); ?><br />
            <?php echo __t(("Messages"); ?></span></a></td>
        <td><a <?php $html->tooltip(__t("Users groups")); ?>
            class="toolbar <?php echo ($this->params['controller'] == 'groups') ? ' selected ' : ''; ?>"
            href="<?php echo $html->url("/{$this->plugin}/groups"); ?>"><span><?php echo $html->image("/{$this->plugin}/img/lists.gif", array('border' => 0, 'align' => 'middle')); ?><br />
            <?php echo __t(("Groups"); ?></span></a></td>
        <td><a <?php $html->tooltip(__t("Users")); ?>
            class="toolbar <?php echo ($this->params['controller'] == 'users') ? ' selected ' : ''; ?>"
            href="<?php echo $html->url("/{$this->plugin}/users"); ?>"><span><?php echo $html->image("/{$this->plugin}/img/users.gif", array('border' => 0, 'align' => 'middle')); ?><br />
            <?php echo __t(("Users"); ?></span></a></td>
        <td><a <?php $html->tooltip(__t("Queue manager")); ?>
            class="toolbar <?php echo ($this->params['controller'] == 'queue') ? ' selected ' : ''; ?>"
            href="<?php echo $html->url("/{$this->plugin}/queue"); ?>"><span><?php echo $html->image("/{$this->plugin}/img/queue.gif", array('border' => 0, 'align' => 'middle')); ?><br />
            <?php echo __t(("Queue"); ?></span></a></td>
        <td><a <?php $html->tooltip(__t("Modify remplates")); ?>
            class="toolbar <?php echo ($this->params['controller'] == 'templates') ? ' selected ' : ''; ?>"
            href="<?php echo $html->url("/{$this->plugin}/templates"); ?>"><span><?php echo $html->image("/{$this->plugin}/img/templates.gif", array('border' => 0, 'align' => 'middle')); ?><br />
            <?php echo __t(("Templates"); ?></span></a></td>
        <td><a <?php $html->tooltip(__t("Configuration")); ?>
            class="toolbar <?php echo ($this->params['controller'] == 'setup') ? ' selected ' : ''; ?>"
            href="<?php echo $html->url("/{$this->plugin}/setup"); ?>"><span><?php echo $html->image("/{$this->plugin}/img/conf.gif", array('border' => 0, 'align' => 'middle')); ?><br />
        <?php echo __t(("Setup"); ?></span></a></td>
    </tr>
</table>
