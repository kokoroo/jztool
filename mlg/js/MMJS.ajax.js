// AJAX Extension & Function
// Require jQuery 1.5
// Author Albert Lee
/*
jQuery AJAX 扩展
 - 为jQuery.ajax添加一个选项 timestamp_key，默认值为ts
 - 为jQuery.ajax添加一个选项 timestamp ，如果有设置则在每次请求的后面加上一个 [timestamp_key] = [timestamp] 的值
 - 
*/


/* console.log 兼容性 */
window.console = window.console || {};
window.console.log = window.console.log || function(){};
/* 命名空间设置/可更改命名空间 */
var MMJS = MMJS || {};
MMJS.AJAX = MMJS.AJAX || {};
var _tmp_namespace_object = MMJS.AJAX;




/* 主程序 */
(function( NSOBJ,$ ){
	/* 默认值设置 */
	var ajax_delay_send = 0; /* 延迟发送的毫秒值。如果在这个时间内有多个相同action的ajax请求发送，则只会发送最后一个请求。主要用来避免短时间内过多的ajax请求。如果设置为0则取消延迟发送。只在action不为空时有效。 */
	var ajax_key_action = 'ajax_action'; /* 发送给服务器的action的键值。服务器应该按此名称返回此值。 */
	var ajax_key_order = 'ajax_order'; /* 发送给服务器的action序列的键值。服务器应该按此名称返回此值。返回值用来比较是否是最新返回。 */
	var ajax_key_timestamp = 'ajax_timestamp'; /* 发送给服务器的timestamp的键值。服务器应该按此名称返回此值。 */
	
	var ajax_default_params = {
		type : 'get',
		dataType : 'json'  // 期望取得json的返回数据
	};
	
	/* 初始化 */
	NSOBJ.ajax_action_order = {}; /* 存放action序列号最大值的对象，用来做返回判断。 */
	
	/* function - doAjax */
	/*
	- ajax_config 是提交给jQuery.ajax()的配置参数
	- ajax_config 还可以包自定义的含配置参数
	- data 中可以包含 ajax_key_action 和 ajax_key_timestamp 指定的变量，如果包含则启用相应功能。
	*/
	NSOBJ.doAjax = function( data, ajax_config ){
		data = data || {};
		ajax_config = ajax_config || {};
		
		/* 初始化配置项 */
		ajax_delay_send = ajax_config.ajax_delay_send || ajax_delay_send;
		ajax_key_action = ajax_config.ajax_key_action || ajax_key_action;
		ajax_key_order = ajax_config.ajax_key_order || ajax_key_order;
		ajax_key_timestamp = ajax_config.ajax_key_timestamp || ajax_key_timestamp;
		
		/* 初始化action值 */
		var ajax_action = data[ajax_key_action] || '';
		ajax_action = jQuery.trim( ajax_action );
		
		/* 初始化timestamp值 */
		var ajax_timestamp = data[ajax_key_timestamp] || '';
		ajax_timestamp = jQuery.trim( ajax_timestamp );
		
		/* 如果ajax_action有值 */
		
		console.log( ajax_key_action );
		
		if ( ajax_action ){
			/* 相应action的order值加1 */
			NSOBJ.ajax_action_order[ajax_action] = NSOBJ.ajax_action_order[ajax_action] || 0;
			NSOBJ.ajax_action_order[ajax_action] ++ ;
			var cur_action_max_order = NSOBJ.ajax_action_order[ajax_action];
			data[ajax_key_order] = cur_action_max_order;
			
			/* 设置回调函数 */
			ajax_config['dataFilter'] = function( raw_data, type ){
				var data = {};
				if ( type == 'json' ){
					try{
						data = jQuery.parseJSON(raw_data);
						if ( data[ajax_key_action] && data[ajax_key_order] ){
							if ( data[ajax_key_order] < NSOBJ.ajax_action_order[data[ajax_key_action]] ){
								console.log( data[ajax_key_order] + ' < ' + NSOBJ.ajax_action_order[data[ajax_key_action]] + ' refused' );
								return false;
							}
						}
					}catch(e){
						return false;
					}
				}
				console.log( 'success' );
				return data;
			}


			ajax_config['success'] = [
				function(data, textStatus, jqXHR){
					console.log( 'the first function' );
				},
				function(){
					console.log( 'the second function' );
				}
			];
			
			/*
			ajax_config['success'] = [
				function(data, textStatus, jqXHR){
					if ( data[ajax_key_action] && data[ajax_key_order] ){
						if ( data[ajax_key_order] < NSOBJ.ajax_action_order[data[ajax_key_action]] ){
							console.log( data[ajax_key_order] + ' < ' + NSOBJ.ajax_action_order[data[ajax_key_action]] + ' refused' );
							//jqXHR.abort();
							console.log(jqXHR);
						}
					}
					console.log( 'success' );
				},
				function(){
					console.log( 'the second function' );
				}
			];
			*/
			
			/*
			(function(){
				var cur_ajax_action = ajax_action;
				var cur_ajax_order = ajax_order;
				setTimeout( function(){
					//console.log( cur_timestamp + ' ' + NSOBJ.action_ts[cur_action] );
					if ( cur_ajax_order >= NSOBJ.ajax_action_order[cur_ajax_action] ){
						jQuery.ajax( ajax_params );
					}
				},ajax_delay_send );
			})();			
			*/
		};
		
		/* 如果ajax_timestamp有值 */
		if ( ajax_timestamp ){
			data[ajax_key_timestamp] = ajax_timestamp;
		};
		
		/* 设置 jQuery.ajax 的值 */
		ajax_params = jQuery.extend( ajax_default_params,ajax_config );
		ajax_params['data'] = data || {};
		
		/* do AJAX */
		if( ajax_action && ajax_delay_send ){
			(function(){
				var cur_ajax_action = ajax_action;
				var cur_ajax_order = cur_action_max_order;
				setTimeout( function(){
					//console.log( cur_timestamp + ' ' + NSOBJ.action_ts[cur_action] );
					if ( cur_ajax_order >= NSOBJ.ajax_action_order[cur_ajax_action] ){
						jQuery.ajax( ajax_params );
					}
				},ajax_delay_send );
			})();
		}else{
			jQuery.ajax( ajax_params );
		}
		
	}
	
})(_tmp_namespace_object,jQuery);


