<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 syntax=php: */

namespace App\Controller\Component;

use Cake\Controller\Component;

use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Log\LogTrait;

/**
 *
 */
class DbInfoComponent extends Component
{
    use LogTrait {}

    protected $dbcName = 'default'; // connection name
    protected $dbName = null;   // database name
    protected $db;

    public function initialize(array $config): void
    {
        $this->log(__FILE__ . ' ' . __FUNCTION__ . " start ----");

        if (isset($config['dbcName'])) {
            $this->dbcName = $config['dbcName'];
        }
        $this->db = ConnectionManager::get($this->dbcName);

        $this->dbName = $this->db->config()['database'];

        parent::initialize($config);
    }

    public function getDbcName()
    {
        return $this->dbcName;
    }

    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * データベース名一覧を取得
     *
     */
    public function getDatabases()
    {
        $sql = "SHOW DATABASES";
        $rows = $this->db->execute($sql)->fetchAll('assoc');

        return $rows;
    }

    /**
     * 指定データベースに含まれるテーブルの情報を取得
     */
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
        $result['columns_head'] = $this->getHeader($rows, 'Privileges');

        $sql = "SHOW INDEX FROM {$tableName}";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['index'] = $rows;
        $result['index_head'] = $this->getHeader($rows);

        $sql = "SHOW TABLE STATUS WHERE Name='{$tableName}'";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['status'] = $rows;
        $result['status_head'] = $this->getHeader($rows);

        $sql = "SHOW CREATE TABLE {$tableName}";
        $rows = $this->db->execute($sql)->fetchAll('assoc');
        $result['create'] = $rows;

        return $result;
    }

    /**
     * テーブル情報表のheaderを取得する
     *
     * @param array table info
     * @param string ignore header name scv
     */
    public function getHeader($rows, string $ignores = '')
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
