<?php
class ControllerPageHome extends Controller
{
	function __construct() 
	{
		//$this->iscache = true;
		$arr=array();
		foreach($_GET as $key => $val)
			$arr[] = $key."=".$val;
	 	$this->name ="PageHome".implode("_",$arr);
   	}
	public function index()
	{
		if($this->cachehtml->iscacht($this->name) == false)
		{
			//Banner home
			/*$template = array(
						  'template' => "home/banner.tpl",
						  'width' => 548,
						  'height' =>548
						  );
		
			$arr = array("bannerhome",0,"",$template);
			$this->data['bannerhome'] = $this->loadModule('module/block','getList',$arr);
			//San pham moi
			$template = array(
						  'template' => "home/product.tpl",
						  'width' => 170,
						  'height' =>170
						  );
			
			$medias = $this->getProduct();
			
			$arr = array("",6,"",$template,$medias);
			$this->data['producthome'] = $this->loadModule('module/productlist','index',$arr);*/
			
			/*$arr = array("gioithieu");
			$this->data['producthome'] = $this->loadModule('module/information','index',$arr);*/
			//
			$template = array(
											  'template' => "module/news_list.tpl",
											  'width' => 180,
											  'height' =>180
											  );
			$arr = array("event",10,"",$template);
			
			$this->data['producthome'] = $this->loadModule('module/pagelist','getList',$arr);
			
			
			$this->loadSiteBar();
			
		}
		
		$this->id="content";
		$this->template="page/home.tpl";
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
					  'width' => 70,
					  'height' =>70
					  );
		$arr = array("sanpham",$template);
		$this->data['rightsitebar']['sanpham'] = $this->loadModule('sitebar/sitemap','index',$arr);
		
		$template = array(
					  'template' => "sitebar/news.tpl",
					  'width' => 70,
					  'height' =>70
					  );
		$arr = array("tintuc",5,"",$template);
		$this->data['rightsitebar']['tintuc'] = $this->loadModule('sitebar/news','index',$arr);
		
		$template = array(
					  'template' => "sitebar/news.tpl",
					  'width' => 70,
					  'height' =>70
					  );
		$arr = array("congtrinhthucte",5,"",$template);
		$this->data['rightsitebar']['congtrinhthucte'] = $this->loadModule('sitebar/news','index',$arr);
		
		/*$this->data['rightsitebar']['login'] = $this->loadModule('sitebar/login');
		$this->data['rightsitebar']['search'] = $this->loadModule('sitebar/search');
		$this->data['rightsitebar']['cart'] = $this->loadModule('sitebar/cart');
		$this->data['rightsitebar']['banner'] = $this->loadModule('sitebar/banner');
		$this->data['rightsitebar']['question'] = $this->loadModule('sitebar/question');*/
	}
	
	function getProduct()
	{
		$this->load->model('core/sitemap');
		$this->load->model('core/media');
		$siteid = $this->member->getSiteId();
		$sitemaps = $this->model_core_sitemap->getListByModule("module/product", $siteid);
		$arrsitemapid = $this->string->matrixToArray($sitemaps,"sitemapid");
		$queryoptions = array();
		$queryoptions['mediaparent'] = '%';
		$queryoptions['mediatype'] = '%';
		$options['refersitemap'] = $arrsitemapid;
		$data = $this->model_core_media->getPaginationList($options, $step=0, $to=9);
		
		return $data;
	}
}
?>