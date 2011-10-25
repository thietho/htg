
<div class="ben-section">

	<div class="ben-section-title">
    	<?php echo $sitemap['sitemapname']?>
    </div>
    
    <div class="ben-section-content">
    	<table>
        	<?php foreach($childs as $item) {?>
        	<tr>
            	<td width="100px">
                	
                        
                        <a href="<?php echo HTTP_SERVER?>site/<?php echo $this->member->getSiteId()?>/<?php echo $item['sitemapid']?>"><img src="<?php echo HTTP_SERVER.DIR_IMAGE?>sitemap/<?php echo $item['sitemapid']?>.png" /></a>
                        
                    
                </td>
                <td><a href="<?php echo HTTP_SERVER?>site/<?php echo $this->member->getSiteId()?>/<?php echo $item['sitemapid']?>"><?php echo $item['sitemapname']?></a></td>
            </tr>
            <?php } ?>
        </table>
    	

           
   			
		
    	
    	
    </div>

</div>
