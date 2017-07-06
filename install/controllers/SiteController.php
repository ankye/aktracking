<?php
/**
 * Created by PhpStorm.
 * User: ankye
 * Date: 2017/6/28
 * Time: 10:41
 */

namespace install\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use install\models\DatabaseForm;
use install\models\SiteForm;
use install\models\AdminForm;
use common\models\User;

class SiteController extends Controller
{

    public $migrationPath = '@base/common/migrations/db';
    public $migrationRbacPath = '@base/common/migrations/rbac';
    public $migrationTable = '{{%system_db_migration}}';
    public $migrationRbacTable= '{{%system_rbac_migration}}';

    public $envPath = '@base/.env';



    public $executablePaths = [
        '@backend/yii',
        '@frontend/yii',
        '@console/yii',
    ];

    public function init()
    {
        parent::init();
        $this->migrationPath = Yii::getAlias($this->migrationPath);
        $this->migrationRbacPath = Yii::getAlias($this->migrationRbacPath);

    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'set-locale'=>[
                'class'=>'common\actions\SetLocaleAction',
                'locales'=>array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSuccess()
    {
        //安装完成
        Yii::$app->setInstalled();

        return $this->render('success');
    }

    public function actionRequirement()
    {
        $items = [
            ['dir',  'R/W', 'success', '@common/runtime'],
            ['dir',  'R/W', 'success', '@backend/runtime'],
            ['dir',  'R/W', 'success', '@frontend/runtime'],
            ['dir',  'R/W', 'success', '@base/web/storage/'],
            ['dir',  'R/W', 'success', '@base/web/storage/cache'],
            ['dir',  'R/W', 'success', '@base/web/storage/upload'],
            ['dir',  'R/W', 'success', '@base/web/assets'],
            ['dir',  'R/W', 'success', '@base/web/admin/assets'],
            ['dir',  'R/W', 'success', '@base/web/storage/wurfl'],

        ];
        $result = true;
        $msg = "";
        foreach ($items as &$val) {
            $val[3] =	Yii::getAlias($val[3]);
            if('dir' == $val[0]){
                if(!is_writable($val[3])) {
                    if(is_dir($val[3])) {
                        $val[1] = 'R';
                        $val[2] = 'error';
                    } else {
                        $val[1] = 'Not Found';
                        $val[2] = 'error';
                    }
                    $result = false;
                }
            } else {
                if(file_exists($val[3])) {
                    if(!is_writable($val[3])) {
                        $val[1] = 'R';
                        $val[2] = 'error';
                        $result = false;
                    }
                } else {
                    if(!is_writable(dirname($val[3]))) {
                        $val[1] = 'Not Found';
                        $val[2] = 'error';
                        $result = false;
                    }
                }
            }
        }
        if (Yii::$app->request->isPost) {
            if ($result == true) {
                $this->go("/install.php?r=site/db");
            }else {
                $msg = \Yii::t("install",'Please ensure that the directories and files have permissions');
            }
        }
        return $this->render('requirement', [
            "items" => $items,
            'msg'=>$msg,
        ]);


    }
    public function go($location)
    {
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: $location");
    }

    public function installConfig()
    {
        \Yii::$app->setKeys($this->envPath);


        return true;
    }

    public function actionDb()
    {
        $model = new DatabaseForm();

        $model->loadDefaultValues();
        $msg = "";
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate() && $model->save()) {

                $this->go("/install.php?r=site/site");
            } else {
                $msg = current($model->getFirstErrors());
            }
        }

        return $this->render('db', [
            "model" => $model,
            'msg'=>$msg
        ]);
    }
    public function actionSite()
    {
        $model = new SiteForm();

        $model->loadDefaultValues();
        $msg = "";
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate() && $model->save()) {
                $this->go("/install.php?r=site/admin");
            } else {
                $msg = current($model->getFirstErrors());
            }
        }

        return $this->render('site', [
            "model" => $model,
            'msg'=>$msg,
        ]);
    }
    public function actionAdmin()
    {
        $model = new AdminForm();

        $model->loadDefaultValues();
        $msg = "";
        if ($model->load(Yii::$app->request->post())) {

            if (!$model->validate() || !$model->save()) {
                $msg = current($model->getFirstErrors());
            }else {
                $this->installConfig();
                $error = $this->installDb($this->migrationPath,$this->migrationTable);
                $error = $this->installDb($this->migrationRbacPath,$this->migrationRbacTable);
                if ($error != null) {
                    $msg = $error;
                }else{
                    // 创建用户
                    $this->createAdminUser();
//                    $error = $this->createAdminUser();
//                    if ($error != null) {
//                        $msg = error;
//                    }else{
                    //清缓存
                    \Yii::$app->getCache()->flush();


                        $this->go("/install.php?r=site/success");
                    //}
                }
            }

        }

        return $this->render('admin', [
            "model" => $model,
            'msg'=>$msg,
        ]);
    }


    public function createAdminUser()
    {
        $data = \Yii::$app->getCache()->get(AdminForm::CACHE_KEY);
        $user = User::findOne(['id'=>1]);
        $user->email = $data["email"];
        $user->username = $data["username"];
        $user->password = $data["password"];
        $user->save(false);

    }

    /**
     * 安装数据库
     */
    public function installDb($migrationPath,$migrationTable)
    {
        $handle = opendir($migrationPath);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $migrationPath . DIRECTORY_SEPARATOR . $file;
            if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && !isset($applied[$matches[2]]) && is_file($path)) {
                $migrations[] = $matches[1];
            }
        }
        closedir($handle);
        sort($migrations);

        $error = "";

        ob_start();
        if (Yii::$app->db->schema->getTableSchema($migrationTable, true) === null) {
            $this->createMigrationHistoryTable($migrationTable);
        }
        foreach ($migrations as $migration) {
            $migrationClass = $this->createMigration($migrationPath,$migration);
            try {
                if ($migrationClass->up() === false) {
                    $error = "migrate failed";
                }
                $this->addMigrationHistory($migrationTable,$migration);
            } catch (\Exception $e) {
                $error = "db table already exist,please check it！";
            }
        }
        ob_end_clean();

        if (! empty($error)) {
            return $error;
        }
        return null;
    }

    protected function createMigrationHistoryTable($migrationTable)
    {
        Yii::$app->db->createCommand()->createTable($migrationTable, [
            'version' => 'varchar(180) NOT NULL PRIMARY KEY',
            'apply_time' => 'integer',
        ])->execute();
        Yii::$app->db->createCommand()->insert($migrationTable, [
            'version' => 'm000000_000000_base',
            'apply_time' => time(),
        ])->execute();
    }

    protected function createMigration($migrationPath,$class)
    {
        $file = $migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        require_once($file);

        return new $class();
    }

    protected function addMigrationHistory($migrationTable,$version)
    {
        $command = Yii::$app->db->createCommand();
        $command->insert($migrationTable, [
            'version' => $version,
            'apply_time' => time(),
        ])->execute();
    }
}
