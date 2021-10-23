<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Db;

/**
 * Db Controller
 *
 * @method \App\Model\Entity\Db[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
        $ret = $model->getDatabases();
        $dblist = $ret;
        $this->set('dbs', $dblist);

        // 含まれるテーブルの情報を取得
        $ret = $model->getTableStatus($dbName);
        $info = $ret;

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
        $ret = $model->getTableInfo($tableName, $dbName);
        if ($ret === false) {
            // TODO Exception を扱う方法を考える
        }
        $info = $ret;

        $this->set('dbName', $dbName);
        $this->set('tableName', $tableName);
        $this->set('info', $info);
    }

}
