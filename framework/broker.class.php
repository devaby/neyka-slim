<?php

namespace framework;


class broker {

protected $keyLive    = 'f107c4f1d9e0508800eeb9a21d3d858d';
protected $gdbLive    = 'bt';
protected $mt4Live 	  = 'LIVE 5';
protected $keyDemo    = '5708e604d7193b66a27ad865d5342cc9';
protected $gdbDemo    = 'bt';
protected $mt4Demo 	  = 'MT4 Demo 5';
protected $urlAccount = 'https://backoffice.bttprime.com/bt/web_services/mt4/account.php';
protected $urlGroup	  = 'https://backoffice.bttprime.com/bt/web_services/gdb/group.php';
protected $urlQuotes  = 'https://backoffice.bttprime.com/bt/web_services/qs4/quotes.php';
protected $qs4,$login,$name,$email,$phone,$address,$city,$state,$zip_code,$country,$password,$enabled,$group,$leverage,$balance,$response;
	
	public function setQs4($param) {
	$this->qs4 = $param;
	return $this;	
	}
	
	public function execute($param) {
	$this->$param();
	}
	
	public function setLogin($param) {
	$this->login = $param;
	return $this;	
	}
	
	public function setName($param) {
	$this->name = $param;
	return $this;	
	}
	
	public function setEmail($param) {
	$this->email = $param;
	return $this;
	}
	
	public function setPhone($param) {
	$this->phone = $param;
	return $this;
	}
	
	public function setAddress($param) {
	$this->address = $param;
	return $this;
	}
	
	public function setCity($param) {
	$this->city = $param;
	return $this;
	}
	
	public function setState($param) {
	$this->state = $param;
	return $this;
	}
	
	public function setZipcode($param) {
	$this->zip_code = $param;
	return $this;
	}
	
	public function setCountry($param) {
	$this->country = $param;
	return $this;
	}
	
	public function setPassword($param) {
	$this->password = $param;
	return $this;
	}
	
	public function setEnabled($param) {
	$this->enabled = $param;
	return $this;
	}
	
	public function setGroup($param) {
	$this->group = $param;
	return $this;
	}
	
	public function setLeverage($param) {
	$this->leverage = $param;
	return $this;
	}
	
	public function setBalance($param) {
	$this->balance = $param;
	return $this;
	}
	
	public function getResponse() {
	return $this->response;
	}
	
	protected function getAccountLive() {
	
	$ch = curl_init();
	
	$post =  json_encode(array('key'=>$this->keyLive, 'gdb'=>$this->gdbLive, 'mt4'=>$this->mt4Live, 'login'=>$this->login));
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
	curl_setopt($ch, CURLOPT_URL, $this->urlAccount);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	
	curl_exec($ch);

	if (curl_errno($ch)) {$response = 'Curl error: ' . curl_error($ch);}
	
	curl_close($ch);
	
	return $response;
	
	}
	
	protected function getAccountDemo() {
	
	$ch = curl_init();
	
	$post =  json_encode(array('key'=>$this->keyDemo, 'gdb'=>$this->gdbDemo, 'mt4'=>$this->mt4Demo, 'login'=>$this->login));
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
	curl_setopt($ch, CURLOPT_URL, $this->urlAccount);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	
	curl_exec($ch);

	if (curl_errno($ch)) {$response = 'Curl error: ' . curl_error($ch);}
	
	curl_close($ch);
	
	return $response;
	
	}
	
	protected function createAccountReal() {
	
	$ch = curl_init();
	
	$post =  json_encode(
	
	array(
	
		'key'		=> $this->keyLive, 
		'gdb'		=> $this->gdbLive, 
		'mt4'		=> $this->mt4Live, 
		'name'		=> $this->name,
		'email'		=> $this->email,
		'phone'		=> $this->phone,
		'address'	=> $this->address,
		'city'		=> $this->city,
		'state'		=> $this->state,
		'zip_code'	=> $this->zip_code,
		'country'	=> $this->country,
		'password'	=> $this->password,
		'enabled'	=> $this->enabled,
		'group'		=> $this->group,
		'leverage'	=> $this->leverage,
		'balance'	=> $this->balance
	
	));

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
	curl_setopt($ch, CURLOPT_URL, $this->urlAccount);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	
	$response = curl_exec($ch);
	
	if (curl_errno($ch)) {$response = 'Curl error: ' . curl_error($ch);}
	
	curl_close($ch);
	
	$this->response = json_decode($response);
	
	}
	
	protected function createAccountDemo() {
	
	$ch = curl_init();
	
	$post =  json_encode(
	
	array(
	
		'key'		=> $this->keyDemo, 
		'gdb'		=> $this->gdbDemo, 
		'mt4'		=> $this->mt4Demo, 
		'name'		=> $this->name,
		'email'		=> $this->email,
		'phone'		=> $this->phone,
		'address'	=> $this->address,
		'city'		=> $this->city,
		'state'		=> $this->state,
		'zip_code'	=> $this->zip_code,
		'country'	=> $this->country,
		'password'	=> $this->password,
		'enabled'	=> $this->enabled,
		'group'		=> $this->group,
		'leverage'	=> $this->leverage,
		'balance'	=> $this->balance
	
	));

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
	curl_setopt($ch, CURLOPT_URL, $this->urlAccount);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	
	$response = curl_exec($ch);
	
	if (curl_errno($ch)) {$response = 'Curl error: ' . curl_error($ch);}
	
	curl_close($ch);
	
	$this->response = json_decode($response);
		
	}
	
	protected function updateAccountReal() {
	
	$ch = curl_init();
	
	$post =  json_encode(
	
	array(
	
		'key'		=> $this->keyLive, 
		'gdb'		=> $this->gdbLive, 
		'mt4'		=> $this->mt4Live,
		'login'		=> $this->login, 
		'name'		=> $this->name,
		'email'		=> $this->email,
		'phone'		=> $this->phone,
		'address'	=> $this->address,
		'city'		=> $this->city,
		'state'		=> $this->state,
		'zip_code'	=> $this->zip_code,
		'country'	=> $this->country,
		'password'	=> $this->password,
		'enabled'	=> $this->enabled,
		'leverage'	=> $this->leverage,
		'balance'	=> $this->balance
	
	));

	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
	curl_setopt($ch, CURLOPT_URL, $this->urlAccount);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	
	$response = curl_exec($ch);
	
	if (curl_errno($ch)) {$response = 'Curl error: ' . curl_error($ch);}
	
	curl_close($ch);
	
	$this->response = json_decode($response);
	
	}


}

?>