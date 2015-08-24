<?php

define('BASEPATH', 'http://localhost/msgr/index.php');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

function autoloader($class) {
	$class = strtolower($class);
	$file =  ROOT . DS . 'library' . DS . $class . '.php';
	require $file;
}

spl_autoload_register('autoloader');
require ROOT . DS . 'library' . DS . 'config.php';

$page = new Init();
unset($page);
