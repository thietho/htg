<?php if(count($medias)){ ?>
<div class="ben-section">

	<div class="ben-section-title">
    	<?php echo $sitemap['sitemapname']?>
    </div>
    
    <div class="ben-section-content">
    	<table>
        	<?php foreach($medias as $media) {?>
        	<tr>
            	<td width="50px">
                	 <?php if($media['imagethumbnail'] !=""){ ?>
                        
                        <a href="<?php echo $media['link']?>"><img src='<?php echo $media['imagethumbnail']?>' /></a>
                        
                    <?php }?>
                </td>
                <td><a href="<?php echo $media['link']?>"><?php echo $media['title']?></a></td>
            </tr>
            <?php } ?>
        </table>
    	

           
   			
		
    	
    	
    </div>

</div>
<?php } ?>