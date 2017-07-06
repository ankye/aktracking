<?php
namespace install\models;

use yii\base\Model;
use Yii;
use yii\db\Connection;
use yii\db\Exception;
use common\helpers\Dsn;

class DatabaseForm extends Model
{
    

    public $username;

    public $password;

    public $database = 'aktracking';

    public $hostname = "127.0.0.1";

    public $port = "3306";
    
    public $prefix = "ak_";

    public function rules()
    {
        return [
            [['hostname', 'username', 'database', "hostname", "port"], 'required'],
            [['hostname'], 'checkDb'],
            [['password', "prefix"], 'safe']
        ];
    }
    
    
    public function checkDb($attribute, $params)
    {
        $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->database.";port=".$this->port;
        // Create Test DB Connection
        Yii::$app->set('newDb', [
            'class' => Connection::className(),
            'dsn' => $dsn,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => 'utf8'
        ]);

        try {
         
            Yii::$app->get("newDb")->open();
            
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 1049:
                    $this->addError("database", $e->getMessage());
                    break;
                case 1045:
                    $this->addError("password", $e->getMessage());
                    break;
                case 2002:
                    $this->addError("hostname", $e->getMessage());
                    break;
                default:
                    $this->addError("hostname", $e->getMessage());
                    break;
            }
        }
    }

    public function loadDefaultValues()
    {
        $definitions = \Yii::$app->getComponents();
        
        if(isset($definitions["db"])&&isset($definitions["db"]['dsn']))
        {
            $dsn = Dsn::parse($definitions["db"]['dsn']);
            $this->hostname = $dsn->host;
            $this->database = $dsn->database;
            $this->port = $dsn->port;
            $this->username = $definitions["db"]['username'];
            $this->password = $definitions["db"]['password'];
            $this->prefix =  $definitions["db"]['tablePrefix'];
        }
    }
    
    public function attributeLabels()
    {
        return [
            'hostname' => \Yii::t('install','DB Host'),
            'username' => \Yii::t('install','DB User'),
            'password' => \Yii::t('install','DB Password'),
            'database' => \Yii::t('install','DB Name'),
            "port" => \Yii::t('install',"DB Port"),
            "prefix" => \Yii::t('install',"DB Prefix")
        ];
    }

    public function save()
    {
        Yii::$app->setEnv('DB_USERNAME', $this->username);
        Yii::$app->setEnv('DB_PASSWORD', $this->password);
        Yii::$app->setEnv('DB_TABLE_PREFIX', $this->prefix);
        Yii::$app->setEnv('DB_DSN', "mysql:host=$this->hostname;dbname=$this->database;port=$this->port");
        Yii::$app->set('db', Yii::createObject([
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=$this->hostname;dbname=$this->database;port=$this->port",
            'username' => $this->username,
            'password' => $this->password,
            'charset' => 'utf8',
            "tablePrefix" => $this->prefix
        ])
        );
        return true;
    }
}