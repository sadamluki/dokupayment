<?php
require_once('../Doku_Library/Doku.php');

Doku_Initiate::$sharedKey = 'AiM3Rw8L50kp';
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
    'name' => $_POST['doku_invoice_no'],
    'amount' => $_POST['doku_amount'],
    'quantity' => '1',
    'subtotal' => $_POST['doku_amount']
    );


$customer = array(
    'name' => 'Rafik',
    'data_phone' => '087805586273',
    'data_email' => 'rafik@gmail.com',
    'data_address' => 'Denpasar Bali'
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
        'req_payment_channel' => '15',
        //'req_payment_channel' => $_POST['doku_payment_channel'],
        'req_basket' => $basket,
        'req_email' => $customer['data_email'],
        'req_token_id' => $_POST['doku_token'],
        'req_mobile_phone' => $customer['data_phone'],
        'req_address' => $customer['data_address']

    );

        // $dataPayment = json_decode(json_encode($dataPayment));
        //echo "<pre>"; print_r($dataPayment); die;

    $responsePayment = Doku_Api::doPayment($dataPayment);
    //print_r($responsePayment);

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
//        $responsePayment->res_redirect_url = '../example-payment/merchant-redirect-example.php';
        $responsePayment->res_redirect_url = '../payment/?TRANSIDMERCHANT='.$responsePayment->res_response_msg;
        $responsePayment->res_show_doku_page = true; //true if you want to show doku page first before redirecting to redirect url

        //example : Response doku to merchant
        //MIPPayment.processRequest ACKNOWLEDGE : {"res_approval_code":"245391","res_trans_id_merchant":"invoice_1461728094","res_amount":"50000.00","res_payment_date_time":"20160427003515","res_verify_score":"-1","res_verify_id":"","res_verify_status":"NA","res_words":"00a22b8d81a731d948605b682578d6a9074de5c47498312cd13abd0ef2f80e7a","res_response_msg":"SUCCESS","res_mcn":"5***********8754","res_mid":"094345145394964","res_bank":"Bank BNI","res_response_code":"0000","res_session_id":"b249a07ff9c5251dddc87997d482836ea3b8affd","res_payment_channel":"15"}

        echo json_encode($responsePayment);

    }else{

        //echo json_encode($responsePayment);

    }

//}else{
    //prepayment fail
//  echo json_encode($responsePrePayment);
//}
?>
