<?php

include_once('common.php');


error_reporting(E_ERROR);



$type_a=array(

	'radio'=>'<input type="radio" name="checkbox" id="checkbox" />$item$',
	
	'checkbox'=>'<input type="checkbox" name="checkbox" id="checkbox" />$item$',

	'option'=>'<option>$item$</option>',
	
	'link'=>'<a href="#">$item$</a>',

);

//
$post_html=array();
if ( count($_POST)>0 ){
	foreach ( $_POST as $k=>$v ){
		$post_html[$k]=htmlspecialchars($v);
	}
}





function array_warp_out( $da,$div,$header,$footer,$default='',$group_data_inline = false ){
	
	$oa=false;
	
	$header=trim($header);
	$footer=trim($footer);
	
	
	if ( is_array($da) and is_numeric($div) ){
	
		$div=intval($div);
		
		$ca=array_chunk($da,$div);
		
		$ca_last_key=count($ca)-1;
		
		$oa_key = 0;
		
		$oa[$oa_key].=$header;
		
		foreach ( $ca as $k=>$v ){
			if ( is_array($v) and count($v)>0 ){
				foreach( $v as $kk=>$vv ){
					if ( !$group_data_inline ){
						$oa_key++;
						$oa[$oa_key]="\t".$vv;
					}else{
						$oa[$oa_key].=$vv;
					}
				}
				
				if ( $k==$ca_last_key ){
					
					$diff=$div-count($v);
					
					if ( $diff>0 ){
						for ( $i=0;$i<$diff;$i++ ){
							if ( !$group_data_inline ){
								$oa_key++;
								$oa[$oa_key]="\t".$default;
							}else{
								$oa[$oa_key].=$default;
							}
						}
					}
					
					if ( !$group_data_inline ){
						$oa_key++;
					}
					$oa[$oa_key].=$footer;
					break;
				}else{
					if ( !$group_data_inline ){
						$oa_key++;
					}
					$oa[$oa_key].=$footer;
					$oa_key++;
					$oa[$oa_key].=$header;
				}
			} 
		}
	}
	return $oa;
}



function fix_item($item){
	$os=trim($item);
	$os = str_replace( '\n',"<br />",$os );

	if ( isset($_POST['cb_english_br']) ){
		//preg_match( '/^(.*?)([\w\s\\\\\^\$\.\[\]\/\|\(\)\?\*\+\{\}\:\"\'\,\<\>\;\~\`\”\“\：\，\。]+)$/i',$os,$m );
		preg_match( '/^(.*?)([\w\s\\\\\^\$\.\[\]\/\|\(\)\?\*\+\-\{\}\:\"\'\,\<\>\;\~\`]*)$/iu',$os,$m );
		//print_r($m);
		//echo trim($m[1])."\n";
		//echo trim($m[2])."\n";
		//echo "\n";
		
		if ( strlen($m[1])!=0 or strlen($m[2])!=0 ){
			$os=trim($m[1]).'<br />'.trim($m[2]);
		}else{
			$os='';
		}

		//$os=trim($m[1]).' <br /> '.$m[2];
	}
	
	return $os;
	
}


$oa=array();

if ( isset($_POST['btn_submit']) ){
	$separator=$_POST['separator'];
	$replace=$_POST['replace'];
	$content=trim($_POST['content']);
	$type=$_POST['type'];
	$ccfrom=is_numeric($_POST['ccfrom'])?intval($_POST['ccfrom']):1;
	$preg_pattern=trim($_POST['preg_match']);
	$preg_pattern=empty($preg_pattern)?'':$preg_pattern;
	if ( !empty($preg_pattern) ){
		$preg_pattern_ava=true;
	}else{
		$preg_pattern_ava=false;
	}

	
	if ( !array_key_exists($type,$type_a) ){
		$type='option';
	}
	
	if( strlen($separator)>0 and strlen($content)>0 ){
		
		if ( $separator=='\n' ){
			$separator="\n";
		}
		if ( $separator=='\t' ){
			$separator="\t";
		}
		
		
		$da=explode($separator,$content);
	
		$da=array_map('fix_item',$da);
		
		
		$cc=$ccfrom;
		foreach ( $da as $k=>$v ){
			if ( strlen($v)>0 ){
				
				$search_da=array(
					'$item$',
					'$width$',
					'$cc$',
				);
				
				$replace_da=array(
					$v,
					(mb_strlen($v,'utf-8')+1),
					$cc,
				);
				
				$preg_search=array();
				$preg_replace=array();
				
				if ( $preg_pattern_ava ){
					preg_match( $preg_pattern,$v,$m );
					foreach( $m as $mk=>$mv ){
						$preg_search[]='$m'.$mk.'$';
						$preg_replace[]=$mv;
					}
					
					$search_da=array_merge($search_da , $preg_search);
					$replace_da=array_merge($replace_da , $preg_replace);
				}
				
				//showvar($search_da);
				//showvar($replace_da);
				
				if ( !empty( $_POST['cb_ignore_noreplace'] ) ){
					$replaced_str=str_ireplace($search_da,$replace_da,$replace);
					if ( $replaced_str!=$replace ){
						$oa[]=$replaced_str;
						$cc++;	
					}
				}else{
					$oa[]=str_ireplace($search_da,$replace_da,$replace);
					$cc++;
				}
				
			}
		}

		if ( !empty( $_POST['cb_distinct'] ) ){
			$oa=array_unique($oa);
		}
		
		if ( isset($_POST['cb_group_warp']) and is_numeric($_POST['group_div']) ){
			$group_data_inline = empty($_POST['group_data_inline']) ? false : true;
			$oa=array_warp_out( $oa,$_POST['group_div'],$_POST['group_header'],$_POST['group_footer'],$_POST['group_default'],$group_data_inline );
		}
		
		if ( isset($_POST['cb_global_warp']) ){
			$oa=array_merge( array($_POST['global_header']),$oa,array($_POST['global_footer']) );
		}
		
		$oa=array_map('htmlspecialchars',$oa);
		
	}
}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="script.js"></script>
<title>模板分割</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="form_warp">
<form method="post">

	<p>
    分隔符：<input name="separator" type="text" id="separator" value="<?php echo $post_html['separator'] ?>" />
	<input name="cb_english_br" type="checkbox" id="cb_english_br" <?php if ( isset( $_POST['cb_english_br']) ){ echo 'checked="checked"'; } ?>/> 
	后英文换行
    $cc$ From <input type="text" name="ccfrom" size="5" value="<?php echo isset($post_html['ccfrom'])?$post_html['ccfrom']:1 ?>" />
	</p>
	
	<p>
	preg_match <input type="text" name="preg_match" size="50" value="<?php echo isset($post_html['preg_match'])?$post_html['preg_match']:'' ?>" />
	<input name="cb_ignore_noreplace" type="checkbox" id="cb_ignore_noreplace" <?php if ( isset( $_POST['cb_ignore_noreplace']) ){ echo 'checked="checked"'; } ?>/>Ignore No replace
    </p>
	
	<p>
	<input name="cb_distinct" type="checkbox" id="cb_distinct" <?php if ( isset( $_POST['cb_distinct']) ){ echo 'checked="checked"'; } ?>/>
	DISTINCT
	</p>
	

    <p>
    <input name="cb_global_warp" type="checkbox" id="cb_global_warp" <?php if ( isset( $_POST['cb_global_warp']) ){ echo 'checked="checked"'; } ?>/>
    Global Warp: 
    Global Header: 
    <textarea name="global_header" cols="50" rows="5" id="global_header"><?php echo $post_html['global_header'] ?></textarea>
    Global Footer: 
    <textarea name="global_footer" cols="50" rows="5" id="global_footer"><?php echo $post_html['global_footer'] ?></textarea>
    </p>
    
    <p>
    <input name="cb_group_warp" type="checkbox" id="cb_group_warp" <?php if ( isset( $_POST['cb_group_warp']) ){ echo 'checked="checked"'; } ?>/>
    Group Warp: 
    Group Division: <input name="group_div" type="text" id="group_div" value="<?php echo $post_html['group_div'] ?>" size="10" />
    Group Header: <input name="group_header" type="text" id="group_header" value="<?php echo $post_html['group_header'] ?>" />
    Group Footer: <input name="group_footer" type="text" id="group_footer" value="<?php echo $post_html['group_footer'] ?>" />
    Group Default: <input name="group_default" type="text" id="group_default" value="<?php echo $post_html['group_default'] ?>" />
    <label><input type="checkbox" name="group_data_inline" value="1" <?php echo empty($group_data_inline)?'':'checked="checked"'?> />Group Data Inline</label>
    </p>
    
    <p>
    PATTERN:
    <input type="button" value="$item$ " onclick="insertText(replace,'$item$')" />
    <input type="button" value="$width$ " onclick="insertText(replace,'$width$')" />
    <input type="button" value="$cc$ " onclick="insertText(replace,'$cc$')" />
	<input type="button" value="$m1$ " onclick="insertText(replace,'$m1$')" />
	<input type="button" value="$m2$ " onclick="insertText(replace,'$m2$')" />
	<input type="button" value="$m3$ " onclick="insertText(replace,'$m3$')" />
    </p>
    
    <p>
    <textarea name="replace" style="width:1000px" rows="10" id="replace"><?php echo $post_html['replace'] ?></textarea>
    </p>
    
    <p>
    CONTENT:
    </p>
    
    <p>
    <textarea name="content" style="width:1000px" rows="10" id="content"><?php echo $post_html['content'] ?></textarea>
	</p>
    
    <p>
    <input name="btn_submit" type="submit" id="btn_submit" value="&lt;------DO------&gt;" />
    </p>
    
</form>
</div>
<p>
OUTPUT:(<?php echo count($oa); ?>)
</p>
<p>
<textarea name="htmlout" style="width:1000px" rows="10" id="htmlout"><?php echo implode( "\n",$oa ) ?></textarea>
</p>



<div id="history_data">
<form method="post">
	<h2>History Data:</h2>

	<p>
    <input name="cb_save_data" type="checkbox" id="cb_save_data" />Save Data
    <br />
    Title:<input name="ti_data_title" type="text" id="ti_data_title" size="30" />
    </p>
    
    <p><input name="sbtn_add_data" type="submit" id="sbtn_add_data" value="Add Data" />
    </p>
    
	<p>   
    <div id="history_choose">
    	<ul><li><a href="#">111</a></li></ul>
        <ul><li><a href="#">111</a></li></ul>
        <ul><li><a href="#">111</a></li></ul>
        <ul><li><a href="#">111</a></li></ul>
    </div>
	</p>

	<div style="clear:both"></div>
</form>
</div>


</body>

</html>