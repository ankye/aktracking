<?php
/**
 * Created by PhpStorm.
 * User: ankye
 * Date: 2017/6/7
 * Time: 14:35
 */


namespace common\components\devicedelect;

use Yii;
use yii\base\Object;

class MobileDetect extends Object
{


    //init funcion
    public function init()
    {
        parent::init();

    }


    function getMobile()
    {

        // Include the configuration file
        include(__DIR__.'/wurfl/inc/wurfl_config_standard.php');

        if (isset($_GET['ua']) && trim($_GET['ua'])) {
            $ua = $_GET['ua'];
            $requestingDevice = $wurflManager->getDeviceForUserAgent($_GET['ua']);
        } else {
            $ua = $_SERVER['HTTP_USER_AGENT'];
            // This line detects the visiting device by looking at its HTTP Request ($_SERVER)
            $requestingDevice = $wurflManager->getDeviceForHttpRequest($_SERVER);

        }


        $result["brand_name"] = $requestingDevice->getCapability("brand_name");
        $result["model_name"] = $requestingDevice->getCapability("model_name");
        $result["resolution"] = $requestingDevice->getCapability("resolution_width")."x".$requestingDevice->getCapability("resolution_height");

        $flag = $requestingDevice->getCapability("is_tablet");

        if($flag == "false"){

            $result["device_type"] = "Mobile";
        }else{
            $result["device_type"] = "Tablet";
        }
        $result["device_os"] = $requestingDevice->getCapability("device_os");
        $result["device_os_version"] = $requestingDevice->getCapability("device_os_version");
        $result["browser"] = $requestingDevice->getCapability("mobile_browser");
        $result["browser_version"] = $requestingDevice->getCapability("mobile_browser_version");
        $result["screen_size"] = $requestingDevice->getCapability("physical_screen_width")."x".$requestingDevice->getCapability("physical_screen_height");


        return $result;
    }


    public function  __destruct()
    {

    }


}