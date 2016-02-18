<?php

ob_start();

// 显示对象的结构 自动加<pre>标签，方便在浏览器中显示
function showvar($var){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

//include_once('./includes/miscellaneous.php');
//include_once('./includes/type.php');
include_once('./includes/db.php');
//include_once('./includes/pageinfo.php');
//include_once('./includes/ubb.php');
include_once('./includes/session.php');
include_once('./includes/cookie.php');





$ss=new session();

// session start
$ss->start();



?>