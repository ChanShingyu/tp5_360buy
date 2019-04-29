<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"E:\wamp64\www\tp5_360buy\public/../application/index\view\login\register.html";i:1556508001;s:58:"E:\wamp64\www\tp5_360buy\application\index\view\login.html";i:1555930632;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>用户注册</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/login.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<!-- 登录主体部分start -->
	
<style type="text/css">
	.button {
	    background-color: #008CBA; /* Green */
	    border: none;
	    color: white;
	    padding: 5px 10px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 15px;
	    border-radius: 4px;
    }
    .disabled{
    	background-color: #e7e7e7; 
    	color: black;
    }
</style>
<div class="login w990 bc mt10 regist">
		<div class="login_hd">
			<h2>用户注册</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl" id="register">
				<form action="" method="post" onsubmit="return false;">
					<ul>
						<li>
							<label for="">手机号：</label>
							<input type="text" class="txt" name="phone" />
							<p>11位数的手机号</p>
						</li>
						<li>
							<label for="">密码：</label>
							<input type="password" class="txt" name="password" />
							<p>6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
						</li>
						<li>
							<label for="">确认密码：</label>
							<input type="password" class="txt" name="confirm_password" />
							<p> <span>请再次输入密码</p>
						</li>
						<li class="checkcode">
							<label for="">验证码：</label>
							<input type="text"  name="code" />
							<button :class="class1"  @click="countDown" :disabled="disabled">{{content}}</button>
						</li>

						<li class="checkcode">
							<label for="">邀请码：</label>
							<input type="text"  name="invite_code" />
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="checkbox" class="chb" checked="checked" /> 我已阅读并同意《用户注册协议》
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="submit" value="" class="login_btn" @click="register"/>
						</li>
					</ul>
				</form>

				
			</div>
			


		</div>
	</div>
	<script type="text/javascript" src="/js/vue.js"></script>
	<script type="text/javascript">
		var register = new Vue({
			el: "#register",
			data: {
				totalTime:60,
				content: "发送验证码",
				disabled: false,
				class1: "button",
			},
			methods:{
				//减少+发送短信验证码
				countDown() {

					//手机号
					var phone  = $("input[name=phone]").val();

					var password = $("input[name=password]").val();

					var confirm_password = $("input[name=confirm_password]").val();

					var parttern = /^1[34578]\d{9}$/;

					if(phone == ''){
						alert('手机号不能为空');
						return false;
					}
					//手机号校验
					if(!(parttern.test(phone))){
						alert('手机号格式不正确');
						return false;
					}

					if(password == ''){
						alert('密码不能为空');
						return false;
					}

					if(confirm_password != password){
						alert('密码不一致');
						return false;
					}

 					var that = this;

 					$.ajax({
 						url: "http://www.admin.com/api/login/sendSms",
 						type: "post",
 						data: {phone:phone},
 						dataType: "json",
 						success: function(res){

 							if(res.code == 2000){
								that.content = that.totalTime + 's后重新发送' //这里解决60秒不见了的问题
			    				that.disabled = true;
			    				that.class1  = "button disabled";
			 					let clock = window.setInterval(() => {
			  						that.totalTime--
			  						that.content = that.totalTime + 's后重新发送'
			  					if (that.totalTime < 0) {     //当倒计时小于0时清除定时器
			   					 	window.clearInterval(clock);
			    					that.content = '发送验证码';
			    					that.totalTime = 60;
			    					that.disabled = false;
			    					that.class1  = "button";
			    					}
			 					},1000);
 							}else{
 								alert(res.msg);
 								return false;
 							}

 						}
 					})
  				},

  				//注册的功能
  				register: function(){
  					var phone  = $("input[name=phone]").val();

					var password = $("input[name=password]").val();

					var confirm_password = $("input[name=confirm_password]").val();
					var code = $("input[name=code]").val();
					var invite_code = $("input[name=invite_code]").val();

					var that = this;

					$.ajax({
 						url: "http://www.admin.com/api/register",
 						type: "post",
 						data: {phone:phone, password:password, code:code, invite_code:invite_code},
 						dataType: "json",
 						success: function(res){

 							if(res.code == 2000){
								alert('注册成功');
 							}else{
 								alert(res.msg);
 								return false;
 							}

 						}
 					})
  				}
			}
		})
	</script>

	<!-- 登录主体部分end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="images/xin.png" alt="" /></a>
			<a href=""><img src="images/kexin.jpg" alt="" /></a>
			<a href=""><img src="images/police.jpg" alt="" /></a>
			<a href=""><img src="images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

</body>
</html>