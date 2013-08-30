 <div style="overflow:hidden;height:539px;position:relative;">
 	<div id="home-banner-slider" class="flexslider">
 		<ul class="slides">
 			<li>
 				<img src="images/banners/home-slider-banner/Maggie-Sottero-Wedding-Dresses.jpg" width="977" height="539" alt="Maggie Sottero Fall 2013" />
 			</li>
 			<li>
			 	<a href="index.php?main_page=advanced_search_result&search_in_description=1&keyword=allure" >
			 		<img src="images/banners/home-slider-banner/Allure-Wedding-Dresses.jpg" width="977" height="539" alt="Allure Fall 2013" />
			 	</a>
			 </li>
			 <li>
			 	<a href="index.php?main_page=advanced_search_result&keyword=allure&search_in_description=1&categories_id=6&inc_subcat=1&sort=100d" >
			 	<img src="images/banners/home-slider-banner/Allure-Bridesmaid-Dresses.jpg" width="977" height="539" alt="Allure Bridesmaid Dresses" />
			 	</a>
			 </li>
			 <li>
			 	<img src="images/banners/home-slider-banner/Kathy-Hilton.jpg" width="977" height="539" alt="Kathy Hilton" />
			 </li>
			 <li>
			 	<a href="index.php?main_page=advanced_search_result&search_in_description=1&keyword=Sophia+Tolli" >
			 		<img src="images/banners/home-slider-banner/Sophia-Tolli-Bridesmaid-Dresses.jpg" width="977" height="539" alt="Sophia Tolli Special Occasions" />
			 	</a>
			 </li>
			 <li>
			 	<a href="index.php?main_page=advanced_search_result&search_in_description=1&keyword=Mori+Lee" >
			 	<img src="images/banners/home-slider-banner/Mori-Lee-Julietta-Wedding-Dresses.jpg" width="977" height="539" alt="Mori Lee Julietta" />
			 	</a>
			 </li>
		</ul>
	</div>
	<div id="home-banner-slider-control-nav" class="slider-control-nav">
		<ol class="slides flex-control-nav">
			<li>Maggie Sottero<br />Fall 2013</li>
			<li>Allure<br />Fall 2013</li>
			<li>Allure<br />Bridesmaid Dresses</li>
			<li>Kathy Hilton<br />Special Occasions</li>
			<li>Sophia Tolli<br />Special Occasions</li>
			<li>Mori Lee<br />Julietta</li>
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