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

<?php echo $this->element('users_sub_nav'); ?>

<!--<h1 class="main-title"><?php echo __t(('Editing User'); ?></h1>-->

<div class="main">
<table width="100%">
    <tr>
        <td align="left" valign="top">
        <div class="form-container">
        <form id="addUserForm" action="" method="post"><?php echo $form->hidden("User.id"); ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="50%" align="left" valign="top">
                    <div align="center" class="centermain">
                        <div id="tabs">
                            <div class="tab"><a href="#"><?php echo __t(("Basic User Data"); ?></a></div>
                        </div>

                        <div class="module">
                            <div class="module-head">&nbsp;</div>
                            <div class="module-wrap">
                                <table width="100%" border="0" align="center" cellpadding="0"
                                    cellspacing="5">
                                    <tr>
                                        <td width="21%" align="left" valign="top"><b><?php echo __t(("Name"); ?>:
                                        *</b></td>
                                        <td width="79%" align="left" valign="top"><?php echo $form->input("User.name", array('type' => 'text', 'label' => false, 'style' => 'width:200px;')); ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top"><b><?php echo __t(("Email"); ?>: *</b></td>
                                        <td align="left" valign="top"><?php echo $form->input("User.email", array('type' => 'text', 'label' => false, 'style' => 'width:200px;')); ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top"><b><?php echo __t(("Confirmed"); ?>:</b></td>
                                        <td align="left" valign="top"><?php echo $form->input("User.status", array('type' => 'checkbox', 'label' => false, 'default' => 1)); ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top"><b><?php echo __t(("Send HTML emails"); ?>:</b></td>
                                        <td align="left" valign="top"><?php echo $form->input("User.html_email", array('type' => 'checkbox', 'label' => false, 'default' => 1)); ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top"><b><?php echo __t(("Gender"); ?>:</b></td>
                                        <td align="left" valign="top"><?php echo $form->select("User.gender", array('male' => __t('Male'), 'female' => __t('Female'))); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">&nbsp;</td>
                                        <td align="right" valign="top">
                                        <button class="primary_lg"
                                            onclick="add_user('addUserForm'); return false;"><?php echo __t(("Update User"); ?></button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="module-footer">
                                <div>&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td width="50%" align="left" valign="top">
                    <div align="center" class="centermain">
                        <div id="tabs">
                            <div class="tab"><a href="#"><?php echo __t(('Groups'); ?></a></div>
                        </div>

                        <div class="module">
                            <div class="module-head">&nbsp;</div>
                            <div class="module-wrap">
                                <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                    <tr>
                                        <td width="17%" align="left" valign="top"><b><?php echo __t(("Subscriber List"); ?>:</b></td>
                                        <td width="83%" align="left" valign="top"><?php echo $this->element('groups_checkboxes'); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="module-footer">
                                <div>&nbsp;</div>
                            </div>
                        </div>
                    </div><!-- cfields -->

                <div align="center" class="centermain">
                    <div id="tabs">
                        <div class="tab"><a href="#"><?php echo __t(("Custom Fields"); ?></a></div>
                    </div>

                    <div class="module">
                        <div class="module-head">&nbsp;</div>
                        <div class="module-wrap">
                            <table width="100%" cellspacing="5">

                            <?php
                                foreach ($cfields as $_cfield) {
                                    $cdata = Set::extract("/.[cfield_id={$_cfield['Cfield']['id']}]", $this->data['Cdata']);
                            ?>
                            <tr>
                                <td width="21%" align="left" valign="top">
                                    <b><?php e($_cfield['Cfield']['lname']); ?>
                                    <?php echo ($_cfield['Cfield']['req']) ? "*": ""; ?></b>
                                </td>
                                <td width="79%" align="left" valign="top"><?php echo $cfield->render($_cfield['Cfield'], @$cdata[0], array('class' => 'text'));    ?></td>
                            </tr>

                            <tr>
                                <td colspan="2" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <?php } ?>


                            </table>
                        </div>
                        <div class="module-footer">
                            <div>&nbsp;</div>
                        </div>
                    </div>
                </div><!-- cfields -->

                </td>
            </tr>
        </table>
        </form>
        </div>
        </td>
    </tr>
</table>
</div>
</div>


<div id="users_dialogue" class="dialogue-wrap" style="display: none;">
    <div class="dialogue">
        <div class="dialogue-content" style="width: 600px">
            <div class="wrap">
                <div id="users_dialogue_wrap"></div>
                <fieldset class="nopad">
                    <button type="button" class="primary_lg right"    onclick="Messaging.kill('users_dialogue');">Ok</button>
                </fieldset>
            </div>
        </div>
    </div>
</div>


