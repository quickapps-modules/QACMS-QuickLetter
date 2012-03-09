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



<div class="main">
<table width="100%">
    <tr>
        <td width="100%" align="left" valign="top"><?php echo $this->element('users_sub_nav'); ?>
        </td>
    </tr>

    <tr>
        <td align="left" valign="top">


        <div align="center" class="centermain">
        <div id="tabs">
        <div class="tab"><a href="#"><?php  echo __t(("Import Mailing List"); ?></a></div>
        </div>
        <div class="module">
        <div class="module-head">&nbsp;</div>
        <div class="module-wrap">
        <div class="form-container">
        <form enctype="multipart/form-data" method="post" id="importForm" action="<?php echo $html->url("/{$this->plugin}/users/import/prepare"); ?>">
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr>
                <td colspan="2" align="left" valign="top"><b><?php echo __t(("Imported Data Source"); ?></b></td>
                <td width="50%" align="left" valign="top"><b><?php echo __t(("Imported Data Destination"); ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="left" valign="top"><input type="radio"
                    name="data[Import][type]" id="type_csv" value="csv"
                    onclick="$('div_type_csv').show(); $('div_type_text').hide();"> <?php echo __t(("I would like to upload and import a Comma Separated Values (CSV) file."); ?><br />
                <input type="radio" name="data[Import][type]" id="type_text"
                    value="text"
                    onclick="$('div_type_csv').hide(); $('div_type_text').show();"> <?php echo __t(("I would like to paste CSV data into a textarea to import."); ?><br />

                <br />
                <br />
                <div id="div_type_csv" style="display: none;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="33%" align="left" valign="middle"><b><?php echo __t(("Select Your Local CSV File:"); ?></b></td>
                        <td width="67%" align="left" valign="middle"><span id="btnBrowse">&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" colspan="2"><div class="flash" id="fsUploadCsv"></div></td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td colspan="2" align="left" valign="top"><b><?php echo __t(("Important Notice:"); ?></b>
                        <?php printf(__t("Please be aware that your server's maximum upload file size is set to %sB and that we suggest making your import files small than 1,000 rows at a time to prevent server timeouts."), ini_get('upload_max_filesize')); ?>
                        </td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                </table>
                </div>

                <div id="div_type_text" style="display: none;"><b><?php echo __t(("Please Paste CSV Data Below:"); ?><b /><br />
                <textarea name="data[Import][csvtext]" rows="5" style="width: 99%;"></textarea></div>

                </td>
                <td align="left" valign="top"><?php echo __t(("Please select the group or groups that you would like these importees subscribed to:"); ?><br />
                <?php echo $this->element('groups_multiselect'); ?></td>
            </tr>
            <tr>
                <td align="left" valign="top"><?php echo __t(("Fields Enclosed By"); ?>:</td>
                <td colspan="2" align="left" valign="top"><input
                    name="data[Import][fields_enclosed]" type="text" class="text"
                    value="&quot;" size="3"></td>
            </tr>

            <tr>
                <td width="15%" align="left" valign="top"><?php echo __t(("Fields Delimited By"); ?>:</td>
                <td colspan="2" align="left" valign="top"><input
                    name="data[Import][fields_delimited]" id="textfield" class="text"
                    value="," size="3"></td>
            </tr>
            <tr>
                <td colspan="3" align="left" valign="top">
                <hr />
                </td>
            </tr>
            <tr>
                <td colspan="3" align="left" valign="top"><b><?php echo __t(("Import Options"); ?></b></td>
            </tr>
            <tr>
                <td colspan="3" align="left" valign="top"><input type="checkbox"
                    name="data[Import][options][firstrowfields]" value="1"
                    checked="checked" />&nbsp;<?php echo __t(("The first row in the file/data contains the field names; try to match those."); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right" valign="top">
                    <input type="button" onclick="import_csv('validate', 'prepare');" class="primary_lg" value="<?php echo __t(("Select Fields »"); ?>">
                </td>
            </tr>
        </table>

        </form>
        </div>
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




    <?php echo $javascript->link("/{$this->plugin}/js/swfupload/swfupload.js"); ?>
    <?php echo $javascript->link("/{$this->plugin}/js/swfupload/swfupload.queue.js"); ?>
    <?php echo $javascript->link("/{$this->plugin}/js/swfupload/fileprogress.js"); ?>
    <?php echo $javascript->link("/{$this->plugin}/js/swfupload/handlers.js"); ?>

<script type="text/javascript">
        var swfu;
        window.onload = function() {
            swfu = new SWFUpload({
                upload_url: '<?php echo $html->url("/{$this->plugin}/users/import/upload", true); ?>',
                post_params : { "PHPSESSID": '<?php echo $session->id();?>' },

                file_types : "*.csv; *.Csv; *.CSV",
                file_types_description : "Archivos CSV",
                file_upload_limit : 0,
                file_queue_limit : 1,


                file_dialog_start_handler: fileDialogStart,
                file_queued_handler : fileQueued,
                file_queue_error_handler : fileQueueError,
                file_dialog_complete_handler : fileDialogComplete,

                upload_progress_handler : uploadProgress,
                upload_error_handler : uploadError,
                upload_success_handler : uploadSuccess,
                upload_complete_handler : uploadComplete,


                flash_url : "<?php echo $html->url("/{$this->plugin}/js/swfupload/swfupload.swf"); ?>",

                // Fix Flash PLayer 10
                button_placeholder_id : "btnBrowse",
                button_image_url: '<?php echo $html->url("/{$this->plugin}/img/uploader/upload_btn.png"); ?>',
                button_text : '<?php echo __t(("Browse"); ?>',
                button_width: 61,
                button_height: 22,

                custom_settings : {
                    progressTarget : "fsUploadCsv",
                    cancelButtonId : "fsUploadCsvCancelBtn"
                },

                debug: false,
            });
        };

    </script>


<form method="post" enctype="multipart/form-data" style="display: none;">
    <div id="flashUI1" style="display: none;">
        <div>
            <input id="fsUploadCsvCancelBtn" type="button" class="primary_lg"    value="<?php echo __t(("Stop Upload"); ?>" onClick="cancelQueue(swfu);" disabled="disabled" style="font-size: 8pt;" /> <br />
        </div>
    </div>
    <div id="degradedUI1"></div>
</form>
