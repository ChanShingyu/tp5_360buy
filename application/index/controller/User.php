<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class User extends Controller
{
    //存储用户信息
    protected  $userInfo = null;
    protected $url = null;

    public function _initialize()
    {
        parent::_initialize();

        $this->assign([
            'current_url' => $_SERVER['REDIRECT_URL'],
        ]);

        $this->url = config('api_url');//请求接口的域名地址

        //y验证登录
        if(empty($this->userInfo)){
            return $this->redirect('/index/login/login');
        }
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

        $data = httpCurl($this->url.'/api/user/info/'.$this->userInfo['id'], 'post');

        $this->assign([
            'user' => $data['data']
        ]);

        return $this->fetch('index');
    }

    //保存用户的信息
    public function saveUser(Request $request)
    {
        $params = $request->param();//其你去过来的参数

        //dump($params);exit;

        $res = httpCurl($this->url."/api/user/modify","post",$params);

        // dump($res);exit;

        return $this->redirect('/index/user/index');
    }

    //订单页面
    public function order()
    {
        $data = httpCurl($this->url."/api/user/order/".$this->userInfo['id'],"post");


        $this->assign([
            'orders'=>$data['data']
        ]);
        return $this->fetch('order');
    }

    //用户红包记录页面
    public function bonus()
    {
        $userId = $this->userInfo['id'];

        $bonus = httpCurl($this->url."/api/user/bonus/".$userId, "post");

        // dump($bonus);

        $this->assign([
            'user_bonus' => $bonus['data']
        ]);

        return $this->fetch('bonus');
    }

    //资金流水
    public function fundHistory()
    {
        $userId = $this->userInfo['id'];

        $fund = httpCurl($this->url."/api/user/fund/".$userId, "post");

        $this->assign([
            'fund_history' => $fund['data']
        ]);
        return $this->fetch('fund');
    }

    //收货地址列表
    public function addressList()
    {
        $userId = $this->userInfo['id'];

        $address = httpCurl($this->url."/api/user/address/list/".$userId, "post");


        $this->assign([
            'address' => $address['data']
        ]);
        return $this->fetch('addressList');
    }

    //收货地址添加
    public function address()
    {
        $data = httpCurl($this->url.'/api/user/info/'.$this->userInfo['id'], 'post');

        $this->assign([
            'user' => $data['data']
        ]);

        return $this->fetch('address');
    }

    //保存地址信息
    public function saveAddress(Request $request)
    {
        $params = $request->param();//其你去过来的参数

        $res = httpCurl($this->url.'/api/user/address/add', 'post', $params);


        return $this->redirect('/index/user/addressList');
    }
    //设置默认地址
    public function setDefaultAddress(Request $request)
    {
        $params = $request->param();

        //当前登录的用户id
        $params['user_id'] = $this->userInfo['id'];

        httpCurl($this->url."/api/set/default/address","post",$params);

        return $this->redirect('/index/user/addressList');
    }
}
