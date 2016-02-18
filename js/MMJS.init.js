// JavaScript Document

jQuery(function(){

	//png
	jQuery('.png24').MMJS_png();
	
	//top main nav level_2 shadow
	jQuery('.shadow').MMJS_opacity(20);
	
	/* js_tab */
	function tab_set( li_obj ){
		var $this = jQuery( li_obj );
		var target_selector = $this.find('a').attr('rel');
		var $target = jQuery(target_selector);
		
		$this.siblings('li').removeClass('active');
		$this.addClass('active');
		
		$target.siblings().hide();
		$target.show();
	}
	
	var $js_tab_li = jQuery( '.js_tab li' )
	$js_tab_li.focus(function(){this.blur()});
	$js_tab_li.find('a').focus(function(){this.blur()});
	$js_tab_li.focus(function(){this.blur()}).click(function(){
		tab_set(this);
	});
	tab_set( $js_tab_li.first() );

	//MMJS_LabelInput
	jQuery('.js_label_input').each( function(){ jQuery(this).MMJS_LabelInput() } )
});
	