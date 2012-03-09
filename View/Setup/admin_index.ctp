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



<h1 class="main-title"><?php echo __t(("Preferences & Configuration"); ?></h1>


<br />
<div class="main">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="50%" align="left" valign="top">
        <div class="form-container">

        <div align="center" class="centermain">
            <div id="tabs">
                <div class="tab"><a href="#"><?php echo __t(("E-Mail Configuration"); ?></a></div>
            </div>

            <div class="module">
                <div class="module-head">&nbsp;</div>

                <div class="module-wrap">
                    <form id="email_setup_form" method="post" action=""    onsubmit="save_setup('email_setup_form'); return false;">
                        <input name="data[ModuleConfig][act]" type="hidden" value="email_setup">
                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                            <tr>
                                <td width="27%" align="left"><b><?php echo __t(("Messages Per Refresh"); ?>
                                    <a href="#" <?php $html->tooltip(__t("This is the number of messages that the program will send before it pauses and then refreshes. The default setting is 50 messages and this number should be increased or decreased based on the load of your server.<br/><br/><b>Important:</b> This module works by delivering X number of messages, then pausing X number of seconds. This process is called a cycle and is used to help you prevent your mail server from being overwhelmed and to prevent PHP timeouts.")); ?>>[?]</a>:</b>
                                </td>
                                <td width="73%" align="left"><input name="data[ModuleConfig][messages_per_refresh]" type="text"    class="text" value="<?php e(Configure::read('QuickLetter.settings.messages_per_refresh')); ?>"    size="5" maxlength="3"></td>
                            </tr>
                            <tr>
                                <td align="left"><b><?php echo __t(("Pause Between Refreshes"); ?>
                                <a href="#" <?php $html->tooltip(__t("This is the number of seconds that the program will pause between refreshes. The default setting is 1 second; however, you are free to increase or decrease this based on the load of your server.<br /><br /><b>Important:</b><br />This program has the ability to pause between refreshes to allow you to prevent your mail server from being overwhelmed and to prevent PHP timeouts.")); ?>>[?]</a>:</b></td>
                                <td align="left"><input    name="data[ModuleConfig][pause_between_refreshes]" type="text" class="text" size="5" maxlength="3" value="<?php e(Configure::read('QuickLetter.settings.pause_between_refreshes')); ?>">&nbsp;<?php echo __t(('seconds'); ?></td>
                            </tr>
                            <tr>
                                <td align="left"><b><?php echo __t(("Queue Timeout"); ?>
                                <a href="#" <?php $html->tooltip(__t("This is the number of seconds that the program will consider your sending queue still active. After this number, the program will assume that your sending process has stalled at it will allow you to resume the stalled send.<br /><br /><b>Important:</b><br />This number <em>must</em> be higher than your \"Pause Between Refreshes\" number or the program will consider your active sending queue stalled when it is not.")); ?>>[?]</a>:</b></td>
                                <td align="left">
                                    <input name="data[ModuleConfig][queue_timeout]" type="text" class="text" id="queue_timeout" size="5" maxlength="3" value="<?php e(Configure::read('QuickLetter.settings.queue_timeout')); ?>">&nbsp;<?php echo __t(('seconds'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">
                                <hr />
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <b><?php echo __t(("Message Delivery Method"); ?>
                                    <a href="#" <?php $html->tooltip(__t("This module provides you with the option of choosing what method you use to deliver your messages to your subscribers.")); ?>>[?]</a>:</b>
                                </td>
                                <td align="left">
                                    <select name="data[ModuleConfig][delivery_method]"    id="delivery_method" onChange="optionsDisplay(this.value);">
                                        <option value="mail" <?php echo (Configure::read('QuickLetter.settings.delivery_method') == "mail") ? ' selected="selected" ': ''; ?>>PHP mail()</option>
                                        <option value="smtp"<?php echo (Configure::read('QuickLetter.settings.delivery_method') == "smtp") ? ' selected="selected" ': ''; ?>>SMTP Server</option>
                                        <option value="gmail" <?php echo (Configure::read('QuickLetter.settings.delivery_method') == "gmail") ? ' selected="selected" ': ''; ?>>Gmail</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">
                                    <div id="smtpOptions" style="display: <?php echo (Configure::read('QuickLetter.settings.delivery_method') == "smtp") ? "" : "none" ; ?>">
                                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                            <tr>
                                                <td width="30%" align="left"><b><?php echo __t(("SMTP Server Address"); ?>:</b></td>
                                                <td width="70%" align="left"><input type="text" class="text"    name="data[ModuleConfig][SMTP_address]" id="SMTP_address" style="width: 250px;"    value="<?php e(Configure::read('QuickLetter.settings.SMTP_address')); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td align="left"><b><?php echo __t(("SMTP Keep Alive"); ?>:</b></td>
                                                <td align="left">
                                                    <select    name="data[ModuleConfig][SMTP_keep_alive]" id="SMTP_keep_alive">
                                                        <option value="yes"    <?php echo (Configure::read('QuickLetter.settings.SMTP_keep_alive') == "yes") ? ' selected="selected" ': ''; ?>><?php echo __t(("Enabled"); ?></option>
                                                        <option value="no" <?php echo (Configure::read('QuickLetter.settings.SMTP_keep_alive') == "no") ? ' selected="selected" ': ''; ?>><?php echo __t(("Disabled"); ?></option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left"><b><?php echo __t(("SMTP Authentication Enabled"); ?>:</b></td>
                                                <td align="left">
                                                    <select name="data[ModuleConfig][SMTP_auth]" id="SMTP_auth" onchange="optionsAuth(this.value)">
                                                        <option value="false" <?php echo (Configure::read('QuickLetter.settings.SMTP_auth') == "false") ? ' selected="selected" ': ''; ?>><?php echo __t(("No"); ?></option>
                                                        <option value="true" <?php echo (Configure::read('QuickLetter.settings.SMTP_auth') == "true") ? ' selected="selected" ': ''; ?>><?php echo __t(("Yes"); ?></option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="authUsername" style="display: <?php echo (Configure::read('QuickLetter.settings.SMTP_auth') == "true") ? "" : "none" ; ?>;">
                                                <td align="left"><b><?php echo __t(("SMTP Username"); ?>:</b></td>
                                                <td align="left"><input name="data[ModuleConfig][SMTP_user]" type="text" class="text" id="SMTP_user" value="<?php e(Configure::read('QuickLetter.settings.SMTP_user')); ?>"></td>
                                            </tr>
                                            <tr id="authPassword" style="display: <?php echo (Configure::read('QuickLetter.settings.SMTP_auth') == "true") ? "" : "none" ; ?>;">
                                                <td align="left"><b><?php echo __t(("SMTP Password"); ?>:</b></td>
                                                <td align="left">
                                                    <input name="data[ModuleConfig][SMTP_password]" class="text" type="password" id="SMTP_password" value="<?php e(Configure::read('QuickLetter.settings.SMTP_password')); ?>">
                                                </td>
                                            </tr>
                                        </table>

                                        </div>
                                        <div id="gmailOptions" style="display: <?php echo (Configure::read('QuickLetter.settings.delivery_method') == "gmail") ? "" : "none" ; ?>;">
                                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                            <tr>
                                                <td width="30%"><b>Gmail Address:</b></td>
                                                <td width="70%"><input name="data[ModuleConfig][GMAIL_address]"    type="text" class="text" id="GMAIL_address" style="width: 200px;" value="<?php e(Configure::read('QuickLetter.settings.GMAIL_address')); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gmail Server Port:</b></td>
                                                <td><input name="data[ModuleConfig][GMAIL_port]" type="text" class="text" id="GMAIL_port" value="<?php e(Configure::read('QuickLetter.settings.GMAIL_port')); ?>" size="10" maxlength="10"></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gmail Username:</b></td>
                                                <td><input name="data[ModuleConfig][GMAIL_user]" type="text" class="text" id="GMAIL_user" value="<?php e(Configure::read('QuickLetter.settings.GMAIL_user')); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gmail Password:</b></td>
                                                <td>
                                                    <input name="data[ModuleConfig][GMAIL_password]" class="text" type="password" id="GMAIL_password" value="<?php e(Configure::read('QuickLetter.settings.GMAIL_password')); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right"><input class="primary_lg right" type="submit" value="<?php echo __t(('Save'); ?>"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="module-footer">
                <div>&nbsp;</div>
                </div>
            </div>
        </div>

        </div>
        </td>
        <td width="50%" align="left" valign="top">
        <div class="form-container">
            <div align="center" class="centermain">
                <div id="tabs">
                    <div class="tab"><a href="#"><?php echo __t(("Program Preferences"); ?></a></div>
                </div>

                <div class="module">
                    <div class="module-head">&nbsp;</div>

                    <div class="module-wrap">
                        <form id="program_setup_form" method="post" action="" onsubmit="save_setup('program_setup_form'); return false;">
                            <input name="data[ModuleConfig][act]" type="hidden" value="message_setup">
                            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                            <?php
                            foreach ($results as $line) {
                                if (!in_array($line['ModuleConfig']['key'], array('messages_per_refresh','pause_between_refreshes','queue_timeout','delivery_method','SMTP_address','SMTP_keep_alive','SMTP_auth', 'SMTP_user','SMTP_password','GMAIL_address','GMAIL_port','GMAIL_user','GMAIL_password'))) {
                                    ?>
                                <tr>
                                    <td width="27%" align="left"><b><?php echo __t(($line['ModuleConfig']['name']); ?>:</b></td>
                                    <td width="73%" align="left"><textarea rows="2" style="width: 99%;"
                                        name="data[ModuleConfig][<?php e($line['ModuleConfig']['key']); ?>]"><?php e($line['ModuleConfig']['value']); ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">&nbsp;</td>
                                </tr>
                            <?php
                                }
                            }
                            ?>
                                <tr>
                                    <td align="left">&nbsp;</td>
                                    <td align="right"><input type="submit" class="primary_lg right"    value="<?php echo __t(('Save'); ?>"></td>
                                </tr>
                            </table>
                        </form>
                    </div>

                    <div class="module-footer">
                        <div>&nbsp;</div>
                    </div>
                </div>
            </div>

        </div>
        </td>
    </tr>
</table>
</div>
</div>



<div id="setup_errors_dialogue" class="dialogue-wrap"
    style="display: none;">
<div class="dialogue">
<div class="dialogue-content" style="width: 600px">
<div class="wrap">
<div id="setup_errors_dialogue_wrap"></div>
<fieldset class="nopad">
<button type="button" class="primary_lg right"
    onclick="Messaging.kill('setup_errors_dialogue');">Ok</button>
</fieldset>
</div>
</div>
</div>
</div>
