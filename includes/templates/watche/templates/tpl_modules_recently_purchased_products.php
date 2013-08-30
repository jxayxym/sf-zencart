<?php
include(DIR_WS_MODULES . zen_get_module_directory('recently_purchased_products.php'));

if(!$list_recently_puchased->EOF){
?>
<div id="recently_purched_products" class="centerBoxWrapper">
<h2><?php echo TABLE_HEADING_HOT_PRODUCTS ?></h2>
<div class="recently_purched_products flexslider">
<ul class="slides">
<?php
	while(!$list_recently_puchased->EOF){
?>
	<li><div class="item"><a href="<?php echo zen_href_link(zen_get_info_page($list_recently_puchased->fields['products_id']),'products_id=' . $list_recently_puchased->fields['products_id'])?>"><img src="<?php echo DIR_WS_IMAGES.$list_recently_puchased->fields['products_image']?>" width="200px" height="200px" alt="<?php $list_recently_puchased->fields['products_name']?>"></a><br /><a href="<?php echo zen_href_link(zen_get_info_page($list_recently_puchased->fields['products_id']),'products_id=' . $list_recently_puchased->fields['products_id'])?>"><?php echo zen_trunc_string($list_recently_puchased->fields['products_name'],20); ?></a></div></li>
<?php	
		$list_recently_puchased->MoveNext();
	}
?>
</ul>
</div>
</div>
<script type="text/javascript">
$(window).load(function() {
  $('.recently_purched_products').flexslider({
    animation: "slides",
    animationLoop: true,
    itemWidth: 200,
    itemMargin: 5,
	controlNav: false,
  });
});
</script> 
<?php	
}
?>