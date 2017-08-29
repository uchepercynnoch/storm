<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/18/2017
 * Time: 11:15 AM
 */


require_once __DIR__.'/../config/session.php';
require_once __DIR__.'/../includes/bootstrap.php';
use hotspot\controller\User;
use hotspot\model\Database;
use hotspot\model\RouterConnect;

$auth_user = new User();


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

$user_name = $user_pass = $user_owner = $user_shared = "";




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../../assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="../../assets/js/jquery-1.11.3-jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/style.css" type="text/css"  />
    <title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">STORM HOTSPOT</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Choose Plan</a></li>
                <li><a href="http://#">LOREM</a></li>
                <li><a href="http://#">LOREM</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
                        <li><a href="../config/logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>


<div class="clearfix"></div>


<div class="container-fluid" style="margin-top:80px;">

    <div class="container">

        <label class="h5">welcome : <?php print($userRow['user_name']); ?></label>
        <hr />

        <h1>
            <a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp;
            <a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h1>
        <hr />

        <p class="h4">User Home Page</p>




    </div>

</div>

<script src="../../assets/bootstrap/js/bootstrap.min.js"></script>

</body>