<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/18/2017
 * Time: 11:15 AM
 */

session_start();
use hotspot\controller\User;
use hotspot\controller\Input;
require_once __DIR__.'/../includes/bootstrap.php';

$user = new User();

if($user->is_loggedin()!="")
{
    $user->redirect('home.php');
}

if(isset($_POST['btn-signup']))
{
    $uname = strip_tags($_POST['txt_uname']);
    $umail = strip_tags($_POST['txt_umail']);
    $uphone = strip_tags($_POST['phone']);
    $upass = strip_tags($_POST['txt_upass']);

    if($uname=="")	{
        $error[] = "provide username !";
    }
    else if($umail=="")	{
        $error[] = "provide email id !";
    }else if($uphone=="")
    {
        $error[] = "Provide phone number !";
    }else if(strlen($uphone) > 13)
    {
        $error[] = "Phone number must not be greater than 13 digits";
    }
    else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
        $error[] = 'Please enter a valid email address !';
    }
    else if($upass=="")	{
        $error[] = "provide password !";
    }
    else if(strlen($upass) < 6){
        $error[] = "Password must be at least 6 characters";
    }
    else
    {
        try
        {
            $stmt = $user->runQuery("SELECT user_name, user_email, user_phone FROM users WHERE user_name=:uname OR user_email=:umail OR user_phone=:uphone");
            $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail, ':uphone'=>$uphone));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            if($row['user_name']==$uname) {
                $error[] = "sorry username already taken !";
            }
            else if($row['user_email']==$umail) {
                $error[] = "sorry email id already taken !";
            }else if($row['user_phone']==$uphone)
            {
                $error[] = "Sorry phone number already exits";
            }
            else
            {
                if($user->register($uname,$umail,$uphone,$upass)){
                    $user->redirect('register.php?joined');
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mikrotik Hotspot : Sign up</title>
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../../assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="../../assets/css/style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

    <div class="container">

        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Sign up.</h2><hr />
            <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                    ?>
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                    </div>
                    <?php
                }
            }
            else if(isset($_GET['joined']))
            {
                ?>
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='../../../index.php'>login</a> here
                </div>
                <?php
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $umail;}?>" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone" placeholder="Your Phone Number" value="<?= Input::getType('phone')?>" />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="btn-signup">
                    <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ! <a href="../../../index.php">Sign In</a></label>
        </form>
    </div>
</div>

</div>

</body>
</html>