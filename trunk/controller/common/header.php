<?php
class ControllerCommonHeader extends Controller
{
	public function index()
	{
		$this->load->model("core/media");
		
		$where = " AND groupkeys like '%[sanphamhot]%'";
		$medias = $this->model_core_media->getList($where);
		
		$template = array(
							  'template' => "common/product.tpl",
							  'width' => 0,
							  'height' =>150
							  
							  );
		$arr = array("",12,"",$template,$medias);
		$this->data['products'] = $this->loadModule('module/productlist','getAll',$arr);
		
		$this->id="header";
		$this->template="common/header.tpl";
		$this->data['mainmenu'] = $this->getMenu("");
		$this->render();
	}
	
	public function getMenu($parentid)
	{
		$this->load->model("core/sitemap");
		
		$siteid = $this->member->getSiteId();
		
		$rootid = $this->model_core_sitemap->getRoot($this->document->sitemapid, $siteid);

		if($this->document->sitemapid == "")
			$rootid = 'trangchu';
		$str = "";
		
		
		$sitemaps = $this->model_core_sitemap->getListByParent($parentid, $siteid);
		
		foreach($sitemaps as $item)
		{
			$childs = $this->model_core_sitemap->getListByParent($item['sitemapid'], $siteid);
			
			$currenttab = "";
			if($item['sitemapid'] == $rootid) 
				$currenttab = "class='current-tab'";
			
			$link = "<a ".$currenttab.">".$item['sitemapname']."</a>";
			
			if($item['moduleid'] != "group")
			{
				//$link = "<a ".$currenttab." href='index.php?route=page/detail&sitemapid=".$item['sitemapid']."'>".$item['sitemapname']."</a>";
				$link = "<a ".$currenttab." href='".HTTP_SERVER."site/".$siteid."/".$item['sitemapid']."'>".$item['sitemapname']."</a>";
			}
			if($item['moduleid'] == "homepage"){
				$link = "<a ".$currenttab." href='".HTTP_SERVER."'>".$item['sitemapname']."</a>";
			}
			
			$str .= "<li>";
			$str .= $link;
			
			if(count($childs) > 0)
			{
				$str .= "<ul>";
				$str .= $this->getMenu($item['sitemapid']);
				$str .= "</ul>";
			}

			$str .= "</li>";
		}
		
		return $str;
		
	}
}
?>