<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/18/2017
 * Time: 11:16 AM
 */
require_once __DIR__.'/../config/session.php';
require_once __DIR__.'/../includes/bootstrap.php';
use hotspot\controller\User;

$user_logout = new User();

if($user_logout->is_loggedin()!="")
{
    $user_logout->redirect('../view/home.php');
}
if(isset($_GET['logout']) && $_GET['logout']=="true")
{
    $user_logout->doLogout();
    $user_logout->redirect('../../../index.php');
}
