<?php
$webTrack = array(
	'misses-dressycom'=>array(	
		'cnzz'=>'<script src="http://s20.cnzz.com/stat.php?id=5626707&amp;web_id=5626707&amp;show=pic" type="text/javascript"></script>',
	),
);
$k = strtr(HTTP_SERVER,array('http://www'=>'','https://www'=>'','.'=>''));
if(isset($webTrack[$k]['cnzz']))
    echo $webTrack[$k]['cnzz'];
?>
<?php
if(isset($webTrack[$k]['GoogleAnalyticsTrackingID'])){
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $webTrack[$k]['GoogleAnalyticsTrackingID'];?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php
}