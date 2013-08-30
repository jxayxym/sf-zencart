<?php 
echo zen_draw_form('', zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT));
echo zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);
echo zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();
?>
<div class="search-container blur" id="search_container">
	<button class="search-submit hide-text forward" type="submit">Search</button>
<!--	<div class="forward" id="search_selection_container">-->
<!--		<div class="selected-store">-->
<!--			<div style="overflow:hidden;width:100px;font-size:8px;"><div id="search_selected" class="back">All-Categories</div></div>-->
<!--			<div class="back select-arrow">▼</div>-->
<!--		</div>-->
<!--	</div>-->
	<input id="search_input" name="keyword" class="back" type="text" placeholder="Search" />
</div>
</form>
<script type="text/javascript">
//$('#search_selections').change(function(){
//	var text = $('option:selected',this).text();
//	$('#search_selected').text(text);
//});
$('#search_container').focusin(function(){
//	var toWitdh = 316;
	$(this).removeClass("blur");
//	$(this).animate({width: toWitdh},500);
//	$(".selected-store").animate({opacity: 'show'},1000);
}).focusout(function (){
	$(this).addClass("blur");
});
</script>