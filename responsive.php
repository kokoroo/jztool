<?php

error_reporting(E_ERROR);

$post_html=array();
if ( count($_POST)>0 ){
	foreach ( $_POST as $k=>$v ){
		$post_html[$k]=htmlspecialchars($v);
	}
}


$con_width = empty($post_html['con_width'])?0:$post_html['con_width'];
$col_num = empty($post_html['col_num'])?0:$post_html['col_num'];
$margin_width = empty($post_html['margin_width'])?0:$post_html['margin_width'];


$page_width = $con_width + $margin_width * 2;

$match_da = array();


if( $con_width>0 && $col_num >0 ){
	$match_da = get_match($con_width,$col_num);
}



function get_match( $width,$col_num ){
	$unit_width_max = ceil($width / $col_num);
	
	$ra = array();
		
	for( $div_w=0;$div_w<=$unit_width_max;$div_w++ ){
		if( ($width-$div_w*($col_num-1)) % $col_num == 0 ){
			$ra[] = array(
				'div_width'=>$div_w,
				'col_width'=>($width-$div_w*($col_num-1)) / $col_num
			);
		}
	}
	
	return $ra;
	
}








?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Divider Caculator</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>

<body>
<form method="post">


<h1>Responsive Grid Caculator</h1>
<h2>响应式设计网格计算器：</h2>

<br />

<h3>Input:</h3>

<p>Content Width: <input name="con_width" type="text" id="con_width" size="10" value="<?php echo $post_html['con_width'] ?>" /> px
&nbsp;&nbsp;&nbsp;&nbsp;
Column Number: <input name="col_num" type="text" id="col_num" size="5"  value="<?php echo $post_html['col_num'] ?>"/>
&nbsp;&nbsp;&nbsp;&nbsp;
Margin Width: <input name="margin_width" type="text" id="margin_width" size="5"  value="<?php echo $post_html['margin_width'] ?>"/> px
</p>

<p>Max Width: <input name="max_width" type="text" id="max_width" size="10" value="<?php echo $post_html['max_width'] ?>" /> px
&nbsp;&nbsp;&nbsp;&nbsp;
Precision: <input name="precision" type="text" id="precision" size="5"  value="<?php echo empty($post_html['precision'])?4:$post_html['precision'] ?>"/>
</p>

<p><input type="submit" value="Submit" />
</p>

<p>Page Width:
<input type="text" name="page_width" value="<?php echo $page_width ?>" readonly="readonly" /> px
</p>

<h3>Match:</h3>

<p>

<table border="0" cellpadding="0" cellspacing="0" class="datb">
	<tr>
   	<td>Match:</td>
			<?php
        foreach ( $match_da as $v ){
          ?>
					<td>
          <input type="radio" name="match" class="js_match_select" 
          	data-con_width="<?php echo $post_html['con_width'] ?>"
            data-col_num="<?php echo $post_html['col_num'] ?>"
            data-margin_width="<?php echo $post_html['margin_width'] ?>"
            data-col_width="<?php echo $v['col_width'] ?>"
            data-div_width="<?php echo $v['div_width'] ?>"       
          >
          </td>
          <?php
        }
      ?>
  </tr>
  <tr>
   	<td>Col Width:</td>
			<?php
        foreach ( $match_da as $v ){
          echo '<td>'.$v['col_width'].'</td>';
        }
      ?>
  </tr>
  <tr>
    <td>Div Width:</td>
      <?php
     	foreach ( $match_da as $v ){
				echo '<td>'.$v['div_width'].'</td>';
			}
			?>
  </tr>
</table>


</p>


<p>
Content Width Pct:
<input type="text" name="con_width_pct" value="" readonly="readonly" />
&nbsp;&nbsp;&nbsp;&nbsp;
Margin Width Pct:
<input type="text" name="margin_width_pct" value="" readonly="readonly" />
&nbsp;&nbsp;&nbsp;&nbsp;
Col Width Pct:
<input type="text" name="col_width_pct" value="" readonly="readonly" />
&nbsp;&nbsp;&nbsp;&nbsp;
Div Width Pct:
<input type="text" name="div_width_pct" value="" readonly="readonly" />
</p>


<h3>Grid</h3>

<div id="grid_playground" class="js_grid_playground">
  <div class="grid_bg js_grid_bg">
  </div>
  <div class="grid_width js_grid_width"></div>
</div>

<h3>Real</h3>

<div id="grid_real" class="js_grid_real">
	<div class="grid js_grid_real_grid"></div>
</div>




</form>

<script type="text/javascript">

var grid_height = 200;
var bg_color = '#F66';
var margin_color = '#6f6';
var col_color = '#666';

var bar_height = 20;
var bar_div = 10;
var bar_bgc = '#333';

function update_grid(){
	
	var precision = parseInt(jQuery('input[name=precision]').val());
	
	var $con_width_pct = jQuery('input[name=con_width_pct]');
	var $margin_width_pct = jQuery('input[name=margin_width_pct]');
	var $col_width_pct = jQuery('input[name=col_width_pct]');
	var $div_width_pct = jQuery('input[name=div_width_pct]');

	var $match = jQuery('input[name=match]:checked');
	
	var con_width = parseInt($match.data('con_width')) || 0;
	var col_num = parseInt($match.data('col_num')) || 0;
	var margin_width = parseInt($match.data('margin_width')) || 0;
	var col_width = parseInt($match.data('col_width')) || 0;
	var div_width = parseInt($match.data('div_width')) || 0;
		
	var page_width = con_width + margin_width * 2;
	var div_num = col_num - 1;
	
	
	var con_width_pct = con_width/page_width*100;
	var margin_width_pct = margin_width/page_width*100;
	var col_width_pct = col_width/con_width*100;
	var div_width_pct = div_width/con_width*100;
	
	if( precision >= 0 ){
		con_width_pct = con_width_pct.toFixed(precision);
		margin_width_pct = margin_width_pct.toFixed(precision);
		col_width_pct = col_width_pct.toFixed(precision);
		div_width_pct = div_width_pct.toFixed(precision);
	}
	
	$con_width_pct.val(con_width_pct+'%');
	$margin_width_pct.val(margin_width_pct+'%');
	$col_width_pct.val(col_width_pct+'%');
	$div_width_pct.val(div_width_pct+'%');
	
	draw_grid(col_num,con_width,page_width,margin_width,col_width,div_width,col_width_pct,div_width_pct,precision);
	
	draw_grid_real(col_num,con_width_pct,margin_width_pct,col_width_pct,div_width_pct,page_width,precision);
	
	
	
}




function draw_grid_real( col_num,con_pct,margin_pct,col_pct,div_pct,page_width,precision ){
	var $grid_real = jQuery('.js_grid_real');
	var $grid_real_grid = jQuery('.js_grid_real_grid');
	
	var max_width = parseInt(jQuery('input[name=max_width]').val()) || 0;

	$grid_real.css({
		'min-width':page_width,
		'background-color':margin_color
	})
	
	if( max_width ){
		$grid_real.css({
			'max-width':max_width
		})
	}
	
	
	$grid_real_grid.empty().css({
		'width':con_pct+'%',
		'margin-left':margin_pct+'%',
		'margin-right':margin_pct+'%',
		'overflow':'hidden',
		'background-color':bg_color
	});

	for( var i=1;i<=col_num;i++ ){
		var $col = jQuery('<div class="col_'+i+'"></div>').css({
			'width':col_pct+'%',
			'height':grid_height,
			'background-color':col_color,
			'float':'left',
			'display':'inline'
		});
		
		if( i>1 ){
			$col.css({
				'margin-left':div_pct+'%'
			});
		}
		
		$grid_real_grid.append($col);
	}
}



function draw_grid( col_num,con_width,page_width,margin_width,col_width,div_width,col_width_pct,div_width_pct,precision ){
	
	var $play_ground = jQuery('.js_grid_playground');
	var $grid_bg = $play_ground.find('.js_grid_bg');
	var $grid_width = $play_ground.find('.js_grid_width');
	
	var grid_height = bar_height*col_num + bar_div*(col_num+1);
	
	$play_ground.css({
		'width':page_width,
		'height':grid_height,
		'position':'relative'
	});
	
	/* draw bg */
	
	$grid_bg.empty().css({
		'width':page_width,
		'height':grid_height,
		'background-color':bg_color,
		'position':'absolute',
		'left':0,
		'top':0
	});
	
	$margin_left = jQuery('<div class="margin_left"></div>').css({
		'width':margin_width,
		'height':grid_height,
		'background-color':margin_color,
		'position':'absolute',
		'left':0,
		'top':0
	});
	
	$margin_right = jQuery('<div class="margin_right"></div>').css({
		'width':margin_width,
		'height':grid_height,
		'background-color':margin_color,
		'position':'absolute',
		'left':con_width+margin_width,
		'top':0
	});
	
	$grid_bg.append($margin_left);
	
	for( var i=1;i<=col_num;i++ ){
		var $col = jQuery('<div class="col_'+i+'"></div>').css({
			'width':col_width,
			'height':grid_height,
			'background-color':col_color,
			'position':'absolute',
			'left':margin_width+(i-1)*(div_width+col_width),
			'top':0
		});
		
		$grid_bg.append($col);
	}
	
	$grid_bg.append($margin_right);
	
	/* draw width */
	var font_size = 12;
	var font_family = 'Arial';
	var font_color = '#fff'
	
	
	$grid_width.empty().css({
		'width':con_width,
		'height':grid_height,
		'position':'absolute',
		'left':margin_width,
		'top':0,
		'font-size':font_size,
		'font-family':font_family,
		'color':font_color
	});
	
	for( var i=1;i<=col_num;i++ ){
		var $col = jQuery('<div class="col_'+i+'"></div>').css({
			'width':i*col_width + (i-1)*div_width,
			'height':bar_height,
			'background-color':bar_bgc,
			'position':'absolute',
			'left':0,
			'top':i*bar_div + (i-1)*bar_height,
			'opacity':0.6
		});
		
		//float caculate to dec caculate
		var times = Math.pow(10,precision);
		var bar_pct = (parseInt(col_width_pct*times)*i + parseInt(div_width_pct*times)*(i-1)) / times;
		
		
		
		var $col_text = jQuery('<div class="col_'+i+'">' + i+'x= <input type="text" value="'+bar_pct+'%" readonly="readonly" style="background-color:transparent;border:0 none;"></input></div>').css({
			'height':bar_height,
			'line-height':bar_height+'px',
			'position':'absolute',
			'left':0,
			'top':i*bar_div + (i-1)*bar_height,
		});
		
		
		$grid_width.append($col);
		$grid_width.append($col_text);
	}	
	
	
	
	
}








jQuery(function(){
	
	jQuery('.js_match_select').change(function(){
		update_grid();
	});
	
	
})


</script>


</body>
</html>
