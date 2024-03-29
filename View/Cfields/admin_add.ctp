      <div align="center" class="centermain">
        <div id="tabs">
          <div class="tab"><a href="#"><?php echo __t(("Add New Field"); ?></a></div>
        </div>
        <div class="module">
          <div class="module-head">&nbsp;</div>
          <div class="module-wrap">
            <form method="post" id="cfieldForm" action="">
                <input name="data[Cfield][id]" type="hidden" value="<?php e($result['Cfield']['id']); ?>">
              <table width="100%" align="center" cellspacing="5">
                <tr>
                  <td width="41%" align="left" valign="middle"><b><?php echo __t(("Field Type"); ?> <a href="" <?php echo $html->tooltip(__t("This is the type of custom field that you are looking at adding. Currently you can select a number of different HTML field types as well as a linebreak.")) ?>>[?]</a>:</b><br/></td>
                  <td width="59%" align="left" valign="middle">
                  <?php echo $form->select("Cfield.type",
                            array(    'checkbox' => __t('Checkbox'),
                                    'radio' => __t('Radio Buttons'),
                                    'select' => __t('Select Box'),
                                    'hidden' => __t('Hidden Field'),
                                    'linebreak' => __t('Linebreak'),
                                    'textarea' => __t('Textarea'),
                                    'textbox' => __t('Textbox')

                            ),
                            null,
                            array(
                                'onchange' => "if (this.value == 'radio' || this.value == 'checkbox' || this.value == 'hidden' || this.value == 'select') { $('foptions').show(); } else { $('foptions').hide();} ;"
                            )
                    );
                  ?>
                  </td>
                </tr>

                <tr id="foptions" style="display:none;">
                  <td align="left" valign="top"><b><?php echo __t(("Field Options"); ?> <a href="" <?php echo $html->tooltip(__t("This is the options or defined value(s) of your custom field. If you are using a checkbox, radio button or select box you will want to specify your options here.<br/><br/><b>Example:</b><br/>blue=Blue<br/>red=Red<br/>green=Green<br/>value=Label")); ?>>[?]</a>:</b><br/>
                  <?php echo __t(("(required for radio buttons, select boxes, check boxes and hidden field valued only.)"); ?>
                  </td>
                  <td align="left" valign="middle">
                  <?php echo $form->textarea("Cfield.options", array('label' => false, 'style' => 'width:360px; height: 125px')); ?>
                  </td>
                </tr>

                <tr>
                  <td align="left" valign="middle"><b><?php echo __t(("Field Short Name"); ?> <a href="" <?php echo $html->tooltip(__t("This is a short name for the field that must be all lowercase, all one word and no special characters. This field must also be unique because it is what you will use to call this field in a custom e-mail placeholder!")) ?>>[?]</a>:</b></td>
                  <td align="left" valign="middle">
                  <?php echo $form->input("Cfield.sname", array('type' => 'text', 'label' => false, 'style' => 'width:125px;', 'maxlength' => '16')); ?>
                  </td>
                </tr>

                <tr>
                  <td align="left" valign="middle"><b><?php echo __t(("Field Display Name"); ?> <a href="" <?php echo $html->tooltip(__t("This is the title or longer name for your custom field. This could also be a question.")); ?>>[?]</a>:</b></td>
                  <td align="left" valign="middle">
                  <?php echo $form->input("Cfield.lname", array('type' => 'text', 'label' => false, 'style' => 'width:360px;', 'maxlength' => '64')); ?>
                  </td>
                </tr>
                <tr>
                  <td align="left" valign="middle">&nbsp;</td>
                  <td align="left" valign="middle">&nbsp;</td>
                </tr>

                <tr>
                  <td align="left" valign="middle"><b><?php echo __t(("Maxlength"); ?> <a href="" <?php echo $html->tooltip(__t("This is only used if your Field Type is a textbox. This will limit the subscriber to typing X number of characters in your textbox.")); ?>>[?]</a>:</b><br/><?php echo __t(("(used only for text boxes)"); ?></td>
                  <td align="left" valign="middle">
                  <?php echo $form->input("Cfield.length", array('type' => 'text', 'label' => false, 'style' => 'width:50px;', 'maxlength' => '12')); ?>
                  </td>
                </tr>

                <tr>
                  <td align="left" valign="middle"><b><?php echo __t(("Required Field"); ?> <a href="" <?php echo $html->tooltip(__t("Specify whether you want this custom field to be a required field or you can have it set to be optional.")); ?>>[?]</a>:</b><br/><?php __t("(is this field required when users sign-up?)"); ?></td>
                  <td align="left" valign="middle">
                    <?php echo $form->select("Cfield.req", array(1 => __t('Yes'), 0 => __t('No'))); ?>
                  </td>
                </tr>

                <tr>
                  <td width="41%" align="left" valign="middle"><b><?php echo __t(('Validate On'); ?> <a href="" <?php echo $html->tooltip(__t("If a rule has defined on ‘create’, the rule will only be enforced during the creation of a new record. Likewise, if it is defined as on ‘update’, it will only be enforced during the updating of a record.")) ?>>[?]</a>:</b><br/></td>
                  <td width="59%" align="left" valign="middle">
                  <?php echo $form->select("Cfield.validate_on",
                            array(    'both' => __t('Both'),
                                    'create' => __t('Create'),
                                    'update' => __t('Update')
                            ),
                            null
                    );
                  ?>
                  </td>
                </tr>

                <tr>
                  <td align="left" valign="middle">
                    <b><?php echo __t(("Pattern"); ?> <a href="" <?php echo $html->tooltip(__t("Type of verification to use. Make sure you know syntax of regular programing expressions to edit the fields.<br/><br/><b>Example:</b> <em>(Only letters and integers)</em><br/><br/>/^[a-z0-9]{3,}$/i")); ?>>[?]</a>:</b>
                    <?php if (function_exists('json_decode')) { ?>
                    <br/>
                    <em><?php echo __t(('JSON code supported'); ?></em>
                    <?php } ?>
                  </td>                  <td align="left" valign="middle">
                    <?php echo $form->textarea("Cfield.pattern",  array('label' => false, 'style' => 'width:360px;', 'maxlength' => '255')); ?>
                  </td>
                </tr>

                <tr>
                  <td align="left" valign="middle"><b><?php echo __t(("Message Error"); ?> <a href="" <?php echo $html->tooltip(__t("Validation message")); ?>>[?]</a>:</b></td>
                  <td align="left" valign="middle">
                    <?php echo $form->input("Cfield.validation_message",  array('type' => 'text', 'label' => false, 'style' => 'width:360px;', 'maxlength' => '255')); ?>
                  </td>
                </tr>


                <tr>
                  <td align="left" valign="middle">&nbsp;</td>
                  <td align="right" valign="middle">
                        <input type="button" class="primary_lg right" value="<?php echo __t(("Cancel"); ?>" onclick="Effect.toggle('formContainer', 'slide');" />
                        <input type="button" class="primary_lg right" value="<?php echo __t(("Add Field"); ?>" onclick="add_cfield(false);"  />
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
<script type="text/javascript">
    setup_tooltips();
</script>
