<?php
class ControllerModuleProductlist extends Controller
{
	public function index($sitemapid="", $count = 0,$headername ="", $template = array(),$medias=array())
	{
		
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->model("core/category");
		$this->load->helper('image');
		
		$this->data['statuspro'] = array();
		$this->model_core_category->getTree("status",$this->data['statuspro']);
		unset($this->data['statuspro'][0]);
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		
		$siteid = $this->user->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		$this->data['sitemap']['breadcrumb'] = $this->model_core_sitemap->getBreadcrumb($sitemapid, $siteid);
		if($headername!="")
			$this->data['sitemap']['sitemapname'] = $headername;
		$this->document->title .= " - ".$this->data['sitemap']['sitemapname'];
		
		$step = (int)$this->request->get['step'];
		$to = $count;
		//
		$arrsitemap = array();
		$this->model_core_sitemap->getTreeSitemapEdit($sitemapid, "", $arrsitemap, $siteid);
		//print_r($arrsitemap);
		$arrsitemapid = $this->string->matrixToArray($arrsitemap,"sitemapid");
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		
		$queryoptions['refersitemap'] = $arrsitemapid;
		
		if($mediaid == "")
		{
			if(count($medias)==0)
			{
				//$medias = $this->model_core_media->getPaginationList($queryoptions, $step, $to);
				$medias = $this->model_core_media->getPaginationList($queryoptions);
			}
			
			
			$this->data['medias'] = array();
			
		
			$index = -1;
			//Page
			$page = $this->request->get['page'];		
			$x=$page;		
			$limit = $to;
			$total = count($medias); 
			$uri = "site/".$siteid."/".$sitemapid."/";
			// work out the pager values 
			$this->data['pager']  = $this->pager->pageLayoutWeb($total, $limit, $page,$uri); 
			
			$pager  = $this->pager->getPagerData($total, $limit, $page); 
			$offset = $pager->offset; 
			$limit  = $pager->limit; 
			$page   = $pager->page;
			for($i=$offset;$i < $offset + $limit && count($medias[$i])>0;$i++)
			//foreach($medias as $media)
			{
				$index += 1;
				$media = $medias[$i];
				
				$arr = $this->string->referSiteMapToArray($media['refersitemap']);
				$sitemapid = $arr[0];
				
				$link = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$media['mediaid'];
				
				$imagethumbnail = "";
				
				if($media['imagepath'] != "" )
				{
					$imagethumbnail = HelperImage::resizePNG($media['imagepath'], $template['width'], $template['height']);
					$imagetpreview = HelperImage::resizePNG($media['imagepath'], $template['widthpreview'], $template['heightpreview']);
				}
				
				$priceproduct = $this->model_core_media->getListByParent($media['mediaid']," AND mediatype = 'price' Order by position");
				$price = $media['price'];
				if($price == 0)
					$price = $priceproduct[0]['price'];
				$properties = $this->string->referSiteMapToArray($media['groupkeys']);
				$this->data['medias'][] = array(
					'mediaid' => $media['mediaid'],
					'title' => $media['title'.$this->document->getPrefix($this->member->getSiteId())],
					'summary' => $media['summary'.$this->document->getPrefix($this->member->getSiteId())],
					'price' => $price,
					'properties' => $properties,
					'imagethumbnail' => $imagethumbnail,
					'imagetpreview' => $imagetpreview,
					'fileid' => $media['imageid'],
					'statusdate' => $this->date->formatMySQLDate($media['statusdate'], 'longdate', "/"),
					'link' => $link
				);
				
			}
			
			
			
		}
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	
	}
	
	
	public function getAll($sitemapid="", $count = 0,$headername ="", $template = array(),$medias=array())
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$this->load->model("core/category");
		$this->load->helper('image');
		
		$this->data['statuspro'] = array();
		$this->model_core_category->getTree("status",$this->data['statuspro']);
		unset($this->data['statuspro'][0]);
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		
		$siteid = $this->user->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		$this->data['sitemap']['breadcrumb'] = $this->model_core_sitemap->getBreadcrumb($sitemapid, $siteid);
		if($headername!="")
			$this->data['sitemap']['sitemapname'] = $headername;
		$this->document->title .= " - ".$this->data['sitemap']['sitemapname'];
		
		$step = (int)$this->request->get['step'];
		$to = $count;
		
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		
		if($mediaid == "")
		{
			if(count($medias)==0)
			{
				//$medias = $this->model_core_media->getPaginationList($queryoptions, $step, $to);
				$medias = $this->model_core_media->getPaginationList($queryoptions);
			}
			
			
			$this->data['medias'] = array();
			
		
			$index = -1;
			/*//Page
			$page = $this->request->get['page'];		
			$x=$page;		
			$limit = $to;
			$total = count($medias); 
			$uri = "site/".$siteid."/".$sitemapid."/";
			// work out the pager values 
			$this->data['pager']  = $this->pager->pageLayoutWeb($total, $limit, $page,$uri); 
			
			$pager  = $this->pager->getPagerData($total, $limit, $page); 
			$offset = $pager->offset; 
			$limit  = $pager->limit; 
			$page   = $pager->page;
			for($i=$offset;$i < $offset + $limit && count($medias[$i])>0;$i++)*/
			foreach($medias as $media)
			{
				$index += 1;
				//$media = $medias[$i];
				
				$arr = $this->string->referSiteMapToArray($media['refersitemap']);
				$sitemapid = $arr[0];
				
				$link = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$media['mediaid'];
				
				$imagethumbnail = "";
				
				if($media['imagepath'] != "" )
				{
					$imagethumbnail = HelperImage::resizePNG($media['imagepath'], $template['width'], $template['height']);
					$imagetpreview = HelperImage::resizePNG($media['imagepath'], $template['widthpreview'], $template['heightpreview']);
				}
				
				$priceproduct = $this->model_core_media->getListByParent($media['mediaid']," AND mediatype = 'price' Order by position");
				$price = $media['price'];
				if($price == 0)
					$price = $priceproduct[0]['price'];
				$properties = $this->string->referSiteMapToArray($media['groupkeys']);
				$this->data['medias'][] = array(
					'mediaid' => $media['mediaid'],
					'title' => $media['title'.$this->document->getPrefix($this->member->getSiteId())],
					'summary' => $media['summary'.$this->document->getPrefix($this->member->getSiteId())],
					'price' => $price,
					'properties' => $properties,
					'imagethumbnail' => $imagethumbnail,
					'imagetpreview' => $imagetpreview,
					'fileid' => $media['imageid'],
					'statusdate' => $this->date->formatMySQLDate($media['statusdate'], 'longdate', "/"),
					'link' => $link
				);
				
			}
			//print_r($this->data['medias']);
			
			
		}
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	}
}
?>