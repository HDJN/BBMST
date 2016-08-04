<?=$header?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-push-2" id="mainWindow">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 品牌列表
						</div>
						<div class="panel-body">
							<!--搜索排序功能-->
							<div class="row">
								<div class="col-xs-12 col-md-6 searchGroup">
									<div class="input-group">
										<div class="input-group-btn">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$filter['st']?> <span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li><a href="jsvascript:void(0);" type="namecn">按中文名</a></li>
												<li><a href="jsvascript:void(0);" type="nameen">按英文名</a></li>
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
												<li><a href="javascript:void(0);" type="update">最后更新</a></li>
												<li><a href="javascript:void(0);" type="namecn">中文名</a></li>
												<li><a href="javascript:void(0);" type="nameen">英文名</a></li>
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
									<th class="text-center">Logo</th>
									<th class="text-center">中文名</th>
									<th class="text-center">英文名</th>
									<th class="text-center">最后更新</th>
									<th class="text-center">操作</th>
								</tr>
								<?foreach ($list as $v) { ?>
								<tr class="text-center" id="listItem_<?=$v['id']?>">
									<td><?=$v['id']?></td>
									<td><img width="60px" src="<?=$v['logo']?>" alt="<?=$v['brand']?>" class="img-circle"></td>
									<td class="listItemTitle"><?=$v['brand']?></td>
									<td><?=$v['branden']?></td>
									<td><?=date("Y-m-d H:i", $v['timeupdate'])?></td>
									<td>
										<a class="btn btn-info" href="/brand/info/<?=$v['id']?>">编辑</a>
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
	Strea.baseUrl = '/brand';
	Strea.sType = '<?=$request['st']?>';
	Strea.sKey = '<?=$request['sk']?>';
	Strea.stat = '<?=$request['stat']?>';
	Strea.sort = '<?=$request['sort']?>';
	Strea.setMenu('brand/list');
	Strea.listInit();
	Strea.delInit();
	init();
});

</script>

</html>