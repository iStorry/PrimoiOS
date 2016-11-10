<?php
class Primo

{
	protected $auth = "Basic aW50bF91c2VyOjdlZmM3WGVkMDQr";
	protected $rand = "https://api.randomuser.me/?nat=en";
	protected
	function randuser()
	{
		return json_decode(file_get_contents($this->rand));
	}

	protected $char = ['1', '2', '3', '4', '5', '6', '7', '0'];
	protected $varchar = ['C', 'F', 'E', 'A', 'B', 'D'];
	protected $uuid = "C52F3E74-40F5-48A4-B0C6-DE827ED535A0";
	protected
	function useragent()
	{
		$ios = rand(9, 10) . "." . rand(1, 2);
		$iPhone = "iPhone" . rand(8, 9) . "," . rand(1, 3);
		return "Primo|1.0.12 (45.6.1)|" . $this->uuid() . "|" . $ios . "|" . $iPhone . "|iOS";
	}

	/*
	*
	* function deprecated using @func uuid();
	protected function gen(&$s){
	global $a;
	$len=strlen($s);
	for($i=0;$i<$len;$i++)
	{
	if($s[$i]=='-')
	continue;
	if($s[$i]>='0' && $s[$i]<='9')
	$s[$i]=rand(1,9);
	else if($s[$i]>='A' && $s[$i]<='Z')
	$s[$i]=$a[rand(0,25)];
	}
	}

	*/
	protected
	function uuid()
	{
		$result = str_replace($this->char[rand(1, count($this->char)) ], rand(1, 9) , $this->uuid);
		$varchar = substr(str_shuffle(str_repeat("QWERTYUIOPASDFGHJKLZXCVBNM", 1)) , 0, 1);
		return str_replace($this->varchar[rand(1, count($this->varchar)) ], $varchar, $result);
	}

	protected
	function header($post)
	{
		$arr = array();
		$arr[] = "Host: api.primo.me";
		$arr[] = "Content-Type: application/x-www-form-urlencoded";
		$arr[] = "Accept-Encoding: gzip, deflate";
		$arr[] = "Connection: keep-alive";
		$arr[] = "Accept: application/json";
		$arr[] = "User-Agent: " . $this->useragent();
		$arr[] = "Authorization: " . $this->auth;
		$arr[] = "Content-Length: " . strlen($post);
		$arr[] = "Accept-Language: en-us";
		return $arr;
	}

	protected $uri = "https://api.primo.me/pr/manageintl/3/primo/api/manageintl__CreatePinlessAccount";
	public

	function signup()
	{
		$post = "password=" . urlencode($this->randuser()->results[0]->login->password) . "1on&preferred_language=EN&last_name=" . $this->randuser()->results[0]->name->last . "&username=" . $this->randuser()->results[0]->login->username . "&signup_source=APP&tos_accepted=1&first_name=" . $this->randuser()->results[0]->name->first;
		$header = $this->header($post);
		$result = $this->execute($this->uri, $post, $header);
		print_r($result);
		if ($result->success == 1) {
			return $this->randuser()->results[0]->login->username . ":" . $this->randuser()->results[0]->login->password . "11on";
		}
		else {
			echo $result->user_errors[0];
		}
	}

	public

	function execute($url, $post, $customHeaders)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeaders);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent());
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$server_output = json_decode(curl_exec($ch));
		return $server_output;
	}
}
