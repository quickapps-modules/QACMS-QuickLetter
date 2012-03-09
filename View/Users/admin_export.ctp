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
          <div class="tab"><a href="#"><?php echo __t(("Export Mailing List"); ?></a></div>
        </div>
        <div class="module">
          <div class="module-head">&nbsp;</div>
         <div class="module-wrap">



                <form action="" id="exportForm" method="post">

                <table width="100%" border="0" cellspacing="5" cellpadding="0">
                  <tr>
                    <td colspan="3" align="left" valign="top"><?php echo __t(("Please select which fields you would like to be included with this export using the form below"); ?>:</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><b>Standard Exportable Fields</b></td>
                    <td width="50%" align="left" valign="top"><b>Custom Exportable Fields</b></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><input name="data[Export][Fields][]" type="checkbox" id="id" value="id" checked="checked" onclick="alert('<?php echo __t(('The subscriber id must be present in all exports, you cannot de-select this field.'); ?>'); return false" /> <b>id</b></td>
                    <td align="left" valign="top"><?php echo __t(("ID of the subscriber in the database."); ?></td>
                    <td rowspan="4" align="left" valign="top">

                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                        <?php foreach ($cfields as $cfield) {    ?>
                      <tr>
                        <td width="30%" align="left"><input name="data[Export][Fields][]" type="checkbox" value="cfield-<?php echo $cfield['Cfield']['sname']; ?>" /> <b><?php echo $cfield['Cfield']['lname']; ?></b></td>
                        <td width="70%" align="left">[<?php echo $cfield['Cfield']['sname']; ?>]</td>
                      </tr>
                      <?php } ?>

                    </table>

                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><input name="data[Export][Fields][]" type="checkbox" id="name" value="name" /> <b>name</b></td>
                    <td align="left" valign="top"><?php echo __t(("Name of the subscriber."); ?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><input name="data[Export][Fields][]" type="checkbox" id="email" value="email" /> <b>email</b></td>
                    <td align="left" valign="top"><?php echo __t(("E-mail address of the subscriber."); ?></td>
                  </tr>
                  <tr>
                    <td width="10%" align="left" valign="top"><input name="data[Export][Fields][]" type="checkbox" id="created" value="created" /> <b>created</b></td>
                    <td width="40%" align="left" valign="top"><?php echo __t(("Date the subscriber joined your database."); ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><b>CSV Export Options</b></td>
                    <td align="left" valign="top"><b>Export Groups</b></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><?php echo __t(("Fields Enclosed By"); ?>:</td>
                    <td align="left" valign="top"><input name="data[Export][enclosed]" type="text" class="text" value="&quot;" size="3" /></td>
                    <td align="left" valign="top">Please select the group or groups that you would like to export subscribers from:</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><?php echo __t(("Fields Delimited By"); ?>:</td>
                    <td align="left" valign="top"><input name="data[Export][delimited]" type="text" class="text" value="," size="3" /></td>
                    <td align="left" valign="top">

                            <select name="data[Export][Group][]" size="5" multiple="multiple" style="width:99%;">
                                <?php
                                    foreach ($groups as $id => $name) {
                                        e("<option value=\"{$id}\">{$name}</option>\n");
                                    }
                                ?>
                            </select>

                    </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right" valign="top">
                    <input type="button" class="primary_lg" onclick="export_csv();" value="<?php echo __t(("Export List"); ?>" />
                    </td>
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
