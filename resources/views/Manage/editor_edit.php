<?=$header?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-push-2" id="mainWindow">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 编辑管理员
						</div>
						<div class="panel-body">
							<form class="form-horizontal">
								<div class="form-group">
									<label for="username" class="col-sm-2 control-label">*&nbsp;登录ID</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="username" name="username" placeholder="登录ID" value="<?=$data['username']?>" readonly>
										<input type="hidden" id="id" name="id" value="<?=$data['id']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">登录密码</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="password" name="password" placeholder="如不更改，请留空。" value="" >
									</div>
								</div>
								<div class="form-group">
									<label for="realname" class="col-sm-2 control-label">*&nbsp;真实姓名</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="realname" name="realname" placeholder="真实姓名" value="<?=$data['realname']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="lastlogin" class="col-sm-2 control-label">最后登录</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="lastlogin" name="lastlogin" placeholder="最后登录" value="<?=date('Y-m-d H:i:s', $data['lastlogin'])?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="loginip" class="col-sm-2 control-label">最后登录ip</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="loginip" name="loginip" placeholder="最后登录ip" value="<?=$data['loginip']?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="level" class="col-sm-2 control-label">*&nbsp;权限</label>
									<div class="col-sm-10">
										<select class="form-control" id="level" name="level">
											<option value="1" <?if ($data['level'] == 1) {?> selected<?}?>>管理员</option>
											<option value="2" <?if ($data['level'] == 2) {?> selected<?}?>>编辑</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12 text-center">
										<div class="btn-group" role="group">
											<button type="button" class="btn btn-primary" id="submitbtn">更新</button>
											<a href="javascript:history.go(-1);" class="btn btn-default">取消</a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--左侧菜单-->
				<div class="col-sm-2 col-sm-pull-10">
				<?=$menu?>
				</div>
			</div>
		</div>
		<?=$footer?>
		<script src="/js/manage/page.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				Strea = new Tools();
				Strea.baseUrl = '/editor';
				Strea.setMenu('editor/list');
				$('#submitbtn').on('click', function () {
					edit();
				});
			});
			function edit () {
				data = Strea.getFormData('mainWindow');
				Strea.subForm('/dealedit', data);
			}
		</script>
	</body>
</html>