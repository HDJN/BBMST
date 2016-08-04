<?=$header?>
<link href="/css/manage/summernote.css" rel="stylesheet">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-push-2" id="mainWindow">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 更新产品
						</div>
						<div class="panel-body">
							<form class="form-horizontal">
								<div class="form-group">
									<label for="title" class="col-sm-2 control-label">*&nbsp;产品标题</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="title" name="title" placeholder="产品标题">
									</div>
								</div>
								<div class="form-group">
									<label for="brandname" class="col-sm-2 control-label">*&nbsp;关联品牌</label>
									<div class="col-sm-10">
										<div class="input-group">
											<input type="text" class="form-control" id="brandname" placeholder="关联品牌" readonly>
											<input type="hidden" id="brand">
											<span class="input-group-btn">
												<button class="btn btn-info" id="choosebrand" type="button">选择品牌</button>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="image" class="col-sm-2 control-label">*&nbsp;封图</label>
									<div class="col-sm-10">
										<div class="input-group">
											<span class="input-group-btn">
												<button class="btn btn-default uploadpreview" type="button">&nbsp;<span class="glyphicon glyphicon-picture" aria-hidden="true"></span></button>
											</span>
											<input type="text" class="form-control" id="image" placeholder="680&nbsp;*&nbsp;340像素">
											<span class="input-group-btn">
												<button class="btn btn-info uploadModalBtn" type="button" upload="uploadproductimg">上传图片</button>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="viewnum" class="col-sm-2 control-label">访问次数</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="viewnum" name="viewnum" placeholder="访问次数" >
									</div>
								</div>
								<div class="form-group">
									<label for="tag" class="col-sm-2 control-label">*&nbsp;标签</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="tag" name="tag" placeholder="标签">
									</div>
								</div>
								<div class="form-group">
									<label for="tryinfo" class="col-sm-2 control-label">说明</label>
									<div class="col-sm-10">
										<div id="summernote"></div>
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
		<div class="modal fade" id="brandModal" style="margin-top:50px;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">品牌搜索</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12 brandSearchGroup">
								<div class="input-group">
									<div class="input-group-btn">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">按中文名 <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="jsvascript:void(0);" type="namecn">按中文名</a></li>
											<li><a href="jsvascript:void(0);" type="nameen">按英文名</a></li>
										</ul>
									</div>
									<input type="text" class="form-control" aria-label="keyword" placeholder="关键词..." value="">
									<span class="input-group-btn">
										<button class="btn btn-info brandSearchBtn" type="button">Search</button>
									</span>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-xs-12 brandSearchResult" style="margin-top:10px;">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="uploadModal" style="margin-top:50px;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">上传文件</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12">
								<div class="input-group">
									<input class="note-image-input form-control" type="file" name="image_file" id="image_file" accept="image/*">
									<input type="hidden" class="uploadPos" value="">
									<span class="input-group-btn">
										<button class="btn btn-info uploadImgBtn" type="button">Upload</button>
									</span>
								</div>
							</div>
							<div class="col-xs-12">
								<p class="uploadImgErr"></p>
							</div>			
						</div>
						<div class="row">
							<div class="col-xs-12" style="margin-top:10px;">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>
		<?=$footer?>
		<script src="/js/manage/page.js"></script>
		<script src="/js/manage/summernote.min.js"></script>
		<script src="/js/manage/summernote-zh-CN.js"></script>
		<script src="/js/manage/ajaxfileupload.js"></script>
		<script type="text/javascript">
			var brandSearchType = 'namecn';
			$(document).ready(function() {
				Strea = new Tools();
				Strea.baseUrl = '/product';
				Strea.setMenu('product/add');
				Strea.uploadInit();
				$('#summernote').summernote({
					lang: 'zh-CN',
					height: 300,
					minHeight: null,
					maxHeight: null
				});
				$('#summernote').summernote('code');

				$('#submitbtn').on('click',function(){
					addProduct();
				});
				$('#choosebrand').on('click',function(){
					$('#brandModal').modal('show');
				});
				$('#brandModal').on('click','.brandSearchAdd',function(){
					brandid = $(this).attr('itemid');
					brandname = $(this).attr('itemname');
					$('#brand').val(brandid);
					$('#brandname').val(brandname);
					$('#brandModal').modal('hide');
				});
				$('.brandSearchGroup').find('li').find('a').on('click', function(){
					brandSearchType = $(this).attr('type');
					$('.brandSearchGroup').find('.dropdown-toggle').html($(this).html() + ' <span class="caret"></span>');
				});
				$('.brandSearchBtn').on('click', brandList);
			});

			function addProduct () {
				data = Strea.getFormData('mainWindow');
				data.timestart = $('#start_y').val() + '-' + $('#start_m').val() + '-' + $('#start_d').val() + ' ' + $('#start_h').val() + ':00:00';
				data.timdend = $('#end_y').val() + '-' + $('#end_m').val() + '-' + $('#end_d').val() + ' ' + $('#end_h').val() + ':00:00';
				data.contents = $('#summernote').summernote('code');
				Strea.subForm('/dealadd', data);
			}
			function brandList () {
				$('.brandSearchBtn').off('click');
				keyword = $('.brandSearchGroup').find('input').val();
				$('.brandSearchResult').html('<p class="text-center"><span class="glyphicon glyphicon-search" aria-hidden="true"> 搜索中。。。</span></p>');
				$.ajax({
					type: 'post',
					url: '/brand/productbrand',
					dataType: 'json',
					data: {st:brandSearchType, sk:keyword},
					success: function (msg) {
						if (msg.err == 0) {
							$('.brandSearchResult').html(msg.msg);
						} else {
							$('.brandSearchResult').html('<p class="text-center">' + msg.msg + '</p>');
						}
						$('.brandSearchBtn').on('click', brandList);
					}
				});
			}
		</script>
	</body>
</html>