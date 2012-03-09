<table width="90%" border="0" cellspacing="0" cellpadding="0"
    align="center">
    <tr>
        <td width="122" align="left"><b><?php echo __t(("Availables News"); ?>:</b></td>
        <td width="508" align="left"><select name="news_select"
            id="news_select" onChange="render_news_preview(this.value);">
            <option value=""><?php echo __t(('Select by Title'); ?></option>
            <?php foreach ($news as $item) { ?>
            <option value="<?php e($item['News']['id']); ?>"><?php e($item['News']['title']); ?></option>
            <?php } ?>
        </select></td>
    </tr>
    <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
    </tr>
    <tr>
        <td align="left"><b><?php echo __t(("News Preview"); ?>:</b></td>
        <td align="left">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" align="left">
        <div id="news_preview"
            style="width: 630px; height: 380px; overflow: auto; border: 1px solid #CCCCCC;"></div>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left"><br />
        <button onClick="import_news_content(); return false;"
            class="primary_lg"><?php echo __t(('Import'); ?></button>
        </td>
    </tr>
</table>
