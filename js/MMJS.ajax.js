// AJAX Extension & Function
// Require jQuery 1.5
// Author KJS


window.console = window.console || {};
window.console.log = window.console.log || function(){};
var MMJS = MMJS || {};
MMJS.AJAX = MMJS.AJAX || {};
var _tmp_namespace_object = MMJS.AJAX;


/* extend jQuery1.5 AJAX Option */
jQuery.ajaxPrefilter( function( options, originalOptions, jqXHR ) {
  /* add option - [timestamp_key] */
	if ( options.timestamp_key ) {
		options.timestamp_key = jQuery.trim( options.timestamp_key );
	}
	if ( !options.timestamp_key || !options.timestamp_key.length ){
		options.timestamp_key = 'ts';
	}
	/* add option - [timestamp] */
	if ( options.timestamp ) {
    options.timestamp = jQuery.trim( options.timestamp );
		if ( options.timestamp.length ){
			if ( options.data && options.data.length ){
				options.data += '&' + options.timestamp_key + '=' + options.timestamp;
			}else{
				options.data = options.timestamp_key + '=' + options.timestamp;
			}
		}
  }

});


(function( NSOBJ,$ ){
	
	NSOBJ.action_ts = {};
	
	NSOBJ.doAjax = function( action, data, ajax_params ){
		
		/* settings */
		var delay_send = 200; /* delay send in ms, to reduce the request frequency */
		
		/* check action */
		action = action || '';
		action = jQuery.trim( action );
		if ( !action.length ){ return false };
		
		/* set ts */
		NSOBJ.action_ts[action] = NSOBJ.action_ts[action] || 0;
		NSOBJ.action_ts[action] ++ ;
		var timestamp = NSOBJ.action_ts[action];
		
		/* set default ajax params */
		var default_ajax_params = {
			url : 'ws_agent.php',
			type : 'get',
			timestamp_key : 'ws_ts',
			dataType : 'json'
		};
		
		ajax_params = jQuery.extend( default_ajax_params,ajax_params );
		ajax_params['data'] = data || {};
		ajax_params['data']['action'] = action;
		ajax_params['timestamp'] = timestamp;
		
		/* do branch ajax */
		switch( action ){
			case 'getNotebookList':
				break;
		}
		
		/* do AJAX */
		(function(){
			var cur_timestamp = timestamp;
			var cur_action = action;
			setTimeout( function(){
				//console.log( cur_timestamp + ' ' + NSOBJ.action_ts[cur_action] );
				if ( cur_timestamp >= NSOBJ.action_ts[cur_action] ){
					jQuery.ajax( ajax_params );
				}
			},delay_send );
		})();
		
	}
	
})(_tmp_namespace_object,jQuery);


