<?php
require_once('../core/Doku.php');

//Doku_Initiate::$sharedKey = 'k8UhY5t4RF4e';
Doku_Initiate::$sharedKey = 'W7TYxdOp81y2';
Doku_Initiate::$mallId = $_POST['mallid'];
$amount=$_POST['amount'];
$invoice=$_POST['invoice'];
$mallid=$_POST['mallid'];
$chain=$_POST['chain'];


$params = array(
    'amount' => $amount,
    'invoice' => $invoice,
    'currency' => '360'
);

$cc = str_replace(" - ", "", $_POST['cc_number']);
$words = Doku_Library::doCreateWords($params);

$customer = array(
    'name' => 'TEST NAME',
    'data_phone' => '08121111111',
    'data_email' => 'test@test.com',
    'data_address' => 'bojong gede #1 08/01'
);

$basket[] = array(
    'name' => 'sayur',
    'amount' => $amount,
    'quantity' => '1',
    'subtotal' => $amount
);

$dataPayment = array(
    'req_mall_id' => $mallid,
    'req_chain_merchant' => $chain,
    'req_amount' => $params['amount'],
    'req_words' => $words,
    'req_purchase_amount' => $params['amount'],
    'req_trans_id_merchant' => $_POST['invoice'],
    'req_request_date_time' => date('YmdHis'),
    'req_currency' => '360',
    'req_purchase_currency' => '360',
    'req_session_id' => sha1(date('YmdHis')),
    'req_name' => $customer['name'],
    'req_payment_channel' => '02',
    'req_email' => $customer['data_email'],
    'req_card_number' => $cc,
    'req_basket' => $basket,
    'req_challenge_code_1' => $_POST['CHALLENGE_CODE_1'],
    'req_challenge_code_2' => $_POST['CHALLENGE_CODE_2'],
    'req_challenge_code_3' => $_POST['CHALLENGE_CODE_3'],
    'req_response_token' => $_POST['response_token'],
    'req_mobile_phone' => $customer['data_phone'],
    'req_address' => $customer['data_address']
);

$response = Doku_Api::doDirectPayment($dataPayment);


if($response->res_response_code == '0000'){
    echo 'PAYMENT SUCCESS -- ';
}else{
    echo 'PAYMENT FAILED -- ';
}
// MIPPayment.processRequest ACKNOWLEDGE : {"res_response_msg":"SUCCESS","res_transaction_code":"20c7d99c75ce6418af4aae7bc3f27df8009800ed","res_mcn":"4***********1111","res_approval_code":"2949000000","res_trans_id_merchant":"inline_1461811342","res_payment_date":"20160428164236","res_bank":"Mandiri Click Pay","res_amount":"50000.00","res_message":"PAYMENT APPROVED","res_response_code":"0000","res_session_id":"b4502a7fd29c07026d7a535ed3971fdbc121d53c"}
var_dump($response);


?>