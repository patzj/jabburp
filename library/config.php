<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

// database constants
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DBNAME', 'jabburp');

// defaults
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ERR_CONTROLLER', 'error');
define('DEFAULT_ACTION', 'index');

// timezone
date_default_timezone_set('UTC');