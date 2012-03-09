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

<h1 class="main-title"><?php echo __t(("User's Groups"); ?></h1>


<div class="main">

<div id="addForm" onsubmit="add_list(); return false;">
<form action="" method="post">
<table width="100%">

    <tr>
        <td width="45%">&nbsp;</td>
        <td align="right"><input name="act" type="hidden" id="act" value="add">
        <input type="text" class="text" value="<?php echo __t(("Group Name"); ?>"
            name="addList_name" id="addList_name"
            onFocus="if (this.value == '<?php echo __t(("Group Name");?>') {this.value = ''}"
            onBlur="if (this.value == '') {this.value = '<?php echo __t(("Group Name");?>'}" />
        &raquo;
        <div id="lists_select" style="display: inline;"><?php echo $this->element("groups_selectbox"); ?>
        </div>
        <input class="primary_lg" type="submit" value="<?php echo __t(("Add"); ?>" />

        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>

</form>
</div>
<!-- add form -->

<table width="100%">
    <tr>
        <td width="8%" align="left">&nbsp;</td>
        <td width="43%">&nbsp;</td>
        <td width="49%" align="right">&nbsp;</td>
    </tr>
</table>


<?php echo $html->css("/{$this->plugin}/js/ext-2.0.1/resources/css/ext-custom.css"); ?>
<?php echo $javascript->link("/{$this->plugin}/js/ext-2.0.1/ext-custom.js"); ?>

<div id="groups_list"><?php e($this->element('groups_table')); ?></div>

</div>
</div>


<div id="groups_list_dialogue" class="dialogue-wrap"
    style="display: none;">
<div class="dialogue">
<div class="dialogue-content" style="width: 600px">
<div class="wrap">
<div id="groups_list_dialogue_wrap"></div>
<fieldset class="nopad">
<button type="button" class="primary_lg right"
    onclick="Messaging.kill('groups_list_dialogue');"><?php echo __t(("Close"); ?></button>
</fieldset>
</div>
</div>
</div>
</div>

