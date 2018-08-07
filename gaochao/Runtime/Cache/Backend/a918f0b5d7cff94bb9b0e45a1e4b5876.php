<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<?php  ?>
<?php
 if(isset($title)){ $title=$title.' | '.C('SITE_TITLE'); }else{ $title=C('SITE_TITLE'); } if(!isset($keywords)){ $keywords=C('SITE_KEYWORD'); } if(!isset($description)){ $description=C('SITE_DESCRIPTION'); } ?>
<title><?=$title?></title>
<meta name="keywords" content="<?=$keywords?>" />
<meta name="description" content="<?=$description?>" />
<script>
var _ROOT_='/gaochao';
var _STATIC_='/gaochao/Public/Static';
var _PLUGIN_='/gaochao/Public/Plugins';
var _JS_='/gaochao/Public/Backend/js';
var _IMG_='/gaochao/Public/Backend/img';
var _CSS_='/gaochao/Public/Backend/css';
</script>
<link rel="stylesheet" type="text/css" href="/gaochao/Public/Static/css/common.css?1518508939" />
<link rel="stylesheet" type="text/css" href="/gaochao/Public/Backend/css/login.css?1518508931" />
</head>
<body class="login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="http://www.cnsunrun.com" target="_blank"><img src="/gaochao/Public/Backend/img/login_logo.png"></a>
		</div>
		<div class="login-box-body">
			<form action="<?=U('Backend/Base/Public/login')?>" class="js_form" func="Login" method="post" tipmsg="验证通过">
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="请输入您的账号" datatype="*" nullmsg="请输入您的账号" />
					<div class="icon icon_user"></div>
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="请输入您的密码" datatype="*" nullmsg="请输入您的密码" />
					<div class="icon icon_lock"></div>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" name="code" placeholder="输入验证码" datatype="*" nullmsg="请输入验证码" />
					<div class="icon icon_code"></div>
				</div>
				<div class="form-group">
					<img class="verifyimg js_verifyimg" src="<?=U('Backend/Base/Public/verify')?>" height="60">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-block btn-primary" value="登录" />
				</div>
				<div class="validTips js_validTips"><span class="js_tipContent Validform_checktip"></span></div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="/gaochao/Public/Static/js/common.js?1518508939"></script>
	<script type="text/javascript" src="/gaochao/Public/Backend/js/login.js?1518508938"></script>
</body>
</html>