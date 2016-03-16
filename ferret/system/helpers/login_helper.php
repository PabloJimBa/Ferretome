<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function is_logged_in() {
	$CI =& get_instance();
	$is_logged = $CI->session->userdata('is_logged');
	
    return ($is_logged == true);
}

function require_login() {
	if(!is_logged_in()) {
		header('Location: index.php?c=login');
		die;
	}
}

function strip_querystring($url) {
	if($commapos = strpos($url, '?')) {
		return substr($url, 0, $commapos);
	} else {
		return $url;
	}
}

function me() {
	if(isset($_SERVER["SCRIPT_NAME"])) {
		$me = $_SERVER["SCRIPT_NAME"];
	} else if(isset($_SERVER["REQUEST_URI"])) {
		$me = $_SERVER["REQUEST_URI"];
	} else if(isset($_SERVER["PHP_SELF"])) {
		$me = $_SERVER["PHP_SELF"];
	} else if(isset($_SERVER["PATH_INFO"])) {
		$me = $_SERVER["PATH_INFO"];
	}

	return strip_querystring($me);
}

function qualified_me() {
	$protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	$this_host = (isset($_SERVER["HTTP_HOST"])) ? $_SERVER["HTTP_HOST"] : $_SERVER["SERVER_NAME"];

	return $protocol . $this_host . me();
}

?>
