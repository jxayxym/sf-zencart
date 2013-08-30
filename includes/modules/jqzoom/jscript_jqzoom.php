<script type="text/javascript">
$(document).ready(function(){
	var options = {
		zoomType: "<?= JQZOOM_ZOOMTYPE; ?>",
		zoomWidth: <?= JQZOOM_ZOOMWIDTH; ?>,
		zoomHeight: <?= JQZOOM_ZOOMHEIGHT; ?>,
		xOffset: <?= JQZOOM_XOFFSET; ?>,
		yOffset: <?= JQZOOM_YOFFSET; ?>,
		position: "<?= JQZOOM_POSITION; ?>",
		lens: <?= JQZOOM_LENS; ?>,
		imageOpacity: <?= JQZOOM_IMAGEOPACITY; ?>,
		title: <?= JQZOOM_TITLE; ?>,
		showEffect: "<?= JQZOOM_SHOWEFFECT; ?>",
		hideEffect: "<?= JQZOOM_HIDEEFFECT; ?>",
		fadeinSpeed: "<?= JQZOOM_FADEINSPEED; ?>",
		fadeoutSpeed: "<?= JQZOOM_FADEOUTSPEED; ?>",
		showPreload: <?= JQZOOM_SHOWPRELOAD; ?>,
		preloadText: "<?= JQZOOM_PRELOADTEXT; ?>",
		preloadPosition: "<?= JQZOOM_PRELOADPOSITION; ?>"
	};
	$("#jqzoomMain").jqzoom(options);
});
</script>
