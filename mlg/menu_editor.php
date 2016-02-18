<?php

/* 初始化session */
session_start();
$_SESSION['mlg'] = empty($_SESSION['mlg']) ? array() : $_SESSION['mlg'];
$ss_mlg = &$_SESSION['mlg'];


/* ajax 请求 */
$is_ajax = $post_ajax = empty($_POST['ajax'])?false:true;
$is_ajax = $get_ajax = empty($_GET['ajax'])?false:true;
$ajax_return_type = 'json';
$ajax_return_data = $_GET;



/* 获取菜单配置文件列表 */
$menu_conf_path = './menu_conf';
$menu_conf_list = scandir( $menu_conf_path );


/* 获取当前菜单配置文件 */
$current_menu = empty($ss_mlg['current_menu'])?false:$ss_mlg['current_menu'];


if ( $is_ajax ){
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	switch( $ajax_return_type ){
		case 'json':
			header('Content-type:application/json');
			die( json_encode($ajax_return_data) );
			break;
	}
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Multi Level List Generator</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/jquery-1.5.min.js"></script>
<script type="text/javascript" src="./js/MMJS.ajax.js"></script>
<script type="text/javascript" src="./js/init.js"></script>
<script type="text/javascript">
jQuery( function(){
	jQuery('.js_fm_test').AjaxForm();
	jQuery('.js_fm_test').AjaxForm();
	jQuery('.js_fm_test').AjaxForm();
	jQuery('.js_fm_test').AjaxForm();
	
	
	
	
	/* init tab */
	jQuery( '.js_tab_btn a' ).click( function(){
		var $this = jQuery(this);
		$this.parents('li').first().siblings('li').removeClass('active').end().addClass('active');
		var target = $this.attr('rel');
		if ( jQuery.trim(target).length ){
			var $target = jQuery(target);
			$target.siblings().hide().end().show();
		}
	} ).first().click();
	
	/* bind ajax event */
	jQuery('.js_ajax_info').bind( 'ajaxSend',function(){
		jQuery(this).text('Ajaxing...').show();
	} ).bind( 'ajaxComplete',function(){
		jQuery(this).hide();
	} ).hide();
	
	
	/* init ajax */
	
	function doAjax( action,data ){
		
	}
	
	
	/* reg btn actions */
	jQuery('.js_add_filename_btn').click(function(){
		
		jQuery.ajax({
			'url':'',
			'method':'POST',
			'data':{
				
			},
			'dataType':'json',
		});
		
	});
	

} );


</script>
</head>

<body>
<h1>Multi Level List Generator</h1>
<h2>Current List : <span class="js_current_list"></span></h2>
<div class="tab_container_s1">
  <div class="tab_btn_s1 js_tab_btn">
    <ul>
      <li class="active"><a href="javascript:;" rel=".js_tab_content .js_select_list">Select List</a></li>
      <li><a href="javascript:;" rel=".js_tab_content .js_add_list">Add List</a></li>
      <li><a href="javascript:;" rel=".js_tab_content .js_generate_code">Generate Code</a></li>
    </ul>
  </div>
  <div class="tab_content_s1 js_tab_content">
    <div class="js_select_list">
      <form action="" method="post" id="select_menu_config_file" class="js_fm_test">
        <h2>Select Menu Config File</h2>
        <select name="select_filename">
          <option value="1">Please select a menu - 1</option>
          <option value="2">Please select a menu - 2</option>
        </select>
      </form>
    </div>
    <div class="js_add_list">
      <form action="" method="post" id="form_add_menu_config_file" class="js_fm_test">
        <h2>Add Menu Config File</h2>
        <input type="text" name="add_filename" />
        <input type="button" value="add" class="js_add_filename_btn" />
      </form>
    </div>
    <div class="js_generate_code">
      <form action="" method="post">
        <h2>Generate HTML and CSS Code</h2>
        <input type="button" value="Generate" />
      </form>
    </div>
  </div>
</div>
<div class="ajax_info js_ajax_info">Ajaxing...</div>
</body>
</html>