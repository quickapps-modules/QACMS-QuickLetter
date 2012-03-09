<div class="form-container">
<form action="" id="addTemplateForm" method="post">
<table width="100%" cellspacing="5">
    <tr>
        <td width="28%" align="left" valign="top"><b><?php echo __t(("Template Name"); ?>:</b></td>
        <td width="72%" colspan="2" align="left" valign="top"><input
            type="text" name="data[Template][name]" class="text" id="name"
            style="width: 200px;" value=""></td>
    </tr>
    <tr>
        <td align="left" valign="top"><b><?php echo __t(("Template Description"); ?>:</b></td>
        <td colspan="2" align="left" valign="top"><input type="text"
            name="data[Template][description]" class="text" id="description"
            style="width: 200px;" value=""></td>
    </tr>
    <tr>
        <td colspan="3" align="left" valign="top"><br />
        <textarea name="data[Template][content]" rows="5"
            id="template_content" style="width: 100%;"><?php e($this->data['Template']['content']); ?></textarea></td>
    </tr>
    <tr>
        <td colspan="3" align="right" valign="top"><input
            class="primary_lg right" type="button"
            onclick="save_template_exe('addTemplateForm'); return false;"
            value="<?php echo __t(("Add Template"); ?>"></td>
    </tr>
</table>

</form>


</div>
<script language="javascript" type="text/javascript">

    tinyMCE.init({
        // General options
        mode : "exact",
        elements : "template_content",
        theme : "advanced",

        plugins : "imagemanager,filemanager,preview,table,inlinepopups,media,contextmenu,fullscreen,advimage, pagebreak, template",
        pagebreak_separator : "<!-- readmore -->",
        language : "<?php e(Configure::read('Config.language_1')); ?>",
        convert_urls : false,

        imagemanager_rootpath : "../../../../<?php e(Configure::read('_UPLOAD_FOLDER').Configure::read('_APP.user_setup.uploadFolder')); ?>/images",
        filemanager_rootpath : "../../../../<?php e(Configure::read('_UPLOAD_FOLDER').Configure::read('_APP.user_setup.uploadFolder')); ?>/images",

        template_external_list_url: base_url+'mod_newsletters/templates/list_js',

        height : "250",
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,formatselect,fontselect,fontsizeselect,|, media, fullscreen, preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,template,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "external",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        theme_advanced_resize_horizontal : false
    });


</script>
