<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 14-Sep-17
 * Time: 11:26 AM
 */

use hotspot\model\RouterConnect;
use hotspot\controller\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__.'/../config/start_pay.php';

if (isset($_GET['paid']))
{
    $paid = $_GET['paid'] = true;

    if ($paid)
    {
        $auth_user = new User();

        $confirm = $auth_user->runQuery('SELECT id,user_id,complete FROM paypal WHERE hash = :hash');
        $confirm->execute([
            ':hash' => $_SESSION['paypal_hash']
        ]);

        $rows = $confirm->fetch(PDO::FETCH_ASSOC);
        $count = $confirm->rowCount();
        $pay_id = $rows['id'];
        $user_id = $rows['user_id'];
        $complete = $rows['complete'];

        if ($count == 1 && $complete == 1)
        {
            $gethotspot = $auth_user->runQuery('SELECT id,user_name,user_pass FROM hotspot WHERE id = :uid');
            $gethotspot->execute([':uid' => $pay_id]);
            $rows = $gethotspot->fetch(PDO::FETCH_ASSOC);
            $id = $rows['id'];
            $user = $rows['user_name'];
            $pass = $rows['user_pass'];

            if ($pay_id == $id)
            {
                $getmail = $auth_user->runQuery('SELECT user_name,user_email,user_phone FROM users WHERE user_id = :userid');
                $getmail->execute([':userid' => $user_id]);

                $mailrow = $getmail->fetch(PDO::FETCH_ASSOC);
                $username = $mailrow['user_name'];
                $email = $mailrow['user_email'];
                $phone = $mailrow['user_phone'];

                if (!empty($user) && !empty($pass) && !empty($username) && !empty($email) && !empty($phone))
                {
                    $mail = new PHPMailer(true);

                    //Server settings
                    $mail->isSMTP();                                      // Set mailer to use SMTP

                    $mail->Host = 'smtp.gmail.com';                         // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'uchennannochirionye@gmail.com';                          // SMTP username
                    $mail->Password = 'karateka22';                           // SMTP password
                    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                          // TCP port to connect to
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );

                    $mail->setFrom('from@example.com', 'Mailer');
                    $mail->addAddress($email);                                     // Add a recipient
                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = 'Test';
                    $mail->Body = '<p>Hello &nbsp;'. $username .' &nbsp;your login details are:</p>';
                    $mail->Body .= '<p>Username - '. $user .'</p>';
                    $mail->Body .= '<p>Password - '. $pass .'</p>';
                    $mail->Body .= '<p>Thank You.</p>';

                    if ($mail->send())
                    {
                        $dot = '.';
                        $semicomma = ',';
                        $comma = ':';
                        $s_uname = 'conyemaobi';
                        $s_pass = 830430;
                        $mobile = $phone;
                        $sender = 'Admin';
                        $message = 'Dear '.$username.', your username and password are:'.$user.'and'.$pass; 

                        $url = "http://sms-base.com/index.php?option=com_spc&comm=spc_api&username=$s_uname&password=$s_pass&sender=$sender&recipient=$mobile&message=Dear+{$username}+your+login+details+are{$comma}+{$user}+and+{pass}{$dot}+Thank+you.";

                        $ch = curl_init();
                        $timeout = 30;
                        curl_setopt($ch,CURLOPT_URL,$url);
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
                        $response = curl_exec($ch);
                        curl_close($ch);

                        echo $response;
                    }
                }
            }
        }
    }

}





?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../../assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="../../assets/js/jquery-1.11.3-jquery.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/style.css" type="text/css"  />

    <title>Document</title>
</head>
<body>

</body>
</html>
