<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午4:22
 */

namespace common\helpers;


class Util
{
    /**
     * 解析url 格式: route[空格,回车]a=1&b=2
     * @param $url
     * @return array
     */
    public static function parseUrl($url)
    {
        if (strpos($url, '//') !== false) {
            return $url;
        }
        // 空格换行都行
        $url = preg_split('/[ \r\n]+/', $url);
        if (isset($url[1])) {
            $tmp = $url[1];
            unset($url[1]);
            $tmpParams = explode('&', $tmp);
            $params = [];
            foreach ($tmpParams as $tmpParam) {
                list($key, $value) = explode('=', $tmpParam);
                $params[$key] = $value;
            }
            $url = array_merge($url, $params);
        }
        return $url;
    }

    public static function createSlug($string)
    {
       return  preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    }

    public static function filterString($string)
    {
        $str =  preg_replace("/[^A-Za-z0-9-]+/"," ",strtolower($string));

        return trim($str);

    }
    public static function parseImageInfo($path)
    {
        $array = getimagesize($path);
        $info = [];
        if(isset($array) && is_array($array)){
            if(isset($array[0]))$info['width'] = $array[0];
            if(isset($array[1]))$info['height'] = $array[1];
          //  if(isset($array['bits']))$info['bit'] = $array['bits'];
         //   if(isset($array['channels']))$info['channels'] = $array['channels'];
            //if(isset($array['mime']))$info['mime'] = $array['mime'];

        }
        return $info;
    }

    public static function getTimezoneItems()
    {
        $timeZones = [];
        $timeZonesOutput = [];
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (\DateTimeZone::listIdentifiers(\DateTimeZone::ALL) as $timeZone) {
            $now->setTimezone(new \DateTimeZone($timeZone));
            $timeZones[] = [$now->format('P'), $timeZone];
        }


        array_multisort($timeZones);

        foreach ($timeZones as $timeZone) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) use ($timeZone) {
                switch ($matches[0]) {
                    case '{name}':
                        return $timeZone[1];
                    case '{offset}':
                        return $timeZone[0];
                    default:
                        return $matches[0];
                }
            }, '{name}   ({offset})');
            $timeZonesOutput[$timeZone[1]] = $content;
        }

        return $timeZonesOutput;

    }

    public static function getIP(){
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else{
            $cip = "";
        }
        return $cip;
    }

    public static function  getUserAgent()
    {
        if (isset($_GET['ua']) && trim($_GET['ua'])) {
            $ua = $_GET['ua'];
        }else {
            $ua = $_SERVER['HTTP_USER_AGENT'];
            // This line detects the visiting device by looking at its HTTP Request ($_SERVER)
        }
        return $ua;
    }


}