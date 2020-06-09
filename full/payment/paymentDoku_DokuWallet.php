<?php
require_once('../core/Doku.php');

Doku_Initiate::$sharedKey = 'W7TYxdOp81y2';
//Doku_Initiate::$sharedKey = 'k8UhY5t4RF4e';
Doku_Initiate::$mallId = $_POST['doku_mall_id'];
//Doku_Initiate::$payment_channel = $_POST['payment_channel'];

$params = array(
    'amount' => $_POST['doku_amount'],
    'invoice' => $_POST['doku_invoice_no'],
    'currency' => $_POST['doku_currency'],
    'pairing_code' => $_POST['doku_pairing_code'],
    'token' => $_POST['doku_token']
    );

$words = Doku_Library::doCreateWords($params);

$basket[] = array(
    'name' => $params['invoice'],
    'amount' => $params['amount'],
    'quantity' => '1',
    'subtotal' => $params['amount']
    );

$customer = array(
    'name' => 'TEST NAME',
    'data_phone' => '08121111111',
    'data_email' => 'test@test.com',
    'data_address' => 'bojong gede #1 08/01'
    );

$data = array(
    'req_token_id' => $_POST['doku_token'],
    'req_pairing_code' => $_POST['doku_pairing_code'],
//    'req_bin_filter' => array("411111", "548117", "433???6", "41*3"),
    'req_customer' => $customer,
    'req_basket' => $basket,
    'req_words' => $words
);

//$responsePrePayment = Doku_Api::doPrePayment($data);

//if($responsePrePayment->res_response_code == '0000'){ //prepayment success

    $dataPayment = array(
        'req_mall_id' => $_POST['doku_mall_id'],
        'req_chain_merchant' => $_POST['doku_chain_merchant'],
        'req_amount' => $_POST['doku_amount'],
        'req_words' => $words,
        'req_words_raw' => Doku_Library::doCreateWordsRaw($params),
        'req_purchase_amount' => $_POST['doku_amount'],
        'req_trans_id_merchant' => $_POST['doku_invoice_no'],
        'req_request_date_time' => date('YmdHis'),
        'req_currency' => $_POST['doku_currency'],
        'req_purchase_currency' => $_POST['doku_currency'],
        'req_session_id' => sha1(date('YmdHis')),
        'req_name' => $customer['name'],
        'req_payment_channel' => '04',
        //'req_payment_channel' => $_POST['doku_payment_channel'],
        'req_basket' => $basket,
        'req_email' => $customer['data_email'],
        'req_token_id' => $_POST['doku_token'],
        'req_mobile_phone' => $customer['data_phone'],
        'req_address' => $customer['data_address']

    );

    $responsePayment = Doku_Api::doPayment($dataPayment);

    if($responsePayment->res_response_code == '0000'){

        //merchant process
        //do what you want to do

        //process tokenization
        if(isset($responsePayment->res_bundle_token)) {
            $tokenPayment = json_decode($responsePayment->res_bundle_token);

            if ($tokenPayment->res_token_code == '0000') {
                //save token
                $getTokenPayment = $tokenPayment->res_token_payment;
            }
        }

        //redirect process to doku
        $responsePayment->res_redirect_url = '../payment/?TRANSIDMERCHANT='.$responsePayment->res_response_msg;
        $responsePayment->res_show_doku_page = true; //true if you want to show doku page first before redirecting to redirect url
        //MIPPayment.processRequest ACKNOWLEDGE : {"res_tracking_id":29204,"res_dp_mall_id":1336,"res_response_msg":"Berhasil","res_approval_code":"253961","res_trans_id_merchant":"invoice_1461748645","res_payment_channel_code":"01","res_status":"Success","res_bank":"CASH","res_response_code":"0000","res_payment_channel":"04"}


        echo json_encode($responsePayment);

    }else{

        echo json_encode($responsePayment);

    }

//}else{
    //prepayment fail
//  echo json_encode($responsePrePayment);
//}
?>
