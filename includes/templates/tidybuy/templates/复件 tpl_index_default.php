<div class="centerColumn" id="indexDefault">
<div id="indexDefaultMainContent" class="content"><?php require($define_page); ?></div>
<!-- banner -->
<div>
	<div class="back" style="width:435px;">
	<a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=65')?>"><img src="<?php echo DIR_WS_IMAGES.'banners/home/weddingdress.jpg'?>"></a>	
	<div style="padding:5px;">
	<h2>SHOP ONLINE</h2>
	<ul>
		<li style="margin-bottom:11px;">FREE SHIPPING on All Orders $350 or more.</li>
		<li style="margin-bottom:11px;">Use Western Union Or MoneyGram,get 20% discount.</li>
		<li style="margin-bottom:11px;">Register now get a US$5 coupon.</li>
		<li style="margin-bottom:11px;">Order beyond $200,send a gift.</li>
		<li style="margin-bottom:16px;">Support Payment:Paypal,Visa,MoneyGram and Western Union</li>
	</ul>
	</div>	
	</div>
	<div class="back" style="width:560px;margin-left:5px;">
		<div style="padding:5px;">
		<h2>Discover Your Bridal Style</h2>
		<p>You can always tell when a bride finds the one. It's an incredibly inspiring moment. And we love it. Whether you want to look classic or modern, glamorous or elegant, we've got a gorgeous wedding dress for you at an amazing price. Let us help you discover it in our ever-changing designer collections.</p>
		</div>
		<div><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=65')?>"><img src="<?php echo DIR_WS_IMAGES.'banners/home/weddingdress2.jpg'?>"></a></div>
		<div style="padding:5px;">
		<h2>Shipping</h2>
		<p>All orders here in our site are Shipped Free Worldwide with EMS to America and no Additional Handling costs will be charged...<a href="<?php echo zen_href_link(FILENAME_SHIPPING)?>">lear more</a></p>
		</div>	
		<div><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=65')?>"><img src="<?php echo DIR_WS_IMAGES.'banners/home/weddingdress3.jpg'?>"></a></div>
	</div>
	<br class="clearBoth" />
</div>
<!-- banner end -->
<br class="clearBoth" />
<div class="vertical_menu">
	<div id="content_new" class="multiLabelMenu-concent content_selected">
	<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
	</div>
	<div id="content_featured" class="multiLabelMenu-concent">
	<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
	</div>
	<div id="content_speical" class="multiLabelMenu-concent">
	<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
	</div>
	<div id="content_popular" class="multiLabelMenu-concent">
	<?php require($template->get_template_dir('tpl_modules_popular_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_popular_products.php'); ?>
	</div>	
	<div class="multiLabelMenu-nav">
		<div class="multiLabelMenu-nav-tab new_products_tab tab_selected" rel="content_new"><div>NEW PRODUCTS</div></div>
		<div class="multiLabelMenu-nav-tab featured_products_tab" rel="content_featured"><div>FEATURED PRODUCTS</div></div>
		<div class="multiLabelMenu-nav-tab special_products_tab" rel="content_speical"><div>SPECIAL PRODUCTS</div></div>
		<div class="multiLabelMenu-nav-tab popular_products_tab" rel="content_popular"><div>POPULAR PRODUCTS</div></div>
	</div>	
	<br class="clearBoth" />
</div>
<script type="text/javascript">
	$(".multiLabelMenu-nav-tab").click(function(){
		var rel = $(this).attr("rel");
		if($(".tab_selected").attr("rel")==rel)	return;
		$(".tab_selected").removeClass("tab_selected");
		$(this).addClass("tab_selected");
		$('.content_selected').removeClass('content_selected');
		$("#"+rel).addClass("content_selected");
		
	});

	
</script>	
<br class="clearBoth" />
<div class="home_faq">
<div class="faq">FAQ</div>
<div class="faqq">Q: Why are your items so cheap?</div>
<div class="faqa">A: The reason why our items are so cheap is that we run our own factory. With all the middle dealers being left out of the business, it takes you less money to purchase the same item than it does on any other online sites. We are and always will be dedicated to providing latest fashion and newest design with high quality and low price.</div>
<div class="faqq">Q: Will I be able to receive the dress in time?</div>
<div class="faqa">A: Wedding day is literally the most important day in a girl's life. Nobody would want the wedding dress doesn't make the day. Our long-term strategic cooperative partner in logistic is DHL, who has a tremendous reputation in logistic industry. It covers pratically all the grounds on the planet and it covers grounds fast. So no worries about not getting your item in time, we've got it covered.</div>
<div class="faqq">Q: Will the dress I ordered be a perfect fit?</div>
<div class="faqa">A: One thing customers are all concerned about is the dress won't be a perfect fit. First of all, all the sizes in our size chart are standard. Secondly, if you order a custom size, we've got a group of state-of-the-art tailors to process your dress exactly according to the measurements you provide, it'll be a perfect fit as long as your measurements are correct.</div>
<div class="faqq">Q: Would my dress' color be exactly the same as the one I have seen on your website?</div>
<div class="faqa">A: Normally they should be the same, however, a slight difference (aberration) might exist between the actual dress color and the one's you have seen in the pictures of the color chart, as you know, the showing color of the images depends on the screen's display setting and the screen resolutions.</div>
</div>
</div>