<?php

include_once('common.php');


error_reporting(E_ERROR);

$css_out = '';

$html_code = empty( $_POST['html_code'] )?'':trim($_POST['html_code']);








?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jquery-1.5.min.js"></script>
</head>

<body>

<textarea name="html_code"></textarea>


<textarea><?php echo $css_out ?></textarea>


</body>
</html>