<?php 
if (!$this_is_home_page) {
?>
<script type="text/javascript">
$(document).ready(function(){
	$(".shopByOptionName,.leftBoxHeading").click(function(){
		$(this).next().slideToggle(500);
	});
});		
</script>
<?php
}
?>