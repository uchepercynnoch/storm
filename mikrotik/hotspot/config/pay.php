<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 9/5/2017
 * Time: 10:36 AM
 */
require __DIR__.'/start_pay.php';
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use hotspot\model\RouterConnect;

if (isset($_GET['approved']))
{
    $input1 = [];
    $input2 = [];
    $input3 = [];
    $data = [];

    $approved = $_GET['approved'] = true;
    $not_approved = $_GET['approved'] = false;
    if ($approved)
    {
//Get ID from URL
        $pay_id_url = $_GET['PayerID'];

//Get ID from database table
        $pay_id = $auth_user->runQuery('SELECT pay_id FROM paypal WHERE hash = :hash');
        $pay_id->execute([
            ':hash' => $_SESSION['paypal_hash']
        ]);

        $payer_id = $pay_id->fetchObject()->pay_id;

        $payment = Payment::get($payer_id,$API); //get information about payer
        $execute_payment = new PaymentExecution(); //charge payer based on ID from URL
        $execute_payment->setPayerId($pay_id_url);

        $payment->execute($execute_payment,$API); //execute payment

        $updatepaypal = $auth_user->runQuery('UPDATE paypal SET complete = 1 WHERE pay_id = :uid');
        $updatepaypal->execute([
            ':uid' => $payer_id
        ]);

        $updateuser = $auth_user->runQuery('UPDATE users SET pay_complete = 1 WHERE user_id = :userid');
        $updateuser->execute([
            ':userid' => $_SESSION['user_id']
        ]);

        header('Location: success.php?paid');
//        unset($_SESSION['paypal_hash']);
    }else if($not_approved)
    {
        header('Location: cancelled.php?');

    }
}