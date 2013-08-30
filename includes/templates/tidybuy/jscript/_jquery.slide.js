(function($){
	$.my_slide_plugin = function(settings){
		var _direction = ["V","H"];//支持水平和垂直两种滑动
		var options = $.extend(true,{},settings,
				{
					'containner_css':{'overflow':'hidden','margin':0,'padding':0},
					'item_wrapper_css':{'margin':0,'padding':0,'list-style':'none'},
					'item_css':{'margin':0,'padding':0},
					'child_mousemove':function(){}
				}
			)
			
		var direction = _direction[options.direction]?_direction[options.direction]:_direction[0];//滑动方向
		var item_w_h  = options.item_w_h;//每个展示点的宽或高
		var item_num  = options.item_num;//每屏展示点的数量

		var item_max_width   = 0;//展示点的最大宽度
		var item_max_height  = 0;//展示点的最大高度
		
		var item_wrapper_dom = $("#"+options.item_wrapper_id);//展示点的容器
		//计算最大高度和宽度
		item_wrapper_dom.children().each(function(i){
			alert($(this).html());
			var width = $(this).width();
			var height = $(this).height();
			item_max_width = width>item_max_width?width:item_max_width;
			item_max_height = height>item_max_height?height:item_max_height;
		});		
		
		var container_css = direction=="V"?{width:item_max_width,height:item_w_h*item_num}:{width:item_w_h*item_num,height:item_max_height};
		$.extend(options.containner_css,container_css);
		var container = $("<div></div>").css(options.containner_css)
										.appendTo(item_wrapper_dom.parent())
										.append(item_wrapper_dom);
		
		var item_total = item_wrapper_dom.children().size();
		var item_warpper_css = direction=="V"?{width:item_max_width,height:item_w_h*item_total}:{width:item_w_h*item_total,height:item_max_height};
		$.extend(options.item_wrapper_css,item_warpper_css);
		item_wrapper_dom.css(options.item_wrapper_css);
		
		var item_css = direction=="V"?{'width':item_max_width,'height':item_w_h}:{'width':item_w_h,'height':item_max_height,'float':'left'};
		$.extend(options.item_css,item_css);
		item_wrapper_dom.children().css(options.item_css);
		

		alert();
	}
})($);