<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Helper {

	function url_segment($index) 
	{
		// this function gets the value of specified url segment
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = explode('/', $url);
		return (is_numeric($url[$index])) ? $url[$index] : null;
	}
}