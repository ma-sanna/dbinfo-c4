<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 syntax=php: */
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\InternalErrorException;

use App\Model\Db;

/**
 * get database info.
 *
 * @auther ikeda.ver2@gmail.com
 */
class DbController extends AppController
{
    use CommonTrait {}

    /**
     * 指定のデータベースに含まれるテーブルの情報
     *
     */
    public function tables()
    {
        $model = new Db();
        // default のDB名を取得
        $defaultDbName = $model->getDbName();

        // POSTから
        $dbName = $this->request->getData('dbname') ?? '';
        // GETから
        if (empty($dbName)) {
            $dbName = $this->request->getQuery('dbname') ?? '';
        }
        // 指定無しはデフォルト
        if (empty($dbName)) {
            $dbName = $defaultDbName;
        }

        // DB の SELECTを準備
        $dblist = $model->getDatabases();

        // 含まれるテーブルの情報を取得
        $info = $model->getTableStatus($dbName);

        $this->set('dbs', $dblist);
        $this->set('dbcName', $model->getDbcName());
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

        $model = new Db();
        $info = $model->getTableInfo($tableName, $dbName);

        $this->set('dbName', $dbName);
        $this->set('tableName', $tableName);
        $this->set('info', $info);
    }

}
