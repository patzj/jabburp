<?php

define('BASEPATH', 'http://192.168.1.6/jabburp/');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

function autoloader($class) {
	$class = strtolower($class);
	$file =  ROOT . DS . 'library' . DS . $class . '.php';
	require_once $file;
}

spl_autoload_register('autoloader');
require_once ROOT . DS . 'library' . DS . 'config.php';

$page = new Init();
unset($page);
