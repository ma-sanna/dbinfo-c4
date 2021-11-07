<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 syntax=php: */
declare(strict_types=1);

namespace App\Controller;

use App\Model\Db;

/**
 * get database info.
 *
 * @auther ikeda.ver2@gmail.com
 */
class DbController extends AppController
{
    use CommonTrait {}

    public function initialize(): void
    {
        $this->loadComponent('DbInfo');
        parent::initialize();
    }

    /**
     * 指定のデータベースに含まれるテーブルの情報
     *
     * @param string $dbName 表示対象データベース名
     */
    public function tables()
    {
        // default のDB名を取得
        $defaultDbName = $this->DbInfo->getDbName();

        // URLパラメータから
        $dbName = $this->request->getParam('dbName');
        // POSTから
        if (empty($dbName)) {
            $dbName = $this->request->getData('dbname') ?? '';
        }
        // GETから
        if (empty($dbName)) {
            $dbName = $this->request->getQuery('dbname') ?? '';
        }
        // 指定無しはデフォルト
        if (empty($dbName)) {
            $dbName = $defaultDbName;
        }

        // DB の SELECTを準備
        $dblist = $this->DbInfo->getDatabases();

        // 含まれるテーブルの情報を取得
        $info = $this->DbInfo->getTableStatus($dbName);

        $this->set('dbs', $dblist);
        $this->set('dbcName', $this->DbInfo->getDbcName());
        $this->set('dbName', $dbName);
        $this->set('info', $info);
    }

    /**
     * テーブルの詳細情報を取得
     *
     * @param string tableName
     * @param string dbName
     * @auther ikeda.ver2@gmail.com
     */
    public function table()
    {
        // from routes.php setting
        $tableName = $this->request->getParam('tableName');
        $dbName = $this->request->getParam('dbName');

        $info = $this->DbInfo->getTableInfo($tableName, $dbName);

        $this->set('dbName', $dbName);
        $this->set('tableName', $tableName);
        $this->set('info', $info);
    }

}
