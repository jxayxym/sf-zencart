<div id="homeBannerWrapper">
<div id="slider" class="flexslider">
	<ul class="slides">
	    <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=42')?>"><img src="<?php echo DIR_WS_IMAGES.'banners/home/ebags/2013_0520_HP-M01.jpg' ?>" alt="extra 10% off"/></a></li>	
	    <li><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=1020')?>"><img src="<?php echo DIR_WS_IMAGES.'banners/home/ebags/20130521_Fathers-Day-HP.jpg' ?>" alt="Sherri-Hill-1456"/></a></li>
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