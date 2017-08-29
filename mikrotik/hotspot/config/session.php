<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/18/2017
 * Time: 11:16 AM
 */

session_start();
use hotspot\controller\User;
require_once __DIR__.'/../includes/bootstrap.php';


$session = new User();

// if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
// put this file within secured pages that users (users can't access without login)

if(!$session->is_loggedin())
{
    // session no set redirects to login page
    $session->redirect('../../../index.php');
}