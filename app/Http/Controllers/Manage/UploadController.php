<?php
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\Manage;
use UploadFile;

class UploadController extends Controller {

	public function __construct () {
		date_default_timezone_set('PRC');
		$EditorClass = new Manage\EditorModel;
		$loginStat = $EditorClass->chkLogin();
		if (!$loginStat) {
			$ATool = new AdminTools;
			$ATool->show404();
		}

		//图片上传目录，根据实际情况替换。
		$this->basePath = str_replace("app/Http/Controllers/Manage", "public/data/images/", __DIR__);
		$this->allowExts = array("gif", "jpg", "jpeg", "png");
		$this->maxSize  = 1024 * 1024 * 2;
	}

	public function getUploadbrandimg ($setName = '') {
		$this->baseUpLoadImg('brand/', $setName);
	}

	public function getUploadproductimg ($setName = '') {
		$this->baseUpLoadImg('product/', $setName);
	}

	public function getUploadeditorimg ($setName = '') {
		$urlPath  = 'article/' . date('Y', $now) . '/' . date('m', $now) . '/';
		$this->baseUpLoadImg($urlPath, $setName);
	}

	private function baseUpLoadImg ($setPath, $setName = '') {
		$UploadFile = new UploadFile;

		$now      = time();
		$maxSize  = 1024 * 1024 * 2; 
		$urlPath  = $setPath;
		$path     = $this->basePath . $urlPath;

		if ($setName != '') {
			$fileName = $setName;
		} else {
			$fileName = $now . rand(0, 100);
		}

		$UploadFile->maxSize   = $maxSize;
		$UploadFile->allowExts = $this->allowExts;
		$UploadFile->savePath  = $path;
		$UploadFile->saveRule  = $fileName;

		$result = array('err' => 0, 'msg' => '');

		if (!$UploadFile->upload()) {
			$errormsg = $UploadFile->getErrorMsg();
			$result = array('err' => 1, 'msg' => $errormsg);
		} else {
			$info = $UploadFile->getUploadFileInfo();
			$imgurl = '/data/images/' . $urlPath . $info[0]['savename'];
			$result = array('err' => 0, 'msg' => $imgurl);
		}

		ob_clean();
		echo json_encode($result);
	}
}

?>