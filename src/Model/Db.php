<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 syntax=php: */
declare(strict_types=1);

namespace App\Model;

use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

class Db
{
    protected $dbcName = 'default';
    protected $dbName = null;
    protected $db;

    public function __construct(string $name = null)
    {
        if ($name) {
            $this->dbcName = $name;
        }
        $this->db = ConnectionManager::get($this->dbcName);

        $this->dbName = $this->db->config()['database'];

        // dump($this->db->config());

        return;
    }

    public function getDbName()
    {
        return $this->dbName;
    }

    public function getDbcName()
    {
        return $this->dbcName;
    }


    public function getDatabases()
    {
        $sql = "SHOW DATABASES";
        $rows = $this->db->execute($sql)->fetchAll('assoc');                          
        return $rows;
    }

    public function getTableStatus($dbName)
    {
        $sql = "SHOW TABLE STATUS FROM {$dbName}";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['status'] = $rows;
        $result['status_head'] = ['Name', 'Comment', 'Rows'];

        return $result;
    }

    /**
     * テーブルの情報を取得
     *
     */
    public function getTableInfo($tableName, $dbName)
    {
        $result = array();

        $sql = "USE {$dbName}";
        $rows = $this->db->execute($sql);

        $sql = "SHOW FULL COLUMNS FROM {$tableName}";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['columns'] = $rows;
        $result['columns_head'] = $this->getHead($rows, 'Privileges');
        // value を指定して unset 

        $sql = "SHOW INDEX FROM {$tableName}";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['index'] = $rows;
        $result['index_head'] = $this->getHead($rows);

        $sql = "SHOW TABLE STATUS WHERE Name='{$tableName}'";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['status'] = $rows;
        $result['status_head'] = $this->getHead($rows);

        $sql = "SHOW CREATE TABLE {$tableName}";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['create'] = $rows;

        return $result;
    }

    /**
     * テーブル情報表のheadを取得する
     *
     * @param array table info
     * @param string ignore head scv
     */
    public function getHead($rows, string $ignores = '')
    {
        $result = [];
        $igno = explode(',', $ignores);
        foreach ($rows[0] as $key => $value) {
            if (in_array($key, $igno)) {
                continue;
            }
            $result[] = $key;
        }

        return $result;
    }

}