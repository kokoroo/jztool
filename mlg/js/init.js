// JavaScript Document










jQuery.fn.AjaxForm = function( ex_config,ex_data ){
	var form_data = {};
	var form_config = null;
	
	/* 搜集所有表单数据 */
	this.each(
		function(){
			var $this = jQuery(this);
			/* 查找form标签 */
			if ( $this.attr('tagName') == 'FORM' ){
				var $form = $this;
			}else{
				var $form = $this.parents( 'form' ).first();
			}
			/* fomm的属性 */
			var form_attr = {
				'action':jQuery.trim($form.attr('action')),
				'method':jQuery.trim($form.attr('method')).toLowerCase(),
				'enctype':$form.attr('enctype') || 'application/x-www-form-urlencoded'
			};
			/* form所影响的ajax配置项 */
			if ( !form_config ){
				form_config = {
					'url':form_attr.action,
					'method':form_attr.method
				};
			}
			
			/* 查找有name属性的表单数据标签 */
			var $named_fields = $form.find( 'input,select,textarea' ).filter( '[name!=""]' );
			/* 加入数据列表 */
			$named_fields.each(function(){
				var $this = jQuery(this);
				var key = $this.attr('name');
				if ( form_data[key] ){
					if ( form_data[key] instanceof Array ){
						form_data[key].push($this.val());
					}else{
						form_data[key] = [ $this.val() ];
					}
				}else{
					form_data[key] = $this.val();
				}
			});
		}
	);
	/* 合并ex_config */
	var ajax_config = jQuery.extend( form_config,ex_config );
	
	/* 合并ex_data */
	var ajax_data = jQuery.extend( form_data,ex_data );
	
	ajax_config['data'] = ajax_data;
	
	
	
	//console.log(ajax_config);
	
	/* 发送AJAX */
	MMJS.AJAX.doAjax(jQuery.extend(ajax_config,{'ajax':true,'ajax_action':'test'}));
	
	return this;
	
}