<div id="homeBannerWrapper" style="border-bottom: 1px solid #ccc;margin-bottom: 5px;">
<div id="slider" class="flexslider">
	<ul class="slides">
		<li><img src="<?php echo DIR_WS_IMAGES.'banners/toys/1.jpg' ?>" alt="toys-1"/></li>
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/toys/2.jpg' ?>" alt="toys-2"/></li>	
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/toys/3.jpg' ?>" alt="toys-3"/></li>	
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/toys/4.jpg' ?>" alt="toys-4"/></li>
	</ul>
</div>
</div>
<script type="text/javascript">
$(window).load(function() {
  // The slider being synced must be initialized first
  $('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
  });
});
</script>