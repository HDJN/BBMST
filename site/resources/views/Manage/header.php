<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="GBK">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Basic Background Management System Template</title>

		<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/css/manage/style.css">

		<!--[if lt IE 9]>
			<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">展开</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="http://www.bazaar.com.cn" target="_blank">Site</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="/product/list">产品管理</a></li>
						<li><a href="/brand/list">品牌管理</a></li>
						<li><a href="https://github.com/EvilCult">项目主页</a></li>
						<li><a href="#">其它</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">更多 <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/editor/list">成员设置</a></li>
								<li><a href="/editor/info/" target="_blank">个人设置</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="/login/out">退出</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>