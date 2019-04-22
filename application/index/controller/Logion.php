<?php 
 namespace app\index\controller;

 use think\Controller;
 use think\Request;

 class Login extends Controller{
 	public function register(){
 		return $this->fetch('register');
 	}
 	//登陆
 	public function login(){
 		return $this->fetch('login');
 	}
 }




 ?>