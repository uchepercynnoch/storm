<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/21/2017
 * Time: 9:18 AM
 */

namespace hotspot\controller;


class Input
{
    public static function exist($type = 'post')
    {
        switch ($type)
        {
            case 'post':
                return (!empty($_POST))? true : false;
                break;
            case 'get':
                return (!empty($_GET))? true : false;
                break;

            default:
                return false;
                break;
        }
    }

    public static function getType($value)
    {
        if(isset($_POST[$value]))
        {
            echo $_POST[$value];
        }elseif (isset($_GET[$value]))
        {
            echo $_GET[$value];
        }
        return '';
    }
}