<div id="homeBannerWrapper">
<div id="slider" class="flexslider">
	<ul class="slides">
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/home1/Mori-Lee-Wedding-Dress-1913.jpg' ?>" alt="Mori-Lee-Wedding-Dress-1913"/></li>	
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/home1/Sherri-Hill-1456.jpg' ?>" alt="Sherri-Hill-1456"/></li>
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/home1/Maggie-Sottero-Wedding-Dresses.jpg' ?>" alt="Maggie-Sottero-Wedding-Dresses"/></li>	
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/home1/Christina-Wu-15509.jpg' ?>" alt="Christina-Wu-15509"/></li>
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/home1/Mori-Lee-Bridesmaid-Dress-672.jpg' ?>" alt="weddingMori-Lee-Bridesmaid-Dress-672"/></li>
	    <li><img src="<?php echo DIR_WS_IMAGES.'banners/home1/Prom-Dresses-Sale.jpg' ?>" alt="Prom-Dresses-Sale"/></li>		
	</ul>
</div>
<div id="carousel" class="flexslider">
	<ul class="slides">
	    <li><span>Mori Lee<br />Spring 2013</span></li>
	    <li><span>Sherri Hill<br />Prom 2013</span></li>
	    <li><span>Maggie Sottero<br />Spring 2013</span></li>
	    <li><span>Christina Wu<br />Bridal Gowns</span></li>
	    <li><span>Mori Lee<br />Bridesmaid Dresses</span></li>	
	    <li class="lastItem"><span>Red Hot<br />Prom Dress Sale</span></li>		
	</ul>
</div>
</div>
<script type="text/javascript">
$(window).load(function() {
  // The slider being synced must be initialized first
  $('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
    itemWidth: 162,
    itemMargin: 6,
    asNavFor: '#slider',
	directionNav:false,
  });
   
  $('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"
  });
});
</script>