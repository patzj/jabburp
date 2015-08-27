<?php

define('BASEPATH', 'http://localhost/jabburp/');
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
