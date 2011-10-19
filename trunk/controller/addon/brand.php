<?php
class ControllerAddonBrand extends Controller
{
	private $error = array();
	public function index()
	{
		
		$this->getList();
		$this->id="content";
		$this->template="common/output.tpl";
		$this->render();
	}
	
	private function getList()
	{
		$this->load->model("core/media");
		$this->load->model("core/sitemap");
		$categoryid = $this->request->get['id'];
		$header = $this->document->getCategory($categoryid);
		$this->document->breadcrumb .= $header;
		$where = " AND groupkeys like '%[".$categoryid."]%'";
		$medias = $this->model_core_media->getList($where);
		
		if(count($listparent))
		{
			$data = array();
			foreach($medias as $key =>$item)
			{
				if(!in_array($item['mediaid'],$listparent))
				{
					unset($medias[$key]);	
				}
				else
				{
					$data[] = $item;	
				}
			}
			$medias = $data;
		}
		
		$template = array(
							  'template' => "module/product_list.tpl",
							  'width' => 176,
							  'height' =>176,
							  'widthpreview' => 450,
						 	  'heightpreview' =>450
							  );
		$arr = array("",12,$header,$template,$medias);
		$this->data['output'] = $this->loadModule('module/productlist','index',$arr);
			
			
	}
}
?>