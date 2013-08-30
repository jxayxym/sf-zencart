 <div style="overflow:hidden;height:539px;position:relative;">
 	<div id="home-banner-slider" class="flexslider">
 		<ul class="slides">
 			<li>
 			<a href="<?php echo zen_href_link(zen_get_info_page(18843),'products_id=18843')?>" >
 				<img src="images/banners/morilee/Style-93004-Beaded-Tulle.jpg" width="100%" alt="Style 93004 Beaded Tulle" />
 			</a>	
 			</li>
 			<li>
			 	<a href="<?php echo zen_href_link(zen_get_info_page(18846),'products_id=18846')?>" >
			 		<img src="images/banners/morilee/Style-93007-Chiffon-with-Beading.jpg" width="100%" alt="Style 93007 Chiffon with Beading" />
			 	</a>
			 </li>
			 <li>
			 	<a href="<?php echo zen_href_link(zen_get_info_page(18854),'products_id=18854')?>" >
			 		<img src="images/banners/morilee/Style-93015-Beaded-Organza.jpg" width="100%" alt="Style 93015 Beaded Organza" />
			 	</a>
			 </li>
			 <li>
			 	<a href="<?php echo zen_href_link(zen_get_info_page(18851),'products_id=18851')?>" >
			 		<img src="images/banners/morilee/Style-93012-Beaded-Tulle.jpg" width="100%" alt="Style 93012 Beaded Tulle" />
			 	</a>
			 </li>
			 <li>
			 	<a href="<?php echo zen_href_link(zen_get_info_page(18879),'products_id=18879')?>" >
			 		<img src="images/banners/morilee/Style-93040-Ruffled-Tulle-with-Beading.jpg" width="100%" alt="Style 93040 Ruffled Tulle with Beading" />
			 	</a>
			 </li>
			 <li>
			 	<a href="<?php echo zen_href_link(zen_get_info_page(18890),'products_id=18890')?>" >
			 		<img src="images/banners/morilee/Style-93051-Allover-Beading.jpg" width="100%" alt="Style 93051 Allover Beading" />
			 	</a>
			 </li>
		</ul>
	</div>
	<div id="home-banner-slider-control-nav" class="slider-control-nav">
		<ol class="slides flex-control-nav">
			<li>Style 93004<br />Beaded Tulle</li>
			<li>Style 93007<br />Chiffon with Beading</li>
			<li>Style 93015<br />Beaded Organza</li>
			<li>Style 93012<br />Beaded Tulle</li>
			<li>Style 93040 Ruffled<br />Tulle with Beading</li>
			<li>Style 93051<br />Allover Beading</li>
		</ol>
	</div>
</div>
<style>
.slider-control-nav { margin:0; width: 100%; height:50px;background-color:black;border:0;position:absolute;bottom:0;left:0;opacity: 0.8;}
.slider-control-nav li { width: 161px; height:48px; color: white; margin: 8px 0; padding: 0; height: 30px;cursor:pointer;}
.slider-control-nav li.flex-active-slide { color: #d97e3d;}
.slider-control-nav .flex-control-nav{bottom:0;position:inherit;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	  $('#home-banner-slider-control-nav').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 166,
		    itemMargin: 5,
		    asNavFor: '#home-banner-slider'
		  });
		   
		  $('#home-banner-slider').flexslider({
		    animation: "slide",
		    controlNav: false,
		    directionNav: false,
		    animationLoop: false,
		    slideshow: false,
		    direction: "vertical",
		    initDelay: 500,
		    sync: "#home-banner-slider-control-nav"
		  });
});
 </script>