<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="images/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0" cellpadding="0" cellspacing="0" class="datb">
  <?php
$em_base=array( 10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30 );
$px_start=9;
$px_end=30;

$os="\t<tr>\n";
$os.="\t\t<th>base px</th>\n";
foreach( $em_base as $v ){
	$os.="\t\t<th>$v px</th>\n";
}
$os.="\t</tr>\n";
for( $i=$px_start;$i<=$px_end;$i++ ){
	$os.= "\t<tr>\n";
	$os.="\t\t<td>$i px</td>\n";
	foreach( $em_base as $v ){
		$os.="\t\t<td>".sprintf('%.3f',$i/$v)."em</td>\n";
	}
	$os.= "\t</tr>\n";
}

echo $os;

?>
</table>
<pre>
Headline 1 - 20px
Headline 2 - 18px
Headline 3 - 16px
Main text - 14px
Sub text - 12px
Footnotes - 10px

Headline 1 - 1.25em (16 x 1.25 = 20)
Headline 2 - 1.125em (16 × 1.125 = 18)
Headline 3 - 1em (1em = 16px)
Main text - 0.875em (16 x 0.875 = 14)
Sub text - 0.75em (16 x 0.75 = 12)
Footnotes - 0.625em (16 x 0.625 = 10)
</pre>
<div style="font-size:12px; line-height:1.5"> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block">Inherited line-height 1.5 times</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:1.5">Item style line-height 1.5 times</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:2">Item style line-height 2 times</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:1.5em">Item style line-height 1.5 em</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:2em">Item style line-height 2 em</span> 
  <!-- END  --> 
</div>
<br />
<div style="font-size:12px; line-height:1.5em"> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block">Inherited line-height 1.5 em</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:1.5">Item style line-height 1.5 times</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:2">Item style line-height 2 times</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:1.5em">Item style line-height 1.5 em</span> 
  <!-- START  --> 
  <span style="font-size:20px; background-color:#FF0; display:inline-block; line-height:2em">Item style line-height 2 em</span> 
  <!-- END  --> 
</div>
<br />
<div style="line-height:2em"> 
  <!-- START  --> 
  <span style="font-size:1.667em; background-color:#FF0; display:inline-block">Inherited line-height 2 em</span> 
  <!-- START  --> 
  <span style="font-size:1.667em; background-color:#FF0; display:inline-block; line-height:1.5">Item style line-height 1.5 times</span> 
  <!-- START  --> 
  <span style="font-size:1.667em; background-color:#FF0; display:inline-block; line-height:2">Item style line-height 2 times</span> 
  <!-- START  --> 
  <span style="font-size:1.667em; background-color:#FF0; display:inline-block; line-height:1.5em">Item style line-height 1.5 em</span> 
  <!-- START  --> 
  <span style="font-size:1.667em; background-color:#FF0; display:inline-block; line-height:2em">Item style line-height 2 em</span> 
  <!-- END  --> 
</div>
</body>
</html>
