<?php
class GlobalConf{
	public $conf;
	public static $attempts;
	public function __construct(){
		require 'conf.php';
		$this->ip_address = $ip_address;
		$this->base_url = $base_url;
		$this->max_attempts = $max_attempts; 
}	
	public function addAttempt(){
		$attempts++;
}	
	public function resetAttempts(){
		$attempts = 0;
}
}
?>
