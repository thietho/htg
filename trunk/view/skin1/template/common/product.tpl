<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/crawler.js'></script>
<div class="marquee" id="mycrawler2">
<?php foreach($medias as $media) {?>
	<?php if($item['imagethumbnail']){ ?>
    <a href="<?php echo $media['link']?>">
		<img src="<?php echo $media['imagethumbnail']?>" />
    </a>
	<?php } ?>
<?php } ?>
</div>

<script type="text/javascript">
marqueeInit({
	uniqueid: 'mycrawler2',
	style: {
		'padding': '2px',
		'background': '#FFF',
		'height': '50px'
	},
	inc: 5, //speed - pixel increment for each iteration of this marquee's movement
	mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
	moveatleast: 2,
	neutral: 150,
	savedirection: true,
	random: true
});
</script>