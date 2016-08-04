function Tools() {
	this.baseUrl = '';
	this.baseUrlParam = '';
	this.baseUploadUrl = '/upload/';
	this.sType = 'title';
	this.sKey = '';
	this.stat = '';
	this.sort = '';
}
Tools.prototype = {
	listInit: function () {
		this.searchInit();
		this.filterInit();
	},
	searchInit: function () {
		self = this;
		$('.searchGroup').find('li').find('a').on('click', function(){
			self.sType = $(this).attr('type');
			$('.searchGroup').find('.dropdown-toggle').html($(this).html() + ' <span class="caret"></span>');
		});
		$('.searchBtn').on('click', function() {
			keyword = $('.searchGroup').find('input').val();
			url = self.baseUrl + '/list/?st=' + self.sType + '&sk=' + keyword + self.baseUrlParam;
			location.href = url;
		});
	},
	filterInit: function () {
		self = this;
		$('.statGroup').find('li').find('a').on('click', function(){
			self.stat = $(this).attr('type');
			url = self.baseUrl + '/list/?';
			if (self.sKey != '') {
				url += 'st=' + self.sType + '&sk=' + self.sKey + '&';
			}
			url += 'stat=' + self.stat + '&sort=' + self.sort + self.baseUrlParam;
			location.href = url;
		});
		$('.sortGroup').find('li').find('a').on('click', function(){
			self.sort = $(this).attr('type');
			url = self.baseUrl + '/list/?';
			if (self.sKey != '') {
				url += 'st=' + self.sType + '&sk=' + self.sKey + '&';
			}
			url += 'stat=' + self.stat + '&sort=' + self.sort + self.baseUrlParam;
			location.href = url;	
		});
	},
	delInit: function () {
		self = this;
		$('.delBtn').on('click',function(){
			itemid = $(this).attr('rowid');
			itemtitle = $(this).parents('tr').find('.listItemTitle').html();
			if (typeof(itemtitle) != 'undefined') {
				$('#cfmMsg').html('确认删除『' + itemtitle + '』?');
			} else {
				$('#cfmMsg').html('确认删除?');
			}
			$('#cfmBtn').attr('itemid', itemid);
			$('#cfmBtn').off('click');
			$('#cfmBtn').on('click',function(){
				self.delRow();
			});
			$('#cfmModal').modal('show');
		});
		$('.recBtn').on('click',function(){
			itemid = $(this).attr('rowid');
			itemtitle = $(this).parents('tr').find('.listItemTitle').html();
			if (typeof(itemtitle) != 'undefined') {
				$('#cfmMsg').html('确认恢复『' + itemtitle + '』?');
			} else {
				$('#cfmMsg').html('确认恢复?');
			}
			$('#cfmBtn').attr('itemid', itemid);
			$('#cfmBtn').off('click');
			$('#cfmBtn').on('click',function(){
				self.recRow();
			});
			$('#cfmModal').modal('show');
		});
	},
	uploadInit: function () {
		self = this;
		$('.uploadModalBtn').on('click', function () {
			self.uploadPos = $(this).parents('.input-group').find('input').attr('id');
			self.uploadType = $(this).attr('upload');
			$('#uploadModal').find('.uploadImgErr').html('');
			$('#uploadModal').modal('show');
		});
		$('.uploadImgBtn').on('click', function () {
			self.uploadImg();
		});
		$('.uploadpreview').on('click', function(){
			img = $(this).parents('.input-group').find('input').val();
			if (img != '') {
				$('#resultMsg').html('<img src="' + img + '" class="img-responsive center-block">');
				$('#resultModal').modal('show');
			}
		});
	},
	editorInit: function (selector) {
		self = this;
		$('#' + selector).summernote({
			lang: 'zh-CN',
			height: 300,
			minHeight: null,
			maxHeight: null,
			callbacks: {
				onImageUpload: function (files) {
					self.editorUploadFile(files[0], selector);
				}
			}
		});
	},
	delRow: function () {
		$('#cfmModal').modal('hide');
		id = $('#cfmBtn').attr('itemid');
		$.ajax({
			url: self.baseUrl + '/dealdel',
			type: 'post',
			dataType: 'json',
			data: {id:id},
			success :function (msg) {
				$('#resultMsg').html(msg.msg);
				$('#resultModal').modal('show');
				$('#listItem_' + id).remove();
				$('#cfmBtn').off('click');
			}
		});
	},
	recRow: function () {
		$('#cfmModal').modal('hide');
		id = $('#cfmBtn').attr('itemid');
		$.ajax({
			url: self.baseUrl + '/dealrec',
			type: 'post',
			dataType: 'json',
			data: {id:id},
			success :function (msg) {
				$('#resultMsg').html(msg.msg);
				$('#resultModal').modal('show');
				$('#listItem_' + id).remove();
				$('#cfmBtn').off('click');
			}
		});
	},
	getFormData: function (selector) {
		formData = {}
		$('#' + selector).find('input,textarea,select').each(function(){
			if (typeof($(this).attr('id')) != 'undefined') {
				formData[$(this).attr('id')] = $(this).val();
			}
		});
		return formData;
	},
	subForm: function (url, data) {
		self = this;
		$.ajax({
			url: self.baseUrl + url,
			type: 'post',
			dataType: 'json',
			data: data,
			success :function (msg) {
				if (msg.err == 0) {
					$('#resultMsg').html(msg.msg);
					if (typeof(msg.url) != 'undefined' && msg.url != '') {
						$('#resultModal').find('.modal-footer').html('<a href="' + msg.url + '" class="btn btn-info" >确定</a>');
					}
				} else {
					$('#resultMsg').html(msg.msg);
				}
				$('#resultModal').modal('show');
			}
		});
	},
	uploadImg: function () {
		self = this;
		$.ajaxFileUpload({
			url: self.baseUploadUrl + self.uploadType,
			secureuri:false,
			fileElementId:'image_file',
			dataType: 'json',
			data:{},
			success: function (msg){
				if (msg.err == 0) {
					$('#' + self.uploadPos).val(msg.msg);
					$('#uploadModal').modal('hide');
				} else {
					$('#uploadModal').find('.uploadImgErr').html(msg.msg);
				}
			}
		});
	},
	editorUploadFile: function (file, selector) {
		data = new FormData();
		data.append("file", file);
		$.ajax({
			data: data,
			dataType: 'json',
			type: "POST",
			url: self.baseUploadUrl + 'uploadeditorimg',
			cache: false,
			contentType: false,
			processData: false,
			success: function(msg) {
				if (msg.err == 0) {
					$('#' + selector).summernote('editor.insertImage', msg.msg);
				} else {
					$('#resultMsg').html(msg.msg);
					$('#resultModal').modal('show');
				}
			}
		});
	},
	setMenu: function (menu) {
		$('#leftMenu').find('a').each(function(){
			if ($(this).attr('menu') == menu) {
				$(this).attr('class', 'text-center bg-primary');
			}
		});
	},
	echo: function (msg) {
		console.log(msg);
	},
};