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
	<body style="background-color:#333;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 col-md-push-4" style="margin-top:30px;">
					<div class="panel panel-primary">
						<div class="panel-heading text-center"><h4>登录</h4></div>
						<div class="panel-body">
							<form class="form-horizontal">
								<div class="form-group">
									<label for="username" class="col-sm-4 control-label"><span class="glyphicon glyphicon-user
" aria-hidden="true"></span>&nbsp;登录ID</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="username" name="username" placeholder="登录ID">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-4 control-label"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;登录密码</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" id="password" name="password" placeholder="登录密码">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12 text-center">
										<div class="btn-group" role="group">
											<button type="button" class="btn btn-primary" id="loginBtn">登录</button>
											<a href="javascript:window.location.href='http://www.bazaar.com.cn';" class="btn btn-default">取消</a>
										</div>
									</div>
								</div>
							</form>
							<div class="col-sm-12 text-center">
								<a href="javascript:void(0);" id="notice" data-placement="bottom" title="请咨询系统管理员更改密码！">忘记密码</a>
							</div>						
						</div>
					</div>
				</div>
			</div>
		</div>
		<?=$footer?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#notice').tooltip()
				$('#loginBtn').on('click', login);
			});
			function login () {
				uname = $('#username').val();
				pwd = $('#password').val();
				$.ajax({
					url: '/login/gologin',
					type: 'post',
					dataType: 'json',
					data: {uname: uname, pwd: pwd},
					success: function (msg) {
						if (msg.err == 0) {
							$('#resultMsg').html(msg.msg);
							$('#resultModal').find('.modal-footer').html('<a href="' + msg.url + '" class="btn btn-info" >确定</a>');
						} else {
							$('#resultMsg').html(msg.msg);
						}
						$('#resultModal').modal('show');
					}
				});
			}
		</script>
	</body>
</html>