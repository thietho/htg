
<div class="ben-section">

	<div class="ben-section-title">
    	<?php echo $sitemap['sitemapname']?>
    </div>
    
    <div class="ben-section-content">
    	<table>
        	<?php foreach($childs as $item) {?>
        	<tr>
            	
                <td><h4><a href="<?php echo HTTP_SERVER?>site/<?php echo $this->member->getSiteId()?>/<?php echo $item['sitemapid']?>"><?php echo $item['sitemapname']?></a></h4></td>
            </tr>
            <?php } ?>
        </table>
    	

           
   			
		
    	
    	
    </div>

</div>
