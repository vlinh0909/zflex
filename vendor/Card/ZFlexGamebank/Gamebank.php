<?php
namespace ZFlexGamebank;

use Zend\Http\Client;

class Gamebank 
{
	function _isCurl()
	{
		return function_exists('curl_version');
	}

	public static function CardCharging($seri,$pin,$card_type,$note,$merchant_id,$api_user,$api_password)
	{
		// $serviceLocator = \Factory\ServiceLocatorFactory::getServiceLocator();
		// $config = $serviceLocator->get('config');
		if (_isCurl()) {
		$fields = array(
			'merchant_id' => $merchant_id,
			'pin' => $pin,
			'seri' => $seri,
			'card_type' => $card_type,
			'note' => $note
		);
		$curl_config = array(
		    'adapter'   => 'Zend\Http\Client\Adapter\Curl',
		    'curloptions' => array(CURLOPT_POST => 1,CURLOPT_POSTFIELDS => $fields,CURLOPT_RETURNTRANSFER => 1,CURLOPT_HTTPAUTH => CURLAUTH_DIGEST , CURLOPT_TIMEOUT => 120 , CURLOPT_USERPWD => $api_user . ":" . $api_password),
		);
		$ch = new Client("https://sv.gamebank.vn/api/card", $curl_config);
		// $ch = curl_init("https://sv.gamebank.vn/api/card");
		// curl_setopt($ch, CURLOPT_POST, 1);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		// curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		// curl_setopt($ch, CURLOPT_USERPWD, $api_user . ":" . $api_password);
		$result = curl_exec($ch);
		$result = json_decode($result);

		$return = array(
			'code' => $result->code,
			'msg' => $result->msg,
			'info_card' => $result->info_card,
			'transaction_id' => $result->transaction_id,
		);
		
		} else {
			//Trường hợp máy chủ chưa bật cURL
			$result =  file_get_contents("http://sv.gamebank.vn/api/card2?merchant_id=".$merchant_id."&api_user=".trim($api_user)."&api_password=".trim($api_password)."&pin=".trim($pin)."&seri=".trim($seri)."&card_type=".intval($card_type)."&note=".urlencode($note)."");   
			$result = str_replace("\xEF\xBB\xBF",'',$result); 
			$result = json_decode($result);
			$return = array(
				'code' => $result->code,
				'msg' => $result->msg,
				'info_card' => $result->info_card,
				'transaction_id' => $result->transaction_id,
			);
		}
		
		if($return['code'] === 0 && $return['info_card'] >= 10000) {
		    $result_json = json_encode(array('code' => 0, 'msg' => "Nạp thẻ thành công mệnh giá " .  $return['info_card']));
		}
		else {
		    // get thong bao loi
		    $result_json = json_encode(array('code' => 1, 'msg' => $return['msg']));
		}
		return $result_json;
	}
}