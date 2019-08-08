<?php
namespace ZFlex\Framework;

use Zend\Http\Client;

class Gamebank extends Framework
{
	public function isCurl()
	{
		return function_exists('curl_version');
	}

	public function CardCharging($seri,$pin,$card_type,$note = '')
	{
		// Config
		$config = $this->getServiceLocator()->get('config');
		$merchant_id = $config['merchant_id'];
		$api_user = $config['api_user'];
		$api_password = $config['api_password'];
		
		if ($this->isCurl()) {
		$fields = array(
			'merchant_id' => $merchant_id,
			'pin' => $pin,
			'seri' => $seri,
			'card_type' => $card_type,
			'note' => $note
		);
		$ch = curl_init("https://sv.gamebank.vn/api/card");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_USERPWD, $api_user . ":" . $api_password);
		$result = curl_exec($ch);
		$result = json_decode($result);

		$return = array(
			'code' => $result->code,
			'msg' => $result->msg,
			'info_card' => $result->info_card,
			'transaction_id' => $result->transaction_id
		);
		
		} 
		/*else {
			//Trường hợp máy chủ chưa bật cURL
			$result =  file_get_contents("http://sv.gamebank.vn/api/card2?merchant_id=".$merchant_id."&api_user=".trim($api_user)."&api_password=".trim($api_password)."&pin=".trim($pin)."&seri=".trim($seri)."&card_type=".intval($card_type)."&note=".urlencode($note)."");   
			$result = str_replace("\xEF\xBB\xBF",'',$result); 
			$result = json_decode($result);
			$return = array(
				'code' => $result->code,
				'msg' => $result->msg,
				'info_card' => $result->info_card,
				'transaction_id' => $result->transaction_id
			);
		}*/
		return $return;
	}
}