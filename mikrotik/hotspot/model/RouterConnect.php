<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/20/2017
 * Time: 2:22 PM
 */

namespace hotspot\model;
use hotspot\controller\Config;
use PEAR2\Net\RouterOS;
require_once __DIR__.'/../../../vendor/PEAR2_Net_RouterOS-1.0.0b6.phar';

class RouterConnect
{
    private $_util;
    private $_client;
    private $_username;
    private $_secret;
    private $_customer;
    private $_users;

    private static $_connect = null;

    private function __construct()
    {
        try
        {
            $this->_client = new RouterOS\Client(Config::getConfig('mikrotik/host'), Config::getConfig('mikrotik/user'),
                Config::getConfig('mikrotik/password'));
        }catch (RouterOS\RouterErrorException $exception)
        {
            die($exception->getMessage());
        }

        $this->_util = new RouterOS\Util($this->_client);

        return $this;
    }

    public static function getRouter()
    {
        if (!isset(self::$_connect)) {
            self::$_connect = new  self();
        }

        return self::$_connect;

    }

    public function createUser($username, $password, $customer, $users)
    {
        $this->_username = $username;
        $this->_secret = $password;
        $this->_customer = $customer;
        $this->_users = $users;


        try
        {
            $this->_util->setMenu('/tool user-manager user')->add([
                'username' => $this->_username,
                'password' => $this->_secret,
                'customer' => $this->_customer,
                'shared-users' => $this->_users
            ]);
        }catch (RouterOS\RouterErrorException $exception)
        {
            die($exception->getMessage());
        }catch (RouterOS\DataFlowException $exception)
        {
            die($exception->getMessage());
        }catch (RouterOS\InvalidArgumentException $exception)
        {
            die($exception->getMessage());
        }catch (RouterOS\ParserException $exception)
        {
            die($exception->getMessage());
        }
        return $this->_util;
    }

    public function activateUser()
    {
        return $this->_util->enable($this->_username);
    }

    public function getClient()
    {
        return $this->_client;
    }
}