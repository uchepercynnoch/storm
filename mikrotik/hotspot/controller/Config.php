<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/21/2017
 * Time: 8:59 AM
 */

namespace hotspot\controller;
require_once __DIR__.'/../config/init.php';

class Config
{
    public static function getConfig($path =null)
    {
        if ($path)
        {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            foreach($path as $value)
            {
                if(isset($config[$value]))
                {
                    $config = $config[$value];
                }
            }
            return $config;
        }

        return self::getConfig();
    }
}