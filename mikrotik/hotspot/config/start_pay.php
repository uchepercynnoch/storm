<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 9/5/2017
 * Time: 9:56 AM
 */

require_once __DIR__.'/../config/session.php';
require_once __DIR__.'/../includes/bootstrap.php';

use hotspot\controller\User;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
$user_id = $_SESSION['user_session'];
$auth_user = new User();
$stmt = $auth_user->runQuery("SELECT * FROM users");
$stmt->execute();
$result = $stmt->fetchObject();
$result->user_id;
$_SESSION['user_id'] = $result->user_id;

$API = new ApiContext(new OAuthTokenCredential(
    'AdRmkCki7GShEq0F6DL-jmYfGLPEqZJiyLBke-MlzJ4L6kQn721659nigt15o-Os59H3r21BraPu2YgG',
    'ENRqTkRvIEwrORn1DXO0WjbxSX-44i-0wDGHClCtm6_cPAzzH317b_cDv_YbpvAZUQlDhKeW_Tne1aX6'
));

$API->setConfig([
    'mode' => 'sandbox',
    'http.ConnectionTimeOut' => 30,
    'log.LogEnabled' => false,
    'log.FileName' => '',
    'log.LogLevel' => 'FINE',
    'validation.level' => 'log'
]);