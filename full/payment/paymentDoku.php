<?php
require_once('../Doku_Library/Doku.php');

date_default_timezone_set('Asia/Jakarta');

Doku_Initiate::$sharedKey = 'DRFCrfw5n216';
Doku_Initiate::$mallId = $_POST['mall_id'];

$params = array(
    'amount' => $_POST['amount'],
    'invoice' => $_POST['trans_id'],
    'currency' => $_POST['currency']
);

$words = Doku_Library::doCreateWords($params);

$customer = array(
    'name' => 'Rafik Testing',
    'data_phone' => '087805586273',
    'data_email' => 'rafik@doku.com',
    'data_address' => 'bojong gede #1 08/01'
);

$dataPayment = array(
    'req_mall_id' => $_POST['mall_id'],
    'req_chain_merchant' => $_POST['chain_merchant'],
    'req_amount' => $params['amount'],
    'req_words' => $words,
    'req_trans_id_merchant' => $_POST['trans_id'],
    'req_purchase_amount' => $params['amount'],
    'req_request_date_time' => date('YmdHis'),
    'req_session_id' => sha1(date('YmdHis')),
    'req_email' => $customer['data_email'],
    'req_name' => $customer['name'],
    'req_expiry_time' => '360'
);

$response = Doku_Api::doGeneratePaycode($dataPayment);

if($response->res_response_code == '0000'){
    echo 'GENERATE SUCCESS -- ';
}else{
    echo 'GENERATE FAILED -- ';
}

var_dump($response);

?>
