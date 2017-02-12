<?php

/**
* Cek Ongkir, Kota/Kab, Provinsi
*/
class RajaOngkir
{
	protected $api_key,
		  $minify = true;

	/**
	 *
	 * Initiate class with passing api key
	 * @param string
	 *
	 */
	function __construct($api_key, $minify)
	{
		$this->api_key = $api_key;
		if($minify == false) {

			$this->minify = false;

		}
	}

	/**
	 *
	 * Curl setting, this controll all curl in the class
	 * @param string
	 * @return JSON
	 *
	 */
	private function get($setting = false, $url, $request)
	{
		// initiate curl with url
		$curl = curl_init($url);

		$headers = [
			"key: ".$this->api_key
		];

		// set of curl
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request);

		// if user fill custom set for curl
		if ($setting !== false) {

			curl_setopt_array($curl, $setting);

		}

		// result
		$response = curl_exec($curl);
		$err = curl_error($curl);

		// close curl
		curl_close($curl);

		// select return value
		if ($err) {

			$data['status'] = false;
			$data['message'] = $err;
			return $data;

		} else {

			return $response;

		}
	}

	/**
	 *
	 * Minify JSON data and validate if the curl is success and return the data
	 * @param JSON
	 * @return JSON
	 *
	 */
	private function minifyJson($data)
	{
		if(json_decode($data)->rajaongkir->status->code == 400) {
			return $data;
		} else {
			if($this->minify == true) {

				$result = json_encode(json_decode($data)->rajaongkir->results);

			} else {

				$result = $data;

			}
		}

		return $result;
	}

	/**
	 *
	 * Get all provinces and single province if the id is not null
	 * @param int
	 * @return JSON
	 *
	 */
	public function getProvince($id = false)
	{
		// if id is null
		if($id == false) {

			$response = $this->get(false, "http://api.rajaongkir.com/starter/province", "GET");

		} else {

			$response = $this->get(false, "http://api.rajaongkir.com/starter/province?id=".$id, "GET");

		}

		return $this->minifyJson($response);
	}

	/**
	 *
	 * Get all cities and single city if the id and province_id is not null
	 * @param int
	 * @return JSON
	 *
	 */
	public function getCity($id = false, $province_id = false)
	{
		// if not null
		if ($id == false && $province_id == false) {

			$data = $this->get(false, "http://api.rajaongkir.com/starter/city", "GET");
			$response = $this->minifyJson($data);

		} else {

			$data = $this->get(false, "http://api.rajaongkir.com/starter/city?id=".$id."&province=".$province_id, "GET");
			$response = $this->minifyJson($data);

		}

		return $response;
	}

	/**
	 *
	 * Get cost from all courier
	 * @param ['from'=>string, 'to'=>string, 'weight'=>int, 'courier'=>string]
	 * @return JSON
	 *
	 */
	public function getCost($from, $to, $weight, $courier)
	{
		// set minify to false
		$this->minify = false;

		// add custom postfields
		$curl_set = [
			CURLOPT_POSTFIELDS => "origin=501&destination=114&weight=1700&courier=jne",
		];

		$data = $this->get($curl_set, "http://api.rajaongkir.com/starter/cost", "POST");
		$response = $this->minifyJson($data);

		// reset minify to true
		$this->minify = true;

		return $response;
	}
}
