<?php
class api_raja_ongkir{
	
	private $api_key;
	private $url_service;
	public function __construct()
	{
		$this->api_key="62bc28588db9fe2da2380a84010c107b";
		$this->url_service="http://api.rajaongkir.com/starter";
	}


	/**
	fungsi curl untuk ambil data secara web service
	@param string $id

	*/
	public function get_province($id='')
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->url_service."/province?id=".$id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"key: ".$this->api_key,
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  $response_service=$err;
		} else {
		  $response_service=$response;
		}

		return $response_service;
	}

	public function get_city($id='',$province='')
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->url_service."/city?id=".$id.'&province='.$province,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"key: ".$this->api_key,
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  $response_service=$err;
		} else {
		  $response_service=$response;
		}

		return $response_service;
	}

	function get_cost($origin_id,$destination_id,$total_weight,$courier='jne')
	{
		  $curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $this->url_service."/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=".$origin_id."&destination=".$destination_id."&weight=".$total_weight."&courier=".$courier,
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: ".$this->api_key
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  $response_service=$err;
		} else {
		  $response_service=$response;
		}

		return $response_service;

	}
}
?>