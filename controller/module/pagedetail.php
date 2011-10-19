<?php
class ControllerModulePagedetail extends Controller
{	
	public function getForm($sitemapid="",$count=8, $template = array(),$media=array())
	{
		$this->load->model("core/media");
		$this->load->helper('image');
		
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		$mediaid = $this->request->get['id'];
		$siteid = $this->member->getSiteId();
		
		$this->data['post'] = $this->model_core_media->getItem($mediaid);
		$this->document->title .= " - ".$this->data['post']['title'];
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		
		if($this->data['post']['imagepath'] != "")
		{
			$this->data['post']['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], $template['width'], $template['height']);
		}
		
		//Get list
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$queryoptions['refersitemap'] = $sitemapid;
		$queryoptions['date'] = $this->data['post']['statusdate'];
		$this->data['othernews'] = $this->model_core_media->getOthersMedia($mediaid, $queryoptions, $count);
		for($i=0;$i<count($this->data['othernews']);$i++)
		{
			$link = HTTP_SERVER."site/".$siteid."/".$sitemapid."/".$this->data['othernews'][$i]['mediaid'];
			$this->data['othernews'][$i]['link'] = $link;
		}
		
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	}
	
	public function getFormProduct($sitemapid="",$count=8, $template = array(),$media=array())
	{
		$this->load->model("core/media");
		$this->load->model("core/category");
		$this->load->model("core/sitemap");
		$this->load->helper('image');
		
		$this->data['nhomhuong'] = array();
		$this->model_core_category->getTree("nhomhuong",$this->data['nhomhuong']);
		unset($this->data['nhomhuong'][0]);
		
		$this->data['nhanhieu'] = array();
		$this->model_core_category->getTree("nhanhieu",$this->data['nhanhieu']);
		unset($this->data['nhanhieu'][0]);
		
		$this->data['statuspro'] = array();
		$this->model_core_category->getTree("status",$this->data['statuspro']);
		unset($this->data['statuspro'][0]);
		
		if($sitemapid == "")
			$sitemapid = $this->document->sitemapid;
		$mediaid = $this->request->get['id'];
		$siteid = $this->member->getSiteId();
		
		$this->data['post'] = $this->model_core_media->getItem($mediaid);
		$this->document->title .= " - ".$this->data['post']['title'];
		if(count($this->data['post']) == 0)
		{
			$this->data['post']['description'] = "Updating...";
		}
		$this->data['post']['summary'] = str_replace(chr(13),"<br>",$this->data['post']['summary']);
		$this->data['post']['description'] = html_entity_decode($this->data['post']['description']);
		
		$loaisp= $this->string->referSiteMapToArray($this->data['post']['refersitemap']);
		foreach($loaisp as $item)
		{
			$this->data['loaisp'][] = $this->model_core_sitemap->getItem($item,$this->member->getSiteId());
		}
		
		if($this->data['post']['imagepath'] != "")
		{
			$this->data['post']['imagethumbnail'] = HelperImage::resizePNG($this->data['post']['imagepath'], $template['width'], $template['height']);
		}
		$this->data['properties'] = $this->string->referSiteMapToArray($this->data['post']['groupkeys']);
		
		//Get sub attachment
		$listfile = $this->model_core_media->getInformation($mediaid, "attachment");
		$listfileid=array();
		if($listfile)
			$listfileid=split(",",$listfile);
			
		array_unshift($listfileid,$this->data['post']['imageid']);
		
		$this->data['subimage']=array();
		$this->data['attachment']=array();
		
		foreach($listfileid as $key => $item)
		{
			$file = $this->model_core_file->getFile($item);
			if($this->string->isImage($file['extension']))
			{
				$this->data['subimage'][$key] = $file;
				$this->data['subimage'][$key]['imagethumbnail'] = HelperImage::resizePNG($file['filepath'], 50, 50);	
				$this->data['subimage'][$key]['imagepreview'] = HelperImage::resizePNG($file['filepath'],  $template['width'], $template['height']);
			}
			
			if(!$this->string->isImage($file['extension']))
			{
				$this->data['attachment'][$key] = $file;
				$this->data['attachment'][$key]['imagethumbnail'] = DIR_IMAGE."icon/dinhkem.png";
			}
			
		}
		//Get sub infomation
		
		$this->data['child'] = $this->model_core_media->getListByParent($mediaid," AND mediatype = 'subinfor' Order by position");
		foreach($this->data['child'] as $key => $item)
		{
			$this->data['child'][$key]['imagepreview'] = "<img width=100 src='".HelperImage::resizePNG($item['imagepath'], $template['width'], $template['height'])."' >";
		}
		
		$this->data['priceproduct'] = $this->model_core_media->getListByParent($mediaid," AND mediatype = 'price' Order by position");
		foreach($this->data['priceproduct'] as $key => $item)
		{
			$para = $this->string->referSiteMapToArray($item['summary']);
			foreach($para as $val)
			{
				$ar = split("=",$val);
				$this->data['priceproduct'][$key][$ar[0]] = $ar[1];	
			}
			
		}
		
		
		
		$this->id="news";
		$this->template=$template['template'];
		$this->render();
	}
}
?>