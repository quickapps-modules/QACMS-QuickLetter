<select id="addList_parentList" name="addList_parentList">
    <option value="0"><?php echo __t(("Parent List"); ?></option>
    <?php
    foreach ($groups as $id => $name) {
        $_name    = r("&nbsp;", "", $name);
        $sep    = r($_name, "", $name);
        e("<option value=\"{$id}\">{$sep} {$_name}</option>\n");
    }
    ?>
</select>
