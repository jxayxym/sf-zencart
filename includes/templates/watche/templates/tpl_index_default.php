<div id="indexDefault">

<div>
	<div style="float:left;"><span style="display:inline-block;margin-right:8px">
	<a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=1')?>"><img src="<?php echo DIR_WS_IMAGES.'banners/watche/mens-watches.jpg'?>" width="316" height="336" alt="Mens Watches"></a>
	</span>
	<span style="display:inline-block;">
	<a href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=2')?>">
	<img src="<?php echo DIR_WS_IMAGES.'banners/watche/ladies.jpg'?>" width="316" height="336" alt="Ladies Watches">
	</a>
	</span>
	</div>
<div style="float:left;margin-left:8px;">
	<div style="height:174px">
	<span class="ibl" style="margin-right:8px"><a href="<?php echo zen_href_link(FILENAME_BRANDS)?>"><img src="<?php echo DIR_WS_IMAGES.'banners/watche/brand-a-z.jpg'?>" width="215" height="162" alt="Watch Brands A - Z"></a></span>
	<span class="ibl"><a href="<?php echo zen_href_link(FILENAME_SPECIALS)?>"><img src="<?php echo DIR_WS_IMAGES.'banners/watche/sale.jpg'?>" width="115" height="162" alt="Sale"></a></span>
	</div>
	<div><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'manufacturers_id=3')?>"><img src="<?php echo DIR_WS_IMAGES.'banners/watche/spring-collection-2013-v1.jpg'?>" width="341" height="162" alt="Mothers Day"></a></div>
</div><div style="clear:both"></div>
</div>

<?php
require($template->get_template_dir('tpl_modules_recently_purchased_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_recently_purchased_products.php');
?>

<div>
<div style="margin:0px 0px 28px 0px">
<span class="back" style="width:380px"><hr></span>
<span class="back" style="text-align:center;width:240px;">POPULAR BRANDS &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo zen_href_link(FILENAME_BRANDS)?>" style="color:teal;">SHOW ALL</a></span>
<span class="back" style="width:380px"><hr></span>
<br class="clearBoth" />
</div>
<?php 
$popular_brands = get_ext_manufacturers(0,16);
echo '<ul class="homepagePopular">';
while (!$popular_brands->EOF){
	echo '<li><a href="'.zen_href_link(FILENAME_DEFAULT,'manufacturers_id='.$popular_brands->fields['manufacturers_id']).'"><img src="'.DIR_WS_IMAGES.$popular_brands->fields['manufacturers_image'].'" alt="'.$popular_brands->fields['manufacturers_name'].'" /></a></li>';
	$popular_brands->MoveNext();
}
echo '</ul>';
?>
</div>
</div>