<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

echo "this is home view";
echo "<br>Hello " . $_SESSION['username'];
echo '&nbsp;<a href="' . BASEPATH . 'logout">Log Out</a>';