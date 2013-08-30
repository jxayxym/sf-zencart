(function($){
	$.my_scroll_plugin = function(settings){
		var options = $.extend(
				true,
				{
					'containner_css':{'overflow':'hidden','height':'300px'},
					'child_mousemove':function(){}
				},
				settings
			);
		var up_scroll_id = options.up_scroll_id;
		var down_scroll_id = options.down_scroll_id;
		var containner_id = options.containner_id;

		settings.containner_id
		$('#'+containner_id).css(options.containner_css);
		
		if(options.step)
			var offset = options.step;
		else{
			var offset = $('#'+containner_id).children().height();
		}
		
		function moveScrollBar(offset,direction,step){
			var scrollHeight = $('#'+containner_id)[0].scrollHeight;
			var max_scrollTop = scrollHeight-$('#'+containner_id).height();
			
			if(direction=='+')
				var target_scroll_top = parseInt($('#'+containner_id).scrollTop())+parseInt(offset);
			else
				var target_scroll_top = parseInt($('#'+containner_id).scrollTop())-parseInt(offset);
			
			target_scroll_top = target_scroll_top<0?0:target_scroll_top;
			target_scroll_top = target_scroll_top>max_scrollTop?max_scrollTop:target_scroll_top;
			
			$('#'+containner_id).animate(
					{scrollTop : target_scroll_top},
					step	
			);
			
		}
		
		$('#'+down_scroll_id).click(function(){
			moveScrollBar(offset,'+',500);
		});
		$('#'+up_scroll_id).click(function(){
			moveScrollBar(offset,'-',500);
		});
		$('#'+containner_id).children().mousemove(options.child_mousemove);
	}
})($);