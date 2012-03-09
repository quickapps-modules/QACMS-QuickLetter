
<table width="100%" id="table_list" class="tablekit">
    <thead>
        <tr>
            <th width="2%" align="center" class="nosort"><input type="checkbox"
                id="checkAll" onClick="chkAll(this);"></th>
            <th width="39%" align="left" class="text"><?php echo __t(("Title"); ?></th>
            <th width="59%" align="left" class="text"><?php echo __t(("Description"); ?></th>
        </tr>
    </thead>

    <tbody>
    <?php
    if (count($results) > 0) {//mostrar si hay registros
        foreach ($results as $template) {
            ?>
        <tr class="content">
            <td align="center"><input type="checkbox" name="data[Template][id][]"
                value="<?php e($template['Template']['id']); ?>" /></td>
            <td align="left"><a href=""
                onclick="edit_template(<?php e($template['Template']['id']); ?>); return false;"><?php e($template['Template']['name']); ?></a></td>
            <td align="left"><a href=""
                onclick="edit_template(<?php e($template['Template']['id']); ?>); return false;"><?php e($template['Template']['description']); ?></a></td>
        </tr>
        <?php
        }

    }else{//si no hay registros que mostrar:
        ?>
        <tr>
            <td align="center" colspan="3"><br />
            <?php echo __t(("You have no templates."); ?><br />
            </td>
        </tr>
        <?php }?>

    </tbody>

    <tfoot>

        <tr>
            <th colspan="3" align="center"><span class="paginator"> <?php $paginator->options(array('url'=> $this->passedArgs)); ?>
            <?php echo $paginator->prev('« ', null, null, array('class' => 'disabled')); ?>
            <?php echo $paginator->numbers(array('separator' => ' ')); ?> <?php echo $paginator->next(' »', null, null, array('class' => 'disabled')); ?>
            </span></th>
        </tr>

        <tr class="row1">
            <td colspan="3" align="center">
            <form action="" method="post"><?php echo __t(("Rows per Page"); ?>: <input
                name="rows_per_page" type="text" id="rows_per_page"
                value="<?php echo Configure::read('rows_per_page') ?>" size="3" /></form>
            </td>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
    TableKit.unloadTable('table_list');
    TableKit.Sortable.init('table_list');
</script>



