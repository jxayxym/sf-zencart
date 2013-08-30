<div class="navProductsPreviewWrapper">
	<div id="products_preview_left" class="back"></div>
	<div class="products_preivew_content_wrapper">
		<div id="products_preview_containner" class="centeredContent back">
		<?php echo $content_preview;	?>
		</div>
	</div>
	<div id="products_preview_right" class="forward"></div>
</div>
<br class="clearBoth" />
<script type="text/javascript">
var o_page = <?php echo $javascript_obj?>;
function page(page){
	if($('#preview_page'+page).size()==0){
    $.ajax({
        url      : "<?php echo html_entity_decode(zen_href_link(FILENAME_PRODUCT_INFO,'ajax_request=get')) ?>",
        type     : "GET",
        cache    : true,
        data 	 : {'page':page,'action':'products_preview','products_id':<?php echo (int)$_GET['products_id'] ?>},
        dataType : 'json',
        async	 : false,
        success : function(data){
        	if(page>o_page.cur_page){
            	$("#products_preview_containner").append(data.html);
        	}else{
        		$("#products_preview_containner").prepend(data.html);
        		$('.products_preivew_content_wrapper').scrollLeft($('.products_preivew_content_wrapper').scrollLeft()+$('.products_preivew_content_wrapper').width());
        	}
        	$("img.lazy",'#preview_page'+page).show().lazyload({
        		effect : "fadeIn",
        	});	
        },
        error   : function(error){alert('error');}
    });	
	}

	if(page>o_page.cur_page){
    	$('.products_preivew_content_wrapper').animate(
    			{scrollLeft:$('.products_preivew_content_wrapper').scrollLeft()+$('.products_preivew_content_wrapper').width()},
    			2000
        );
    	o_page.cur_page++;
	}else{
    	$('.products_preivew_content_wrapper').animate(
    			{scrollLeft:$('.products_preivew_content_wrapper').scrollLeft()-$('.products_preivew_content_wrapper').width()},
    			2000
        );
    	o_page.cur_page--;
	}
}
$(document).ready(function(){
	//产品预览
	$('#products_preview_right').click(function(){
		if(o_page.cur_page==o_page.total_page)
			alert('Here is the last page!');
		else
			page(o_page.cur_page+1);
	});
	$('#products_preview_left').click(function(){
		if(o_page.cur_page==1)
			alert('Here is the first page!');
		else
			page(o_page.cur_page-1);
	});	
});
</script>