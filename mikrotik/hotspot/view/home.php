<?php
/**
* Created by PhpStorm.
* User: uchepercynnoch
* Date: 8/18/2017
* Time: 11:14 AM
*/

require_once __DIR__.'/../config/session.php';
require_once __DIR__.'/../includes/bootstrap.php';

use hotspot\controller\User;
use hotspot\model\RouterConnect;
use hotspot\config\mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$auth_user = new User();


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../../assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
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

                    <h2 class="text-center">CHOOSE YOUR PLAN</h2>

                    <!-- Modal1 -->
                    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">WELCOME TO STORM COOL</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="../config/payment_config.php" method="post" id="form1">
                                        <input type="hidden" class="form-control" name="shared-users" id="shared-users" value="3">
                                        <input type="hidden" class="form-control" name="customer" id="customer" value="admin">
                                        <input type="hidden" class="form-control" name="profile" id="profile" value="STORM10G">
                                        <button type="submit" name="submit1" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal2 -->
                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">WELCOME TO STORM COOL</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" id="form1">
                                        <input type="hidden" class="form-control" name="shared-users" id="shared-users" value="3" placeholder="Password">
                                        <input type="hidden" class="form-control" name="customer" id="customer" value="admin">
                                        <button type="submit" name="submit2" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal3 -->
                    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">WELCOME TO STORM COOL</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" id="form1">
                                        <input type="hidden" class="form-control" name="shared-users" id="shared-users" value="3" placeholder="Password">
                                        <input type="hidden" class="form-control" name="customer" id="customer" value="admin">
                                        <button type="submit" name="submit3" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal4 -->
                    <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">WELCOME TO STORM COOL</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" id="form1">
                                        <input type="hidden" class="form-control" name="shared-users" id="shared-users" value="3" placeholder="Password">
                                        <input type="hidden" class="form-control" name="customer" id="customer" value="admin">
                                        <button type="submit" name="submit4" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="masonry-grid grid4">
                        <div class="grid-sizer"></div>
                        <div class="gutter-sizer"></div>
                        <!-- Item -->
                        <div class="item">
                            <div class="grid-tile milo">

                                <div href="#" class="post-thumb" data-toggle="modal" data-target="#myModal1">
                                    <div class="color-overlay"></div>
                                    <img src="../../assets/images/1.jpg" alt="" >

                                    <span class="figcaption">
                                        <h2>STORM <span>COOL</span></h2>
                                        <p>Click To Buy</p>
                                        <div class="fig-links">

                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="item">
                            <div class="grid-tile milo">

                                <div href="#" class="post-thumb" data-toggle="modal" data-target="#myModal2">
                                    <div class="color-overlay"></div>
                                    <img src="../../assets/images/2.jpg" alt="">

                                    <span class="figcaption">
                                        <h2>STORM <span>ENTERPRISE</span></h2>
                                        <p>Click To Buy</p>
                                        <div class="fig-links">

                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="item">
                            <div class="grid-tile milo">

                                <div href="#" class="post-thumb" data-toggle="modal" data-target="#myModal3">
                                    <div class="color-overlay"></div>
                                    <img src="../../assets/images/3.jpg" alt="">

                                    <span class="figcaption">
                                        <h2>STORM <span>SCHOOL</span></h2>
                                        <p>Click To Buy</p>
                                        <div class="fig-links">

                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="item">
                            <div class="grid-tile milo">

                                <div href="#" class="post-thumb" data-toggle="modal" data-target="#myModal4">
                                    <div class="color-overlay"></div>
                                    <img src="../../assets/images/4.jpg" alt="">

                                    <span class="figcaption">
                                        <h2>STORM <span>HOME</span></h2>
                                        <p>Click To Buy</p>
                                        <div class="fig-links">

                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <script type="text/javascript" src="../../assets/js/jquery-1.11.3-jquery.min.js"></script>
            <script type="text/javascript" src="../../assets/bootstrap/js/bootstrap.min.js"></script>

        </body>
        </html>