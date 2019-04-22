<?php 
 namespace app\index\controller;

 use think\Controller;
 use think\Request;

 class Detail extends Controller{
 	public function index(Request $request){
 		$params = $request->param();

 		$url = config('api_url');//请求接口的域名地址
 		//请求首页的分类接口
 		$category = httpCurl($url."/api/home/category",'post');
 		//品牌列表
 		$brands = httpCurl($url."/api/home/brands",'post',['nums' =>9]);
 		//商品详情信息接口
 		$goods = httpCurl($url."/api/home/detail/".$params['id'],'post');
 		//

 		$this->assign([
 				'category'	=>$category['data'],
 				'brands'	=>$brands['data'],
 				'goods'		=>$goods['data']['goods'],
 				'gallery'	=>$goods['data']['gallery'],
 				'spu'		=>$goods['data']['spu'],
 				'sku'		=>$goods['data']['sku']
 			]);
 		return $this->fetch('index');
 	}
 }











 ?>