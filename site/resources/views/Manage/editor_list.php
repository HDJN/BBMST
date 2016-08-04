<?=$header?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-push-2" id="mainWindow">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 管理员列表
						</div>
						<div class="panel-body">
							<!--搜索排序功能-->
							<div class="row">
								<div class="col-xs-12 col-md-6 searchGroup">
									<div class="input-group">
										<div class="input-group-btn">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$filter['st']?> <span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li><a href="jsvascript:void(0);" type="username">按登录ID</a></li>
												<li><a href="jsvascript:void(0);" type="realname">按真实姓名</a></li>
											</ul>
										</div>
										<input type="text" class="form-control" aria-label="keyword" placeholder="关键词..." value="<?=$filter['sk']?>">
										<span class="input-group-btn">
											<button class="btn btn-info searchBtn" type="button">Search</button>
										</span>
									</div>
								</div>
								<div class="col-xs-12 col-md-6">
									<div class="btn-group pull-right">
										<div class="btn-group statGroup">
											<button type="button" class="btn btn-info">状态:<?=$filter['stat']?></button>
											<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
												<li><a href="javascript:void(0);" type="online">线上</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="javascript:void(0);" type="del">已删除</a></li>
											</ul>
										</div>
										<div class="btn-group sortGroup">
											<button type="button" class="btn btn-info">排序:<?=$filter['sort']?></button>
											<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
												<li><a href="javascript:void(0);" type="add">添加</a></li>
												<li><a href="javascript:void(0);" type="lastlogin">最后登录</a></li>
												<li><a href="javascript:void(0);" type="username">按登录ID</a></li>
												<li><a href="javascript:void(0);" type="realname">按真实姓名</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<? if ($list) {?>
						<!--列表内容-->
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover table-condensed">
								<tr class="info">
									<th class="text-center">#</th>
									<th class="text-center">登录ID</th>
									<th class="text-center">真实姓名</th>
									<th class="text-center">最后登录</th>
									<th class="text-center">登录ip</th>
									<th class="text-center">操作</th>
								</tr>
								<?foreach ($list as $v) { ?>
								<tr class="text-center" id="listItem_<?=$v['id']?>">
									<td><?=$v['id']?></td>
									<td class="listItemTitle"><?=$v['username']?></td>
									<td><?=$v['realname']?></td>
									<td><?=date("Y-m-d H:i", $v['lastlogin'])?></td>
									<td><?=$v['loginip']?></td>
									<td>
										<a class="btn btn-info" href="/editor/info/<?=$v['id']?>">编辑</a>
										<?if ($v['isdel'] == 0) {?>
										<button class="btn btn-danger delBtn" type="button" rowid="<?=$v['id']?>">删除</button>
										<?}else{?>
										<button class="btn btn-success recBtn" type="button" rowid="<?=$v['id']?>">恢复</button>
										<?}?>
									</td>
								</tr>
								<?}?>
							</table>
						</div>
						<?} else {?>
						<div class="panel-body text-center"><h3>暂无结果...</h3></div>
						<?}?>
					</div>
					<!--分页-->
					<nav class="text-center">
						<ul class="pagination">
							<?=$page?>
						</ul>
					</nav>										
				</div>
				<!--左侧菜单-->
				<div class="col-sm-2 col-sm-pull-10">
				<?=$menu?>
				</div>
			</div>
		</div>
		<?=$footer?>
		<script src="/js/manage/page.js"></script>
	</body>
<script type="text/javascript">
$(document).ready(function(){
	Strea = new Tools();
	Strea.baseUrl = '/editor';
	Strea.sType = '<?=$request['st']?>';
	Strea.sKey = '<?=$request['sk']?>';
	Strea.stat = '<?=$request['stat']?>';
	Strea.sort = '<?=$request['sort']?>';
	Strea.setMenu('editor/list');
	Strea.listInit();
	Strea.delInit();
});
</script>

</html>