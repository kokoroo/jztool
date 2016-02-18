<?php

include_once('common.php');


error_reporting(E_ERROR);

if ( !empty($_POST['numbers']) ){
	$rows = explode("\n",$_POST['numbers']);
	$percent_range = $_POST['percent_range'];
	$sum = 0;
	foreach ( $rows as $k=>$v ){
		$trimed_v = trim($v);
		if ( is_numeric($trimed_v) ){
			$rows[$k]= floatval( $v );
			$sum += $rows[$k];
		}else{
			unset($rows[$k]);
		}
	}
	if ( $sum > 0 ){
		$orginal_da = array();
		$percent_da = array();
		$percent_sum = 0;
		
		$col_str_da = array();
		
		foreach ( $rows as $v ){
			$orginal_da[] = $v;
			$percent_da[] = $percent = round($v/$sum*$percent_range);
			$percent_sum += $percent;
			
			$col_str_da[] = '<col width="'.$percent.'%">';
			
		}
		$remainder = $percent_range - $percent_sum;
		
	}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="script.js" type="text/javascript"></script>
<title>Percent Caculator</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Percent Caculator</h1>
<div id="form_warp">
  <form method="post" action="">
    <h3>Percent Range</h3>
    <input type="text" name="percent_range" value="<?php echo empty($_POST['percent_range'])?100:$_POST['percent_range']?>" />
    <br />
    <br />
    <h3>Data</h3>
    <textarea rows="15" cols="50" name="numbers"><?php echo $_POST['numbers']?></textarea>
    <br />
    <br />
    <input type="submit" value="submit" />
  </form>
</div>
<br />
<div class="">
  <table class="datb" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="col">Orginal</th>
      <th scope="col">Percent</th>
      <th scope="col">Total</th>
      <th scope="col">Remainder</th>
    </tr>
    <?php
if ( $sum > 0 ){
	foreach( $orginal_da as $k=>$v ){
		
		if ( $k==0 ){
		?>
    <tr>
      <th scope="row"><?php echo $orginal_da[$k] ?></th>
      <td><input type="text" value="<?php echo $percent_da[$k] ?>%"  /></td>
      <td align="center" rowspan="<?php echo count($orginal_da) ?>"><?php echo $percent_range ?>%</td>
      <td align="center" rowspan="<?php echo count($orginal_da) ?>"><?php echo $remainder ?>%</td>
    </tr>
    <?php			
		}else{
		?>
    <tr>
      <th scope="row"><?php echo $orginal_da[$k] ?></th>
      <td><input type="text" value="<?php echo $percent_da[$k] ?>%"  /></td>
    </tr>
    <?php
    } 
	}
}
?>
  </table>
  <textarea cols="50" rows="20"><?php echo implode("\n",$col_str_da)?></textarea>
  
  
</div>
</body>
</html>