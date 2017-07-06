<?php
namespace install\models;

use yii\base\Model;
use Yii;


class SiteForm extends Model
{
    

    public $SITE_URL = 'http://';

    const CACHE_KEY = "install-site-form";
    
    public function rules()
    {
        return [
            [['SITE_URL',], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'SITE_URL' => Yii::t('install','Site URL'),
        ];
    }
    
    public function  loadDefaultValues()
    {
        $data = \Yii::$app->getCache()->get(SiteForm::CACHE_KEY);
        if($data) {
            $this->setAttributes($data);
        }
    }

    public function save()
    {
        Yii::$app->setEnv('FRONTEND_HOST_INFO', $this->SITE_URL);
        Yii::$app->setEnv('BACKEND_HOST_INFO', $this->SITE_URL);
        Yii::$app->setEnv('STORAGE_HOST_INFO', $this->SITE_URL);

       \Yii::$app->getCache()->set(SiteForm::CACHE_KEY, $this->toArray());
        return true;
    }
}