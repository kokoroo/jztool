<?php

error_reporting(E_ERROR);

$post_html=array();
if ( count($_POST)>0 ){
	foreach ( $_POST as $k=>$v ){
		$post_html[$k]=htmlspecialchars($v);
	}
}


//显示比例个数
$display_num=50;

//最大值比例base值
$max_base_nums=array( 2,4,6,8,10,12,16,100 );


if ( isset($_POST['sbtn_min_scale']) ){
	
	
	
	$num1 = intval( $_POST['ti_num1'] );
	$num2 = intval( $_POST['ti_num2'] );
	
	if( $num1!=0 and $num2!=0 ){ 
	
		//符号
		$num1_pos=$num1>0?'':'-';
		$num2_pos=$num2>0?'':'-';
		//绝对值
		$num1=abs($num1);
		$num2=abs($num2);
		//是否交换（大的在前小的在后）
		$switched=( $num1>$num2 )?false:true;
		
		$max_s=$max=$switched?$num2:$num1;
		$min_s=$min=$switched?$num1:$num2;
		
		$max_try=intval( $min/2 );
		
		for( $i=1;$i<=$max_try;$i++ ){
			if ( $min%$i==0 ){
				//除数
				$num_cs=$min/$i;
				if ( $max%$num_cs==0 ){
					$max_s=$max/$num_cs;
					$min_s=$i;
					break;
				}
			}
		}
		
		$num1_s=$switched?$min_s:$max_s;
		$num2_s=$switched?$max_s:$min_s;
		
		
	}
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Divider Caculator</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post">


<h1>Min Scale</h1>
<h2>最小比例计算器：</h2>
<p>计算2个数的最小比例。</p>

<h3>Input:</h3>

<p>Num1: <input name="<?php echo $tmp_key='ti_num1'?>" type="text" size="10" value="<?php echo $post_html[$tmp_key] ?>" /></p>

<p>Num1: <input name="<?php echo $tmp_key='ti_num2'?>" type="text" size="10" value="<?php echo $post_html[$tmp_key] ?>" /></p>

<p>Width Greater Than: <input name="<?php echo $tmp_key='width_gt'?>" type="text" size="10" value="<?php echo $post_html[$tmp_key] ?>" /> pixel</p>
<p>Width Less Than: <input name="<?php echo $tmp_key='width_lt'?>" type="text" size="10" value="<?php echo $post_html[$tmp_key] ?>" /> pixel</p>

<p>Height Greater Than: <input name="<?php echo $tmp_key='height_gt'?>" type="text" size="10" value="<?php echo $post_html[$tmp_key] ?>" /> pixel</p>
<p>Height Less Than: <input name="<?php echo $tmp_key='height_lt'?>" type="text" size="10" value="<?php echo $post_html[$tmp_key] ?>" /> pixel</p>

<p><input name="sbtn_min_scale" type="submit" id="sbtn_min_scale" value="Submit" />
</p>

<h3>Output:</h3>


<p>

<?php
if ( !empty($num1_s) and !empty($num2_s) ){
?>

<div style="float:left">
<table border="0" cellpadding="0" cellspacing="0" class="datb">
	<tr>
   	  <td align="center">Scale</td>
	</tr>
<?php

	
	$w_gt = empty( $_POST['width_gt'] )?false:intval($_POST['width_gt']);
	$w_lt = empty( $_POST['width_lt'] )?false:intval($_POST['width_lt']);
	
	$h_gt = empty( $_POST['height_gt'] )?false:intval($_POST['height_gt']);
	$h_lt = empty( $_POST['height_lt'] )?false:intval($_POST['height_lt']);

	$display_num_cc = $display_num;
	$times=1;
	$max_test = 10000;
	while(true){
		$tmp_w = $num1_s*$times;
		$tmp_h = $num2_s*$times;
		$times ++;
		$max_test -- ;
		if ( $max_test < 0 ) break;
		if ( $display_num_cc < 0 ) break;
		if ( !empty($w_gt) and $tmp_w < $w_gt ) continue;
		if ( !empty($w_lt) and $tmp_w > $w_lt ) continue;
		if ( !empty($h_gt) and $tmp_h < $h_gt ) continue;
		if ( !empty($h_lt) and $tmp_h > $h_lt ) continue;
		$display_num_cc --;
		?>
			<tr>
					<td align="center"> <?php echo $num1_pos.($tmp_w)?> : <?php echo $num2_pos.($tmp_h)?> </td>
			</tr>
		<?php
	}
?>
</table>
</div>


<div style="float:left;padding-left:10px">
<table border="0" cellpadding="0" cellspacing="0" class="datb">
	<tr>
   	  <td align="center">Base</td>
      <td align="center">Scale</td>
	</tr>
<?php
	foreach( $max_base_nums as $v ){
?>
	<tr>
      <td align="center"><?php echo $v?></td>
   	  <td align="center"> <?php echo $switched?sprintf( '%.3f',$v*$num1_s/$num2_s ):$v?> : <?php echo $switched?$v:sprintf( '%.3f',$v*$num2_s/$num1_s )?> </td>
	</tr>
<?php
	}//for
?>
</table>
</div>


<?php
}//if
?>

</p>


</form>
</body>
</html>