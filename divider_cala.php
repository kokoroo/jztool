<?php

error_reporting(E_ERROR);

$post_html=array();
if ( count($_POST)>0 ){
	foreach ( $_POST as $k=>$v ){
		$post_html[$k]=htmlspecialchars($v);
	}
}



$item_px=0;

$div_px=0;



$result=array();

$result_num=100;

$result_counter=0;


if ( isset($_POST['sbtn_div_cala']) ){
	
	$width		= intval( $_POST['ti_width'] );
	$item_num	= intval( $_POST['ti_item_num'] );
	$div_num	= intval( $_POST['ti_div_num'] );
	
	
	if ( $item_num>0 and $width>$item_num ){
	
		for( $div_px=1;$div_px<=intval($width/$item_num);$div_px++ ){
			
			$item_px= ($width-($div_px*$div_num))/$item_num;
			
			$total = ($item_px + $div_px)*$item_num;
			
			
			if ( is_int( $item_px ) ){
				$result[]=array( 'item_px'=>$item_px,'div_px'=>$div_px,'total_px'=>$total );
				$result_counter++;
				
				if ( $result_counter==$result_num ){
					break;
				}
			}
			
		}	
	
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


<h1>Divider Caculator</h1>
<h2>分割计算器：</h2>
<p>自动计算最小分割像素。</p>

<h3>Input:</h3>

<p>Width: <input name="ti_width" type="text" id="ti_width" size="10" value="<?php echo $post_html['ti_width'] ?>" /> 
pixel
</p>

<p>Item Number: <input name="ti_item_num" type="text" id="ti_item_num" size="5"  value="<?php echo $post_html['ti_item_num'] ?>"/>
</p>

<p>Divider Number: <input name="ti_div_num" type="text" id="ti_div_num" size="5"  value="<?php echo $post_html['ti_div_num'] ?>"/>
</p>

<p><input name="sbtn_div_cala" type="submit" id="sbtn_div_cala" value="Submit" />
</p>

<h3>Output:</h3>


<p>

<table border="0" cellpadding="0" cellspacing="0" class="datb">
	<tr>
   	  <td>Item Pixel:</td>
        <?php
        	foreach ( $result as $v ){
				echo '<td>'.$v['item_px'].'</td>';
			}		
		?>
    </tr>
    <tr>
   	  <td>Divider Pixel:</td>
        <?php
        	foreach ( $result as $v ){
				echo '<td>'.$v['div_px'].'</td>';
			}		
		?>        
    </tr>
    <tr>
   	  <td>Total Pixel:</td>
        <?php
        	foreach ( $result as $v ){
				echo '<td>'.$v['total_px'].'</td>';
			}		
		?>        
    </tr>
</table>


</p>


</form>
</body>
</html>
