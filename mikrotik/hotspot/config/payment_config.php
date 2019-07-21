<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 9/5/2017
 * Time: 10:26 AM
 */
require 'start_pay.php';

use hotspot\model\Database;
use hotspot\controller\User;
use PayPal\Api\Payer;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Exception\PayPalConnectionException;
use hotspot\model\RouterConnect;
use hotspot\config\mail;


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));

$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
$id = $userRow['user_id'];
$input1 =
$input2 =
$input3 =
$data = [];
$query = $auth_user->runQuery("SELECT * FROM users WHERE user_id=$id");
$query->execute();
$result = $query->setFetchMode(PDO::FETCH_ASSOC);
foreach ($query->fetchAll() as $key => $value) {
    foreach ($value as $item) {
        $data[] = $item;
    }
}

$h_uname = $data[1];
$h_upass = $data[2];

$h_uname_len = strlen($h_uname);
$rand_num = mt_rand(10, 100);
$sum_h_uname = $h_uname . mt_rand(87, 2745);
$shuffle_uname = str_shuffle($sum_h_uname);
$new_h_uname = substr($shuffle_uname, 0, 10);

$n_h_upass = password_hash($h_upass, PASSWORD_DEFAULT);
$n_h_upass_len = strlen($n_h_upass);
$shuffle_upass = str_shuffle($n_h_upass);
$new_h_upass = substr($shuffle_upass, 0, 10);

if (isset($_POST['submit1'])) {
    $user_shared = $_POST['shared-users'];
    $user_owner = $_POST['customer'];
    $profile = $_POST['profile'];
    $user_name = $new_h_uname;
    $user_pass = $new_h_upass;
    $userid = $id;

    if (!empty($user_shared) && !empty($user_shared) && !empty($user_name) && !empty($user_pass)) {
        $new = new User();
        $new->registerUser($id, $user_name, $user_pass, $user_owner, $user_shared, $profile);

        if (!$new->error()) {
            $hotspot = RouterConnect::getRouter()->createUser($user_name, $user_pass, $user_owner, $user_shared);

            if ($hotspot == true) {
                $enable = RouterConnect::getRouter()->enableUser($user_name);

                $user = $new->runQuery("SELECT user_name, user_owner,user_profile FROM hotspot
                                            WHERE user_name = :username AND user_owner = :userowner AND user_profile = :userprofile");
                $user->execute([":username" => $user_name,
                    ":userowner" => $user_owner,
                    ":userprofile" => $profile]);
                $user_row = $user->fetchAll(PDO::FETCH_OBJ);
                if ($user_row == true) {
                    foreach ($user_row as $value) {
                        $input1[] = $value->user_name;
                        $input2[] = $value->user_owner;
                        $input3[] = $value->user_profile;
                    }
                }

                $data1 = $input1[0];
                $data2 = $input2[0];
                $data3 = $input3[0];

                $activate = RouterConnect::getRouter();
                $activate->activateUser($data1, $data2, $data3);

                $payer = new Payer();
                $details = new Details();
                $amount = new Amount();
                $transaction = new Transaction();
                $payment = new Payment();
                $redirectUrl = new RedirectUrls();

                $payer->setPaymentMethod('paypal');

                $details->setShipping('2.00')
                    ->setTax('0.00')
                    ->setSubtotal('20.00');

                $amount->setCurrency('USD')
                    ->setTotal('22.00')
                    ->setDetails($details);

                $transaction->setAmount($amount)
                    ->setDescription('Subscription');

                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions([$transaction]);

                $redirectUrl->setReturnUrl('http://localhost/storm.dev/mikrotik/hotspot/config/pay.php?approved=true')
                    ->setCancelUrl('http://localhost/storm.dev/mikrotik/hotspot/config/pay.php?approved=false');

                $payment->setRedirectUrls($redirectUrl);

                try {
                    $payment->create($API);

                    //get User id on return from paypal
                    $pay_id = $payment->getId();
                    $hash = md5($pay_id);
                    $_SESSION['paypal_hash'] = $hash;

                    //Store User in database

                    $store = $new->runQuery('INSERT INTO paypal (user_id, pay_id, hash, complete) VALUES (:userid, :payid, :hash,0)');
                    $store->bindParam(':userid', $_SESSION['user_id']);
                    $store->bindParam(':payid', $pay_id);
                    $store->bindParam(':hash', $hash);

                    $store->execute();

                } catch (PayPalConnectionException $exception) {
                    header('Location: ../paypal/error.php');
                    echo $exception->getCode();
                    echo $exception->getData();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                foreach ($payment->getLinks() as $link) {
                    if ($link->getRel() == 'approval_url') {
                        $redirect = $link->getHref();
                    }
                }

                header("Location: $redirect");


            }
        }
    }
}



