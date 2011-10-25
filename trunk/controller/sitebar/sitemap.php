<?php
class ControllerSitebarSitemap extends Controller
{
	public function index($sitemapid = "",$template = array(),$status = "Active")
	{
		$siteid = $this->member->getSiteId();
		$this->data['sitemap'] = $this->model_core_sitemap->getItem($sitemapid, $siteid);
		$this->data['childs'] = $this->model_core_sitemap->getListByParent($sitemapid, $siteid, $status);
		
		$this->id="content";
		$this->template=$template['template'];
		$this->render();
	}
}
?>