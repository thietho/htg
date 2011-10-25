<?php
class ControllerPageDetail extends Controller
{
	function __construct() 
	{
		$this->iscache = true;
		$arr=array();
		foreach($_GET as $key => $val)
			$arr[] = $key."=".$val;
	 	$this->name ="Pagedetail_".implode("_",$arr);
   	}
	public function index()
	{
		if($this->cachehtml->iscacht($this->name) == false)
		{
			$this->load->model("core/sitemap");
			$this->document->sitemapid = $this->request->get['sitemapid'];
			$siteid = $this->member->getSiteId();
			
			
			$id = $this->request->get['id'];
			
			$this->document->breadcrumb = $this->model_core_sitemap->getBreadcrumb($this->document->sitemapid, $siteid, -1);
			
			if($this->document->sitemapid != "")
			{
				$sitemap = $this->model_core_sitemap->getItem($this->document->sitemapid, $siteid);
				
				switch($sitemap['moduleid'])
				{
					case "":
						$this->data['module'] = $this->loadModule('addon/'.$this->document->sitemapid);
					break;
					case "module/information":
						$this->data['module'] = $this->loadModule('module/information');
					break;
					case "module/location":
						$this->data['module'] = $this->loadModule('module/location');
					break;
					case "module/banner":
						if($id == "")
						{
							$template = array(
											  'template' => "module/news_list.tpl",
											  'width' => 180,
											  'height' =>180
											  );
							$arr = array("",10,"",$template);
							
							$this->data['module'] = $this->loadModule('module/pagelist','getList',$arr);
						}
						else
						{
							$template = array(
										  'template' => "module/banner_detail.tpl",
										  'width' => 176,
										  'height' =>176
										  );
							$arr = array("",8,$template);
							$this->data['module'] = $this->loadModule('module/pagedetail','getForm',$arr);
						}
					break;
					case "module/news":
						if($id == "")
						{
							$template = array(
											  'template' => "module/news_list.tpl",
											  'width' => 180,
											  'height' =>180
											  );
							$arr = array("",10,"",$template);
							
							$this->data['module'] = $this->loadModule('module/pagelist','getList',$arr);
						}
						else
						{
							$template = array(
										  'template' => "module/news_detail.tpl",
										  'width' => 176,
										  'height' =>176
										  );
							$arr = array("",8,$template);
							$this->data['module'] = $this->loadModule('module/pagedetail','getForm',$arr);
						}
					break;
					case "module/video":
						if($id == "")
						{
							$template = array(
											  'template' => "module/news_list.tpl",
											  'width' => 180,
											  'height' =>180
											  );
							$arr = array("",10,"",$template);
							
							$this->data['module'] = $this->loadModule('module/pagelist','getList',$arr);
						}
						else
						{
							$template = array(
										  'template' => "module/video_detail.tpl",
										  'width' => 176,
										  'height' =>176
										  );
							$arr = array("",8,$template);
							$this->data['module'] = $this->loadModule('module/pagedetail','getForm',$arr);
						}
					break;
					case "module/product":
					
						if($id == "")
						{
							$template = array(
											  'template' => "module/product_list.tpl",
											  'width' => 170,
											  'height' =>170
											  );
							$arr = array($this->document->sitemapid,9,"",$template);
							$this->data['module'] = $this->loadModule('module/productlist','index',$arr);
	
						}
						else
						{
							$template = array(
										  'template' => "module/product_detail.tpl",
										  'width' => 250,
										  'height' =>250
										  );
							$arr = array($this->document->sitemapid,12,$template);
							$this->data['module'] = $this->loadModule('module/pagedetail','getFormProduct',$arr);
						}
					break;
					case "module/album":
					case "group":
						if($id == "")
						{
							$template = array(
											  'template' => "module/album_list.tpl",
											  'width' => 170,
											  'height' =>170
											  );
							$arr = array($this->document->sitemapid,12,"",$template);
							$this->data['module'] = $this->loadModule('module/productlist','index',$arr);
	
						}
						else
						{
							$template = array(
										  'template' => "module/album_detail.tpl",
										  'width' => 654,
										  'height' =>654
										  );
							$arr = array($this->document->sitemapid,12,$template);
							$this->data['module'] = $this->loadModule('module/pagedetail','getFormProduct',$arr);
						}
					break;
					case "module/contact":
						$this->data['module'] = $this->loadModule('module/contact');
					break;
				}
			}
			
			$this->loadSiteBar();
		}
		$this->id="content";
		$this->template="page/detail.tpl";
		$this->layout="layout/home";
		$this->render();
	}
	
	private function loadSiteBar()
	{
		//Left sitebar
		/*$arr = array('sanpham');
		$this->data['leftsitebar']['produtcategory'] = $this->loadModule('sitebar/catalogue','index',$arr);
		$this->data['leftsitebar']['supportonline'] = $this->loadModule('sitebar/supportonline');
		$this->data['leftsitebar']['exchange'] = $this->loadModule('sitebar/exchange');
		$this->data['leftsitebar']['weblink'] = $this->loadModule('sitebar/weblink');
		$this->data['leftsitebar']['hitcounter'] = $this->loadModule('sitebar/hitcounter');*/
		
		//Rigth sitebar
		$template = array(
					  'template' => "sitebar/congtrinhhome.tpl",
					  'width' => 100,
					  'height' =>100
					  );
		$arr = array("sanpham",$template);
		$this->data['rightsitebar']['sanpham'] = $this->loadModule('sitebar/sitemap','index',$arr);
		
		$template = array(
					  'template' => "sitebar/news.tpl",
					  'width' => 100,
					  'height' =>100
					  );
		$arr = array("tintuc",5,"",$template);
		$this->data['rightsitebar']['tintuc'] = $this->loadModule('sitebar/news','index',$arr);
		
		$template = array(
					  'template' => "sitebar/news.tpl",
					  'width' => 100,
					  'height' =>100
					  );
		$arr = array("congtrinhthucte",5,"",$template);
		$this->data['rightsitebar']['congtrinhthucte'] = $this->loadModule('sitebar/news','index',$arr);
	}
}
?>