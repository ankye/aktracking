<?php

namespace common\helpers;


use backend\models\Cloak;
use backend\models\Carrier;
use backend\models\Country;
use backend\models\OS;
use backend\models\Browser;
use backend\models\Isp;
use backend\models\Org;
use backend\models\Brand;
use backend\models\DeviceModel;
use backend\models\Devicetype;
use backend\models\RefererDomain;
use backend\models\Useragent;
use backend\models\Resolution;
use backend\models\ScreenSize;


class Common {

    public static function deviceType()
    {
        $type = [
            1=> 'Desktop',
            2=> 'Mobile',
            3=> 'Tablet',
            4=> 'Robot'
        ];

        return $type;
    }


    public static function networkType()
    {
        $type = [
            'Hasoffers',
            'Cakes',
            'Custom'
        ];

        return array_combine($type, $type);
    }


    public static function costType()
    {
        $type = [
           1=> 'CPC',
           2=> 'CPM'
        ];

        return $type;
    }

    public static function activeType()
    {
        $type = [
            0=>"Active",
            1=>"Inactive",
        ];
        return $type;
    }

    public static function clockType()
    {
        $type = [
           1=> "IPAREA",
           2=> 'IP',
           3=> 'UA'
        ];
        return $type;
    }

    public static function optSingleType()
    {
        $type = [
            1=>"==",
            2=>"!="
        ];
        return $type;
    }
    public static function optType()
    {
        $type = [
            1=>"==",
            2=>"!=",
            3=>">=",
            4=>"<=",
        ];
        return $type;
    }
    public static function redirectType()
    {
        $type = [

            1=>'Cloak',
            2=>'Carrier',
            3=>'Browser',
            4=>'ISP',
            5=>'Country',
            6=>'OS',
            7=>'Brand',
            8=>'DeviceType',
            9=>'RefererDomain',
            10=>'UserAgent',
//            11=>'Resolution',
//            12=>'ScreenSize',
        ];
        return $type;
    }

    public static function groupAttributes()
    {
       $type = [
            'IP',
            'countryCode',
            'carrierName',
            'brandName',
            'modelName',
            'deviceOS',
            'osversion',
            'referer',
            'refererDomain',
            'browser',
            'screenResolution',
            'screenSize',
            'deviceType',
            'browserVersion',
            'userAgent',
            'isp',
            'pingbackIP',
            'c1',
            'c2',
            'c3',
            'c4',
            'c5',
            'c6',
            'c7',
            'c8',
            'c9',
            'c10',
            'c11',
            'c12',
            'c13',
            'c14',
            'c15',
            'c16'];
       return array_combine($type, $type);
    }

    public static function typeOptionsChoose($type){
        $options = [];
        switch($type){
            case 1:{ //Cloak
                $options = Cloak::dropDownItems();
            }
                break;
            case 2:{ //Carrier
                $options = Carrier::dropDownItems();

            }
                break;
            case 3:{ //Browser
                $options = Browser::dropDownItems();

            }
                break;
            case 4:{ ///ISP
                $options =Country::dropDownItems();

            }

                break;
            case 5:{ //Country
                $options = Country::dropDownItems();

            }
                break;
            case 6:{ //OS
                $options = OS::dropDownItems();
            }
                break;
            case 7:{ //Brand
                $options = Brand::dropDownItems();

            }
                break;

            case 8:{ //DeviceType
                $options = Devicetype::dropDownItems();

            }
                break;
            case 9:{ //RefererDomain
                $options = RefererDomain::dropDownItems();

            }
                break;
            case 10:{ //UserAgent
                $options = Useragent::dropDownItems();

            }
                break;
            case 11:{ //Resolution
                $options = Resolution::dropDownItems();

            }
                break;
            case 12:{ //ScreenSize
                $options = ScreenSize::dropDownItems();

            }
                break;
            default:
            {

            }
        }
        return $options;
    }

    public static function typeOptChoose($type){
        $opt = [];
        switch($type){
            case 1:{ //Cloak
                $opt = Common::optSingleType();
            }
                break;
            case 2:{ //Carrier
                $opt = Common::optSingleType();

            }
                break;
            case 3:{ //Browser
                $opt =Common::optSingleType();

            }
                break;
            case 4:{ ///ISP
                $opt = Common::optSingleType();

            }
                break;
            case 5:{ //Country
                $opt = Common::optSingleType();

            }
                break;
            case 6:{ //OS
                $opt = Common::optSingleType();
            }
                break;
            case 7:{ //Brand
                $opt = Common::optSingleType();

            }
                break;

            case 8:{ //DeviceType
                $opt = Common::optSingleType();

            }
                break;
            case 9:{ //RefererDomain
                $opt = Common::optSingleType();

            }
                break;
            case 10:{ //UserAgent
                $opt = Common::optSingleType();

            }
                break;
            case 11:{ //Resolution
                $opt = Common::optSingleType();

            }
                break;
            case 12:{ //ScreenSize
                $opt = Common::optSingleType();

            }
                break;
            default:
            {

            }
        }

        return $opt;
    }

    public static function subtypeChoose($mainType,$type){
        $options = [];
        switch($mainType){
            case 1:{ //Cloak

            }
                break;
            case 2:{ //Carrier
                $options = Carrier::dropDownSubItems($type);
            }
                break;
            case 3:{ //Browser

            }
                break;
            case 4:{ ///ISP

            }
                break;

            case 5:{ //Country
                $options = Carrier::dropDownSubItems($type);
            }
                break;
            case 6:{ //OS

            }
                break;
            case 7: { //Brand
                $options = DeviceModel::dropDownSubItems($type);
            }
                break;
            case 8:{ //DeviceType

            }
                break;
            case 9:{ //Referer

            }
                break;
            case 10:{ //UserAgent

            }
                break;
            case 11:{ //Resolution

            }
                break;
            case 12:{ //ScreenSize

            }
                break;
            default:
            {

            }
        }
        return $options;
    }
}