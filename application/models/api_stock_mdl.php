<?php

class Api_stock_mdl extends CI_Model {

	function login($url,$data) {
		$fp = fopen("cookie.txt", "w");
		fclose($fp);
		$login = curl_init();
		curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
		curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
		curl_setopt($login, CURLOPT_TIMEOUT, 4000);
		curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($login, CURLOPT_URL, $url);
		curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($login, CURLOPT_FOLLOWACTION, TRUE);
		curl_setopt($login, CURLOPT_POST, TRUE);
		curl_setopt($login, CURLOPT_POSTFIELDS, $data);
		ob_start();
		return curl_exec($login);
		ob_end_clean();
		curl_close($login);
		unset($login);
	}

	function grab_page($site) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4000);
		curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
		curl_setopt($ch, CURLOPT_URL, $site);
		ob_start();
		return curl_exec($ch);
		ob_end_clean();		

		$response = curl_exec($ch);
		$err = curl_error($ch);
		
		curl_close($ch);

		if ($err) {
		  $response_service=$err;
		} else {
		  $response_service=$response;
		}

		return $response_service;

	}

	function post_data($site,$data) {
		$datappost = curl_init();
		$header = array("expect:");
		curl_setopt($datapost, CURLOPT_URL, $site);
		curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
		curl_setopt($datapost, CURLOPT_HEADER, TRUE);
		curl_setopt($datapost, CURLOPT_HTTPHEADER, $header);
		curl_setopt($datapost, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($datapost, CURLOPT_POST, TRUE);
		curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
		curl_setopt($datapost, CURLOPT_COOKIEFILE, "cookie.txt");
		ob_start();
		return curl_exec($datapost);
		ob_end_clean();
		curl_close($datapost);
		unset($datapost);
	}


	function getstock($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$grab=curl_exec($ch);
		$err = curl_error($ch);

		if ($err) {
		  $grab=$err;
		} else {
		  $grab=$response;
		}

		return $grab;
	}


}

// Get API Stock from CURL
// $brand_url = $this->db->query('SELECT * FROM brand WHERE brand_id="'.$data['view']->brand_id.'" LIMIT 1')->row();
// $brand_api = $brand_url->brand_api;
// $kode_api = str_replace(" ", "%20", $data['view']->product_code);
// $url = trim($this->scr->grab_page('www.bandros.id/stok_api/'.$brand_api.'.php?kode='.$kode_api));
// $json = $url;
// $data['json'] = json_decode($json);


?>