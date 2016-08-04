<?=$header?>
<link href="/css/manage/summernote.css" rel="stylesheet">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-push-2" id="mainWindow">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 编辑品牌
						</div>
						<div class="panel-body">
							<form class="form-horizontal">
								<div class="form-group">
									<label for="brand" class="col-sm-2 control-label">*&nbsp;品牌中文名</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="brand" name="brand" placeholder="品牌中文名" value="<?=$data['brand']?>">
										<input type="hidden" id="id" name="brand" value="<?=$data['id']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="branden" class="col-sm-2 control-label">*&nbsp;品牌英文名</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="branden" name="branden" placeholder="品牌英文名" value="<?=$data['branden']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="website" class="col-sm-2 control-label">官网地址</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="website" name="website" placeholder="官网地址" value="<?=$data['website']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="founder" class="col-sm-2 control-label">创始人</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="founder" name="founder" placeholder="创始人" value="<?=$data['founder']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="foundtime" class="col-sm-2 control-label">创始时间</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="foundtime" name="foundtime" placeholder="创始时间" value="<?=$data['foundtime']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="cradle" class="col-sm-2 control-label">发源地</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="cradle" name="cradle" placeholder="发源地" value="<?=$data['cradle']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="logo" class="col-sm-2 control-label">*&nbsp;品牌LOGO</label>
									<div class="col-sm-10">
										<div class="input-group">
											<span class="input-group-btn">
												<button class="btn btn-default uploadpreview" type="button">&nbsp;<span class="glyphicon glyphicon-picture" aria-hidden="true"></span></button>
											</span>
											<input type="text" class="form-control" id="logo" placeholder="品牌LOGO" value="<?=$data['logo']?>">
											<span class="input-group-btn">
												<button class="btn btn-info uploadModalBtn" type="button" upload="uploadbrandimg">上传图片</button>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="story" class="col-sm-2 control-label">品牌故事</label>
									<div class="col-sm-10">
										<div id="summernote"></div>
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
			$(document).ready(function() {
				Strea = new Tools();
				Strea.baseUrl = '/brand';
				Strea.setMenu('brand/list');
				Strea.uploadInit();
				Strea.editorInit('summernote');

				$('#summernote').summernote('code', '<?=str_replace(array("\r","\n"), '', addslashes($data['story']))?>');

				$('#submitbtn').on('click',function(){
					edit();
				});
			});
			function edit () {
				data = Strea.getFormData('mainWindow');
				data.story = $('#summernote').summernote('code');
				Strea.subForm('/dealedit', data);
			}
		</script>
	</body>
</html>