<style>
#ben-sileshowproduct img
{
	margin-right:10px;	
}
</style>
<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/crawler.js'></script>
<div class="marquee" id="mycrawler">
<?php foreach($medias as $media) {?>
	<?php if($media['imagethumbnail']){ ?>
    
    <a href="<?php echo $media['link']?>">
		<img src="<?php echo $media['imagethumbnail']?>" />
    </a>
	<?php } ?>
<?php } ?>
</div>

<script type="text/javascript">
$(document).ready(function(e) {
	
    setTimeout('runbanner()',1000);

});
function runbanner()
{
	marqueeInit({
		uniqueid: 'mycrawler',
		style: {
			'padding': '2px',
			
			'height': '150px',
			'width': '100%',
		},
		inc: 5, //speed - pixel increment for each iteration of this marquee's movement
		mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
		moveatleast: 2,
		neutral: 150,
		savedirection: true,
		random: true
	})
}
</script>