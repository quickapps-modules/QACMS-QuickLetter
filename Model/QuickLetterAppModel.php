<?php
class QuickLetterAppModel extends AppModel {
    public function optimize() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $tablename = $db->fullTableName($this);

        if (!empty($tablename)) {
            return $db->query("OPTIMIZE TABLE {$tablename};");
        } else {
            return false;
        }
    }
}