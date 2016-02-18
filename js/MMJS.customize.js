// JavaScript Document

var MMJS = MMJS || {};


jQuery.fn.MMJS_opacity = function( opacity ){
	opacity = parseInt(opacity);
	opacity = ( opacity > 100 ) ? 100 : opacity;
	opacity = ( opacity < 0 ) ? 0 : opacity;
	return this.each( function(){
		if ( jQuery.support.opacity ){
			this.style.opacity = opacity/100;
		}else{
			this.style.filter = "progid:DXImageTransform.Microsoft.Alpha(Opacity=" + opacity + ")";
		}
	} );
}


/* ************* jQuery Ext jQuery.fn.MMJS_png *****************
// jQuery元素集扩展 jQuery.fn.MMJS_png()
// 功能:解决png兼容性问题
// 说明:
// 需求:jQuery
// LastModify:2010-09-26
*********************************************************** */ 
jQuery.fn.MMJS_png = function( className ){
	return this.each( function(){
		//only IE 6 need to fix 24bit png
		if ( jQuery.browser.msie && jQuery.browser.version==6.0 ){
			if( this.tagName.toUpperCase()=='IMG' ){
				var $ts=jQuery(this);
				//var png_w=$ts.width();
				//var png_h=$ts.height();
				var png_w=this.width || $ts.width();
				var png_h=this.height || $ts.height();
				//alert( png_w + ' ' + png_h );
				var png_url=$ts.attr("src");
				var png_class=$ts.attr("class");
				var png_title=$ts.attr("title");
				var png_style=$ts.attr("style");
				var png_align=$ts.attr("align");
				var strHtml="<span";
				if ( png_class ) strHtml += ' class="' + png_class + '" ';
				if ( png_title ) strHtml += ' title="' + png_title + '" ';
				strHtml += ' style="display:block;';
				if ( png_align ) strHtml += 'float:' + png_align + ';';
				strHtml += 'filter:' + "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + png_url + "', sizingMethod='scale')";
				if ( png_style ) strHtml += ';' + png_style;
				strHtml += '"></span>';
				var $span = jQuery(strHtml);
				$ts.replaceWith($span);
				$span.css( {'width':png_w} );
				$span.css( {'height':png_h} );
			}else{
				//处理png为背景的图片
				var png_url=jQuery(this).css("backgroundImage").slice( 5,-2 );
				if ( /\.png$/i.test(png_url) ){
					this.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + png_url + "', sizingMethod='scale')";
					this.style.backgroundImage = "url('#')";
				}
			}			
		}
	} );
}

/* ************* jQuery Ext jQuery.fn.fixed *****************
// jQuery元素集扩展 jQuery.fn.fixed()
// 功能:将元素设置为 position:fixed
// 说明:IE6不支持position:fixed，用JS实现。
// 需求:jQuery
// LastModify:2010-08-30
*********************************************************** */ 
jQuery.fn.MMJS_fixed = function( func ) {
	return this.each( function(){
		var $this = jQuery(this);
		if ( jQuery.browser.msie && jQuery.browser.version == '6.0' ){
			if ( !$this.data( 'fixed_hooked' ) ){
				$this.css( {'position':'absolute'} );
			
				//如果top是百分比的话，要转换一下。由于算法不同，所以生成一个函数的句柄。只支持百分比或者像素。
				var pos_top = $this.css('top');
				// 如果是百分比
				if( /^[\d]+%$/.test(pos_top) ){
					var get_tar_top = function( scrollTop ){
						return parseInt( jQuery(window).height() * parseInt(pos_top.slice(0,-1)) / 100 + scrollTop );
					}
				}else{// 如果是像素
					var get_tar_top = function( scrollTop ){
						return parseInt( parseInt(pos_top) + scrollTop );
					}
				}
				
				//如果left是百分比的话，要转换一下。由于算法不同，所以生成一个函数的句柄。只支持百分比或者像素。
				var pos_left= $this.css('left');
				// 如果是百分比
				if( /^[\d]+%$/.test(pos_left) ){
					var get_tar_left = function( scrollLeft ){
						return parseInt( jQuery(window).width() * parseInt(pos_left.slice(0,-1)) / 100 + scrollLeft );
					}
				}else{// 如果是像素
					var get_tar_left = function( scrollLeft ){
						return parseInt( parseInt(pos_left) + scrollLeft );
					}
				}
				
				//执行一次
				$this.css( {'top':get_tar_top(jQuery('html').scrollTop()),'left':get_tar_left(jQuery('html').scrollLeft()) } );
				
				//注册滚动条事件
				jQuery(window).scroll( function(){
					$this.css( {'top':get_tar_top(jQuery('html').scrollTop()),'left':get_tar_left(jQuery('html').scrollLeft()) } );
				} );

				//注册resize事件
				$this.MMJS_onWindowResize( function(){
					$this.css( {'top':get_tar_top(jQuery('html').scrollTop()),'left':get_tar_left(jQuery('html').scrollLeft()) } );
				} );
				$this.data( 'fixed_hooked',true );
			}
		}else{
			$this.css( {'position':'fixed'} );
		}
	} );
}
/* *********************************************************** */


/* ************* MMJS.LabelInput *****************
// MMJS 对象函数 MMJS.LabelInput( input_sel,label_sel )
// 功能:显示和隐藏浮在input上的label
// 说明:
// 需求:jQuery
// LastModify:2010-11-15
*********************************************************** */ 
jQuery.fn.MMJS_LabelInput = function( input_sel,label_sel ){
	var $this = jQuery(this);
	var input_sel = input_sel || 'input.js_lai';
	var label_sel = label_sel || 'label.js_lai';
	var $input = $this.find(input_sel);
	var $label = $this.find(label_sel);
	if ( $input && $label ){
		var check = function(){
			$input.val(jQuery.trim($input.val()));
			if ( $input.val() == '' ){
				$label.show();
			}else{
				$label.hide();
			}
		}
		//
		check();
		//
		$input.focusin(function(){
			$label.hide();
		})
		.focusout(function(){
			check();
		});
	}
}


/* *********************************************************** */





