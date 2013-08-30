(function($){
	//摆效果
	$.my_swing = function(settings){
		if(settings.freq<=0)
			settings.freq = 1;
		var options = $.extend(
				true,
				{
					'freq':2,//1秒钟摆的次数
					'deg':30,//一次摆的角度
					'swing_time':2//摆动时间(秒)
				},
				settings
			);
		var swing_interval = Math.ceil(1000/options.freq);//毫秒
		$(this).data({deg:options.deg,is_swing:0/*是否正在摆*/});//状态信息
		var totals_swing_times = options.swing_time*options.freq;//总要共摆动的次数
		var swing_deg_decrease = Math.ceil(options.deg/totals_swing_times);//每一次摆后减小的摆幅度
		
		function _rotate(to_deg){
			$(this).css("-webkit-transform","rotate("+to_deg+"deg)");
		}
		function _rotateAnimate(deg_form,deg_to,interval){
			var deg_interval = Math.ceil((deg_form-deg_to)/interval);
		}
		
		function swing(){
			var deg = $(this).data(deg);
		}
		
	}
})($);	