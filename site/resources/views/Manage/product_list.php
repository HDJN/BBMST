<?=$header?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-push-2" id="mainWindow">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 产品列表
						</div>
						<div class="panel-body">
							<!--搜索排序功能-->
							<div class="row">
								<div class="col-xs-12 col-md-6 searchGroup">
									<div class="input-group">
										<div class="input-group-btn">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$filter['st']?> <span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li><a href="jsvascript:void(0);" type="title">按标题</a></li>
												<li><a href="jsvascript:void(0);" type="brand">按品牌</a></li>
												<li><a href="jsvascript:void(0);" type="tag">按标签</a></li>
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
												<li><a href="javascript:void(0);" type="all">全部</a></li>
												<li><a href="javascript:void(0);" type="online">已上线</a></li>
												<li><a href="javascript:void(0);" type="offline">待审核</a></li>
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
												<li><a href="javascript:void(0);" type="title">产品名称</a></li>
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
									<th class="text-center">预览</th>
									<th class="text-center">产品</th>
									<th class="text-center">热度</th>
									<th class="text-center">最后更新</th>
									<th class="text-center">状态</th>
									<th class="text-center">操作</th>
								</tr>
								<?foreach ($list as $v) { ?>
								<tr class="text-center" id="listItem_<?=$v['id']?>">
									<td><?=$v['id']?></td>
									<td><img width="60px" src="<?=$v['image']?>" alt="<?=$v['title']?>" class="img-circle"></td>
									<td class="listItemTitle"><?=$v['title']?></td>
									<td><?=$v['viewnum']?></td>
									<td><?=date('Y-m-d H:i', $v['timeupdate'])?></td>
									<td><?if ($v['status'] == 1) {
										echo "已上线";
									} else {
										echo "待审核";
									}?></td>
									<td>
										<a class="btn btn-info" href="/product/info/<?=$v['id']?>">编辑</a>
										<?if ($v['status'] == 1) {?>
										<button class="btn btn-warning offlineBtn" type="button" rowid="<?=$v['id']?>">下线</button>
										<?}else{?>
										<button class="btn btn-success onlineBtn" type="button" rowid="<?=$v['id']?>">上线</button>
										<?}?>
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
	Strea.baseUrl = '/product';
	Strea.sType = '<?=$request['st']?>';
	Strea.sKey = '<?=$request['sk']?>';
	Strea.stat = '<?=$request['stat']?>';
	Strea.sort = '<?=$request['sort']?>';
	Strea.setMenu('product/list');
	Strea.listInit();
	Strea.delInit();
	init();
});

function init () {
	$('.onlineBtn').on('click',function(){
		itemid = $(this).attr('rowid');
		itemtitle = $(this).parents('tr').find('.listItemTitle').html();
		$('#cfmMsg').html('确认上线 『' + itemtitle + '』 ?');
		$('#cfmBtn').attr('itemid', itemid);
		$('#cfmBtn').off('click');
		$('#cfmBtn').on('click',function(){
			onlineRow();
		});
		$('#cfmModal').modal('show');
	});
	$('.offlineBtn').on('click',function(){
		itemid = $(this).attr('rowid');
		itemtitle = $(this).parents('tr').find('.listItemTitle').html();
		$('#cfmMsg').html('确认下线 <' + itemtitle + '> ?');
		$('#cfmBtn').attr('itemid', itemid);
		$('#cfmBtn').off('click');
		$('#cfmBtn').on('click',function(){
			offlineRow();
		});
		$('#cfmModal').modal('show');
	});
}
function onlineRow () {
	$('#cfmModal').modal('hide');
	id = $('#cfmBtn').attr('itemid');
	$.ajax({
		url: Strea.baseUrl + '/dealonline',
		type: 'post',
		dataType: 'json',
		data: {id:id},
		success :function (msg) {
			$('#resultMsg').html(msg.msg);
			$('#resultModal').modal('show');
			$('#listItem_' + id).find('.onlineBtn').html('下线');
			$('#listItem_' + id).find('.onlineBtn').attr('class', 'btn btn-warning offlineBtn');
			init();
			$('#cfmBtn').off('click');
		}
	});
}
function offlineRow () {
	$('#cfmModal').modal('hide');
	id = $('#cfmBtn').attr('itemid');
	$.ajax({
		url: Strea.baseUrl + '/dealoffline',
		type: 'post',
		dataType: 'json',
		data: {id:id},
		success :function (msg) {
			$('#resultMsg').html(msg.msg);
			$('#resultModal').modal('show');
			$('#listItem_' + id).find('.offlineBtn').html('上线');
			$('#listItem_' + id).find('.offlineBtn').attr('class', 'btn btn-success onlineBtn');
			init();
			$('#cfmBtn').off('click');
		}
	});
}
</script>

</html>