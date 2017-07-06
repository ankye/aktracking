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

class GeoipDetect extends Object
{
    protected $basePath;
    protected $giArray;

    //init funcion
    public function init()
    {
        parent::init();

        $this->basePath = dirname(Yii::$app->basePath)."/common/components/devicedelect/geoip";

        $this->giArray = [];

    }

    /**
     * get gi handler
     * @param $name  Country,City,ISP,ORG
     * @param bool $v4
     * @return \GeoIP|mixed
     */
    protected function giHandler($name,$v4 = true){
        if($v4) {
            $key = $name;
        }else{
            $key = $name."v6";
        }
        $gi = isset($this->giArray[$key])?$this->giArray[$key]:null;
        if($gi == null){
            $dat = $this->basePath."/GeoIP".$key.".dat";
            if(is_file($dat)){
                $gi = geoip_open($this->basePath."/GeoIP".$key.".dat",GEOIP_STANDARD);
                $this->giArray[$key] = $gi;
            }

        }
        return $gi;

    }


    /**
     * get Country Name
     * @param $ip
     * @return country name or ""
     */
    public function getCountryName($ip)
    {


        if($this->isIPV6($ip)){
            $gi = $this->giHandler("Country",false);
            return geoip_country_name_by_addr_v6($gi,$ip);

        }else{
            $gi = $this->giHandler("Country",true);
            return geoip_country_name_by_addr($gi,$ip);

        }
    }

    /**
     * get Geoip ISP
     * @param $ip
     * @return string ISP or ""
     */
    public function getISP($ip)
    {
        if($this->isIPV6($ip)){
            $gi = $this->giHandler("ISP",true);
            return geoip_name_by_addr_v6($gi,$ip);
        }else{
            $gi = $this->giHandler("ISP",true);
            return geoip_name_by_addr($gi,$ip);
        }
    }

    /**
     * get Geoip City Info
     * @param $ip
     * @return City Object
     *
     * object(geoiprecord)
     * public 'country_code' => string 'US' (length=2)
     * public 'country_code3' => string 'USA' (length=3)
     * public 'country_name' => string 'United States' (length=13)
     * public 'region' => string 'NY' (length=2)
     * public 'city' => string 'Deer Park' (length=9)
     * public 'postal_code' => string '11729' (length=5)
     * public 'latitude' => float 40.7627
     * public 'longitude' => float -73.3227
     * public 'area_code' => int 631
     * public 'dma_code' => float 501
     * public 'metro_code' => float 501
     * public 'continent_code' => string 'NA' (length=2)
     */
    public function getCity($ip){
        if($this->isIPV6($ip)){
            $gi = $this->giHandler("City",false);
            return  geoip_record_by_addr_v6($gi, $ip);
        }else{
            $gi = $this->giHandler("City",true);
            return  geoip_record_by_addr($gi, $ip);
        }
    }


    /**
     * get Coungry Code
     * @param $ip
     * @return country code or ""
     */
    public function getCountryCode($ip)
    {

        if($this->isIPV6($ip)){
            $gi = $this->giHandler("Country",false);
            return geoip_country_code_by_addr_v6($gi,$ip);
        }else{
            $gi = $this->giHandler("Country",true);
            return geoip_country_code_by_addr($gi,$ip);
        }

    }

    /**
     * valid ip v6
     * @param $ip
     * @return bool
     */
    public function isIPV6($ip)
    {

        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
            return true;
        }
        return false;
    }

    public function  __destruct()
    {

        foreach($this->giArray as $gi){
            if($gi != null){
                geoip_close($gi);
            }
        }
        $this->giArray = [];


    }


}