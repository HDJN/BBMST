<?=$header?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-push-2" id="mainWindow">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 添加管理员
						</div>
						<div class="panel-body">
							<form class="form-horizontal">
								<div class="form-group">
									<label for="username" class="col-sm-2 control-label">*&nbsp;登录ID</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="username" name="username" placeholder="登录ID">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">*&nbsp;登录密码</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="password" name="password" placeholder="登录密码">
									</div>
								</div>
								<div class="form-group">
									<label for="realname" class="col-sm-2 control-label">*&nbsp;真实姓名</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="realname" name="realname" placeholder="真实姓名">
									</div>
								</div>
								<div class="form-group">
									<label for="level" class="col-sm-2 control-label">*&nbsp;权限</label>
									<div class="col-sm-10">
										<select class="form-control" id="level" name="level">
											<option value="1">管理员</option>
											<option value="2" selected>编辑</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12 text-center">
										<div class="btn-group" role="group">
											<button type="button" class="btn btn-primary" id="submitbtn">添加</button>
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
				Strea.setMenu('editor/add');
				$('#submitbtn').on('click', function () {
					add();
				});
			});
			function add () {
				data = Strea.getFormData('mainWindow');
				Strea.subForm('/dealadd', data);
			}
		</script>
	</body>
</html>