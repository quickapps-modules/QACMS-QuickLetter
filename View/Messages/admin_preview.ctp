<div style="height: 400px;">
<table width="95%" border="0" cellspacing="0" cellpadding="0"
    align="center">
    <tr>
        <td align="left"><b><?php echo __t(("From"); ?>:</b></td>
        <td align="left"><?php e($this->data['Message']['from_field']); ?></td>
    </tr>
    <?php if (isset($this->data['Message']['test_mails']) && !empty($this->data['Message']['test_mails'])) { ?>
    <tr>
        <td align="left"><b><?php echo __t(("For"); ?>:</b></td>
        <td align="left"><?php e($this->data['Message']['test_mails']); ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td width="120" align="left"><b><?php echo __t(("Subject"); ?>:</b></td>
        <td width="510" align="left"><?php e($this->data['Message']['subject']); ?></td>
    </tr>
    <tr>
        <td colspan="2" align="left">
        <hr />
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left">
        <div class="tab-container">
        <div id="tabs">
        <ul id="tabMenu" class="tabs">
            <li><a href="#panel_plain" rel="panel_plain"><span>Plain Text</span></a></li>
            <li><a href="#panel_html" rel="panel_html"><span>HTML</span></a></li>
        </ul>

        <div id="panel_html"
            style="height: 300px; overflow-y: auto; overflow-x: auto; width: 100%;"><?php e($this->data['Message']['body_html'])."<br/><br/><br/>".nl2br($this->data['Message']['footer']); ?></div>
        <div id="panel_plain"
            style="height: 300px; overflow-y: auto; overflow-x: auto; width: 100%;"><?php e( nl2br($this->data['Message']['body_text'])."<br/><br/><br/>".nl2br($this->data['Message']['footer']) ); ?></div>
        </div>
        </div>
        </td>
    </tr>
</table>
</div>
<script type="text/javascript">
    var prototabs = new ProtoTabs('tabMenu', {defaultPanel: 'panel_html'});
</script>
