<?php
/**
 * Doku's Global Function
 */
class Doku_Library {

	public static function doCreateWords($data){

		if(!empty($data['device_id'])){

			if(!empty($data['pairing_code'])){

				return sha1($data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency'] . $data['token'] . $data['pairing_code'] . $data['device_id']);

			}else{

				return sha1($data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency'] . $data['device_id']);

			}

		}else if(!empty($data['pairing_code'])){

			return sha1($data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency'] . $data['token'] . $data['pairing_code']);

		}else if(!empty($data['currency'])){

			return sha1($data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency']);

		}else{

			return sha1($data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice']);

		}
	}

	public static function doCreateWordsRaw($data){

		if(!empty($data['device_id'])){

			if(!empty($data['pairing_code'])){

				return $data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency'] . $data['token'] . $data['pairing_code'] . $data['device_id'];

			}else{

				return $data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency'] . $data['device_id'];

			}

		}else if(!empty($data['pairing_code'])){

			return $data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency'] . $data['token'] . $data['pairing_code'];

		}else if(!empty($data['currency'])){

			return $data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'] . $data['currency'];

		}else{

			return $data['amount'] . Doku_Initiate::$mallId . Doku_Initiate::$sharedKey . $data['invoice'];

		}
	}

	public static function formatBasket($data){

		if(is_array($data)){
			foreach($data as $basket){
				$parseBasket = $parseBasket . $basket['name'] .','. $basket['amount'] .','. $basket['quantity'] .','. $basket['subtotal'] .';';
			}
		}else if(is_object($data)){
			foreach($data as $basket){
				$parseBasket = $parseBasket . $basket->name .','. $basket->amount .','. $basket->quantity .','. $basket->subtotal .';';
			}
		}

		return $parseBasket;
	}

}
