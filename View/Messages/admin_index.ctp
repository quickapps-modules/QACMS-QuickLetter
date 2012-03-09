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

<h1 class="main-title"><?php echo __t(("Messages"); ?></h1>


<div class="main">


<div align="center" class="centermain">
<div id="tabs">
<div class="tab"><a href="#"
    onclick="Effect.toggle('searchForms', 'slide'); return false;"
    style="cursor: pointer;"><?php echo __t(("Quick Search"); ?></a></div>
</div>
<div class="module">
<div class="module-head">&nbsp;</div>
<div class="module-wrap" id="searchForms" style="<?php echo (isset($this->data['Message'])) ? '' : 'display: none;'; ?>">

<table width="100%" cellspacing="5">
    <!-- search -->
    <tr>
        <td align="left" valign="middle">
        <form name="filter" method="post" action="">
        <table width="100%" cellspacing="5">
            <tr>
                <td width="14%" align="left"><b><?php echo __t(("Message"); ?>:</b></td>
                <td width="17%" align="left"><?php echo $form->select('Message.filter.by', array(
                                            'name' => __t("Internal Title"),
                                            'subject' => __t("Subject"),
                                            'body_html' => __t("HTML Version"),
                                            'body_text' => __t("Text Version"),
                                            'footer' => __t("Footer"),
                                            'created' => __t("Creation Date"),
                )); ?></td>
                <td width="12%" align="left"><?php echo $form->select('Message.filter.condition', array(
                                            'contains' => __t("Contains"),
                                            'equals' => __t("Equals")
                )); ?></td>
                <td width="44%" align="left"><?php echo $form->text('Message.filter.value', array('class' => 'text-box', 'style' => 'width: 165px')); ?>
                </td>
                <td width="13%" align="left" style="text-align: right"><input
                    class="primary_lg" type="submit" value="Search" class="button" /></td>
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


<table width="100%">
    <tr>
        <td width="50%" align="left" valign="top"><strong><?php echo __t(('With Selected'); ?>:</strong>&nbsp;
        <select id="actions_select" onChange="actions_select(this.value);">
            <option value="0"><?php echo __t(("Select Action"); ?></option>
            <option value="messages/delete"    text="<?php echo __t(("Delete messages"); ?>"><?php echo __t(("Delete"); ?></option>
        </select></td>
    </tr>
</table>

<div id="items_list"><?php e($this->element('messages_list')); ?></div>

</div>
</div>
