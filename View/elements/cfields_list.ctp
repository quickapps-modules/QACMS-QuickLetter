                        <!-- table -->
                        <form id="cfieldsFrom">
                        <table width="100%" id="table_list" class="tablekit">
                            <thead>
                                <tr>
                                    <th width="2%" align="center" class="nosort"><input type="checkbox"    id="checkAll" onClick="chkAll(this);"></th>
                                    <th width="21%" align="left" class="text"><?php echo __t(("Name"); ?></th>
                                    <th width="56%" align="left" class="text"><?php echo __t(("Preview"); ?></th>
                                    <th width="15%" align="left" class="text"><?php echo __t(("Belongs To"); ?></th>
                                    <th width="6%" align="center" class="<?php echo __t(("date-iso"); //es: date-eu ?>"><?php echo __t(("Order"); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td id="list-alert" colspan="5" style="display: none;" align="center">
                                    <?php echo __t(("No items that match your filter settings were found."); ?>
                                    </td>
                                </tr>
                                <?php
                                if (count($results) > 0) {//mostrar si hay registros
                                    foreach ($results as $item) {
                                        ?>
                                <tr class="content">
                                    <td align="center"><input type="checkbox" name="data[Cfield][id][]" value="<?php e($item['Cfield']['id']); ?>" /></td>
                                    <td align="left"><a href="#" onclick="cfield_form(<?php e($item['Cfield']['id']); ?>); return false;"><?php e($item['Cfield']['lname']); ?></a></td>
                                    <td align="left"><?php echo $cfield->render($item['Cfield'], null, array('attributes' => array('class' => 'text') )); ?></td>
                                    <td align="left"><?php e($item['Cfield']['belongsTo']); ?></td>
                                    <td align="center"><input type="text" class="text" name="data[Cfield][ordering][<?php e($item['Cfield']['id']); ?>]" value="<?php e($item['Cfield']['ordering']); ?>" size="3" /></td>
                                </tr>
                                <?php
                                    }

                                }else{//si no hay registros que mostrar:
                                    ?>
                                <tr>
                                    <td align="center" colspan="5"><br />
                                    <?php echo __t(("You have no custom fields."); ?><br />
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" align="center">&nbsp;</th>
                                </tr>

                            </tfoot>
                        </table>
                        </form>
                        <!-- table -->