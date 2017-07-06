<?php

namespace common\helpers;
use backend\models\Redirect;
use backend\models\Cloak;


class RedirectUtil
{

    /**
     * hit test result build
     * @param $hit_flag
     * @param $id
     * @param $name
     * @return array
     */
    public static function resultBuild($hit_flag,$id,$name,$hit_url)
    {
        return [$hit_flag,$id,$name,$hit_url];
    }

    /**
     * Cloak hit test
     * opt == and !=
     * id =1
     * type include iparea/ip/useragent
     * @param $click $rd
     * @return array
     */
    public static function cloakHitTest($click,$rd){
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        $cloak = Cloak::findOne(['id'=>$rd->type]);

        if($cloak) {
            switch ($cloak->type) {
                case 1://iparea
                {
                    $rule = $cloak->rule;
                    $hit_flag = false;
                    $rules = explode("\n", $rule);
                    foreach ($rules as $r) {
                        $iparea = explode("-", $r);
                        if (is_array($iparea) && count($iparea) == 2) {
                            $fip = ip2long($iparea[0]);
                            $tip = ip2long($iparea[1]);
                            if ($fip <= $click->IPINT && $tip >= $click->IPINT) {
                                if($opt == 1){// in area hit success
                                    return RedirectUtil::resultBuild(true,1,$rd->type,$rd->redirectUrl);
                                }
                                $hit_flag = true;
                                break;
                            }
                        }

                    }
                    if($opt == 2 && $hit_flag == false) //not in all area,hit sucess
                    {
                        return RedirectUtil::resultBuild(true,1,$rd->type,$rd->redirectUrl);
                    }

                    break;
                }
                case 2://ip
                {
                    $rule = $cloak->rule;
                    $hit_flag = false;
                    $rules = explode("\n", $rule);
                    foreach ($rules as $r) {

                        $cip = ip2long($r);
                        if ($cip == $click->IPINT) {
                            if($opt == 1){ //in area hit success
                                return RedirectUtil::resultBuild(true,1,$rd->type,$rd->redirectUrl);
                            }
                            $hit_flag = true;
                            break;
                        }

                    }
                    if($opt == 2 && $hit_flag == false){
                        return RedirectUtil::resultBuild(true,1,$rd->type,$rd->redirectUrl);
                    }
                    break;
                }
                case 3://ua
                {
                    $rule = $cloak->rule;
                    $hit_flag = false;

                    $rules = explode("\n", $rule);
                    foreach ($rules as $r) {
                        if (strpos($click->userAgent, $r) !== FALSE) {
                            if($opt == 1){ //in area hit success
                                return RedirectUtil::resultBuild(true,1,$rd->type,$rd->redirectUrl);
                            }
                            $hit_flag = true;
                            break;
                        }
                    }
                    if($opt == 2 && $hit_flag == false){
                        return RedirectUtil::resultBuild(true,1,$rd->type,$rd->redirectUrl);
                    }
                    break;
                }
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * carrier hit test
     * opt == or !=
     * * id =2
     * @param $click
     * @param $rd
     * @return array
     */
    public static function carrierHitTest($click,$rd)
    {
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if($click->countryCode == $rd->type && $click->carrierName == $rd->subtype){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,2,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,2,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * id =3
     * opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function browserHitTest($click,$rd){
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if($click->browser == $rd->type ){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,3,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,3,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * id =4
     * opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function ispHitTest($click,$rd)
    {
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if($click->countryCode == $rd->type && $click->isp == $rd->subtype){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,4,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,4,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * * id =5
     * opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function countryHitTest($click,$rd)
    {
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if($click->countryCode == $rd->type ){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,5,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,5,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * id=6
     *  opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function osHitTest($click,$rd)
    {
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if($click->deviceOS == $rd->type ){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,6,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,6,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * id =7
     *  opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function brandHitTest($click,$rd)
    {
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if($click->brandName == $rd->type ){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,7,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,7,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * id=8
     *  opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function deviceHitTest($click,$rd)
    {
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if($click->deviceType == $rd->type ){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,8,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,8,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * id=9
     *  opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function refererHitTest($click,$rd)
    {
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if(strpos($click->referer, $rd->type) !== FALSE ){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,9,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,9,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    /**
     * id=10
     *  opt == and !=
     * @param $click
     * @param $rd
     * @return array
     */
    public static function userAgentHitTest($click,$rd){
        $opt = $rd->opt; // 1=>'==' or 2=>'!='
        if(strpos($click->userAgent, $rd->type) !== FALSE ){
            if($opt == 1) // == hit success
            {
                return RedirectUtil::resultBuild(true,10,$rd->type,$rd->redirectUrl);
            }
        }else{
            if($opt == 2) // != hit success
            {
                return RedirectUtil::resultBuild(true,10,$rd->type,$rd->redirectUrl);
            }
        }
        return RedirectUtil::resultBuild(false,0,"","");
    }

    public static function processHitTest($click,$rd)
    {
        switch($rd->redirectType) {
            case 1://1=>'Cloak', == or !=
            {
                return RedirectUtil::cloakHitTest($click,$rd);
                break;
            }
            case 2://2=>'Carrier',
            {
                return RedirectUtil::carrierHitTest($click,$rd);
                break;
            }
            case 3://3=>'Browser',
            {
                return RedirectUtil::browserHitTest($click,$rd);
                break;
            }
            case 4://4=>'ISP',
            {
                return RedirectUtil::ispHitTest($click,$rd);
                break;
            }
            case 5://5=>'Country',
            {
                return RedirectUtil::countryHitTest($click,$rd);
                break;
            }
            case 6://6=>'OS',
            {
                return RedirectUtil::osHitTest($click,$rd);
                break;
            }
            case 7://7=>'Brand',
            {
                return RedirectUtil::brandHitTest($click,$rd);
                break;
            }
            case 8://8=>'DeviceType',
            {
                return RedirectUtil::deviceHitTest($click,$rd);
                break;
            }
            case 9://9=>'RefererDomain',
            {
                return RedirectUtil::refererHitTest($click,$rd);
                break;
            }
            case 10://10=>'UserAgent',
            {
                return RedirectUtil::userAgentHitTest($click,$rd);
                break;
            }
        }
    }
}

