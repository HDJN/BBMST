<?php
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\Manage;
use AdminTools;

class BrandController extends Controller {

	public function __construct () {
		date_default_timezone_set('PRC');
		$EditorClass = new Manage\EditorModel;
		$loginStat = $EditorClass->chkLogin();
		if (!$loginStat) {
			$ATool = new AdminTools;
			$ATool->redirect('/login');
		}
	}


	public function getIndex () {
	}

	public function getList($page = 1) {
		$BrandClass = new Manage\BrandModel;
		$ATool = new AdminTools;

		$pageSize = 20;
		$now = time();
		$filter = array(
			'st' => '按中文名',
			'sk' => '',
			'stat' => '',
			'sort' => ''
		);
		$request = array(
			'st' => isset($_GET['st']) ? strip_tags($_GET['st']) : '',
			'sk' => isset($_GET['sk']) ? strip_tags($_GET['sk']) : '',
			'stat' => isset($_GET['stat']) ? strip_tags($_GET['stat']) : '',
			'sort' => isset($_GET['sort']) ? strip_tags($_GET['sort']) : ''
		);
		$urlParam = '';

		if (!isset($_GET['sort'])) {
			$order = 'timeadd DESC';
		} else {
			switch ($_GET['sort']) {
				case 'add':
					$filter['sort'] = '添加';
					$order = 'timeadd DESC';
					break;
				case 'update':
					$filter['sort'] = '最后更新';
					$order = 'timeupdate DESC';
					break;
				case 'namecn':
					$filter['sort'] = '中文名';
					$order = 'brand ASC';
					break;
				case 'nameen':
					$filter['sort'] = '英文名';
					$order = 'branden ASC';
					break;			
				default:
					$order = 'timeadd DESC';
					break;
			}
		}
		
		$param = array('where' => array('sql' => '', 'bind' => array()));

		if (!isset($_GET['stat'])) {
			$param['isdel'] = 0;
		} else {
			switch ($_GET['stat']) {
				case 'online':
					$filter['stat'] = '线上';
					$param['isdel'] = 0;
					break;
				case 'del':
					$filter['stat'] = '已删除';
					$param['isdel'] = 1;
					break;
				default:
					$param['isdel'] = 0;
					break;
			}
		}

		if (isset($_GET['sk'])) {
			if ($_GET['sk'] !== '') {
				$filter['sk'] = $_GET['sk'];
				switch ($_GET['st']) {
					case 'namecn':
						$filter['st'] = '按中文名';
						$param['where']['sql'] .= " AND `brand` LIKE :brand";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':brand' => "%{$_GET['sk']}%"));
						break;
					case 'nameen':
						$filter['st'] = '按英文名';
						$param['where']['sql'] .= " AND `branden` LIKE :branden";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':branden' => "%{$_GET['sk']}%"));
						break;
					default:
						$filter['st'] = '按中文名';
						$param['where']['sql'] .= " AND `brand` LIKE :brand";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':brand' => "%{$_GET['sk']}%"));
						break;
				}
			}
		}

		$type = array(
			'page' => $page,
			'pageSize' => $pageSize,
			'order' => $order
		);

		$list = $BrandClass->getList($param, $type);

		if (empty($list)) {
			$count = 0;
		} else {
			$count = $BrandClass->getList($param, 'count');
		}

		if (!empty($_GET)) {
			foreach ($_GET as $k => $v) {
				$urlParam .= '&' . $k . '=' . $v;
			}
			$urlParam = '?' . substr($urlParam, 1);
		}

		$pageStr = $ATool->getListPageStr($page, $pageSize, $count, '/brand/list/', $urlParam);

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('brandmenu'),
			'request' => $request,
			'filter' => $filter,
			'list' => $list,
			'page' =>$pageStr
		);

		$view = view('Manage.brand_list', $data);

		return $view;
	}

	public function getInfo ($id = 1) {
		$BrandClass = new Manage\BrandModel;
		$ATool = new AdminTools;

		if (!is_numeric($id)) {
			$ATool->show404();
		}

		$info = $BrandClass->getOneByIdx($id);

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('brandmenu'),
			'data' => $info
		);

		$view = view('Manage.brand_edit', $data);

		return $view;
	}

	public function getAdd () {
		$ATool = new AdminTools;

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('brandmenu')
		);

		$view = view('Manage.brand_add', $data);

		return $view;		
	}

	public function getDealadd () {
		$BrandClass = new Manage\BrandModel;

		$data = $_POST;
		$now = time();
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		if ($data['brand'] == '') {
			$result['msg'] = '请填写品牌中文名！';
			die(json_encode($result));
		}
		if ($data['branden'] == '') {
			$result['msg'] = '请填写品牌英文名！';
			die(json_encode($result));
		}
		if ($data['logo'] == '') {
			$result['msg'] = '请上传品牌 LOGO！';
			die(json_encode($result));
		}


		$info = array(
			'brand' => $data['brand'],
			'branden' => $data['branden'],
			'website' => $data['website'],
			'founder' => $data['founder'],
			'foundtime' => $data['foundtime'],
			'cradle' => $data['cradle'],
			'logo' => $data['logo'],
			'story' => $data['story'],
			'timeadd' => $now,
			'timeupdate' => $now
		);

		foreach ($info as $k => $v) {
			if ($k != 'story') {
				$info[$k] = htmlspecialchars($v);
			}
		}

		$insertID = $BrandClass->add($info);

		if ($insertID) {
			$result['err'] = 0;
			$result['msg'] = '添加成功！';
			$result['url'] = '/brand/list';
		} else {
			$result['msg'] = '网络故障，请稍后重试！';
		}
		die(json_encode($result));
	}

	public function getDealedit () {
		$BrandClass = new Manage\BrandModel;

		$data = $_POST;
		$now = time();
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		if ($data['brand'] == '') {
			$result['msg'] = '请填写品牌中文名！';
			die(json_encode($result));
		}
		if ($data['branden'] == '') {
			$result['msg'] = '请填写品牌英文名！';
			die(json_encode($result));
		}
		if ($data['logo'] == '') {
			$result['msg'] = '请上传品牌 LOGO！';
			die(json_encode($result));
		}

		$id = $data['id'];
		$info = array(
			'brand' => $data['brand'],
			'branden' => $data['branden'],
			'website' => $data['website'],
			'founder' => $data['founder'],
			'foundtime' => $data['foundtime'],
			'cradle' => $data['cradle'],
			'logo' => $data['logo'],
			'story' => $data['story'],
			'timeupdate' => $now
		);

		foreach ($info as $k => $v) {
			if ($k != 'story') {
				$info[$k] = htmlspecialchars($v);
			}
		}

		$update = $BrandClass->edit($id, $info);

		if ($update) {
			$result['err'] = 0;
			$result['msg'] = '更新成功！';
		} else {
			$result['msg'] = '网络故障，请稍后重试！';
		}
		die(json_encode($result));
	}

	public function getDealdel () {
		$BrandClass = new Manage\BrandModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$BrandClass->del($id);
		$result = array('err' => 0, 'msg' => '删除成功！');
		die(json_encode($result));
	}

	public function getDealrec () {
		$BrandClass = new Manage\BrandModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$param = array('isdel' => 0);
		$BrandClass->edit($id,$param);
		$result = array('err' => 0, 'msg' => '恢复成功！');
		die(json_encode($result));
	}

	public function getProductbrand () {
		$BrandClass = new Manage\BrandModel;

		$st = isset($_POST['st']) ? $_POST['st'] : '';
		$sk = isset($_POST['sk']) ? $_POST['sk'] : '';
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		$param = array(
			'isdel' => 0,
			'where' => array('sql' => '', 'bind' => array())
		);
		switch ($st) {
			case 'namecn':
				$param['where']['sql'] .= " AND `brand` LIKE :brand";
				$param['where']['bind'] = array_merge($param['where']['bind'], array(':brand' => "%{$sk}%"));
				break;
			case 'nameen':
				$param['where']['sql'] .= " AND `branden` LIKE :branden";
				$param['where']['bind'] = array_merge($param['where']['bind'], array(':branden' => "%{$sk}%"));
				break;
			default:
				$param['where']['sql'] .= " AND `brand` LIKE :brand";
				$param['where']['bind'] = array_merge($param['where']['bind'], array(':brand' => "%{$sk}%"));
				break;
		}

		$type = array(
			'limit' => array(0, 50)
		);

		$list = $BrandClass->getList($param, $type);

		if (!empty($list)) {
			$result['msg'] = '<table class="table table-bordered table-striped table-hover table-condensed"><tr><th class="text-center">Logo</th><th class="text-center">中文名称</th><th class="text-center">操作</th></tr>';
										
			foreach ($list as $v) {
				$result['msg'] .= '<tr class="text-center"><td><img width="50px" src="' . $v['logo'] . '" class="img-circle"></td><td>' . $v['brand'] . '</td><td><button type="button" class="btn btn-primary brandSearchAdd" itemid="' . $v['id'] . '" itemname="' . $v['brand'] . '" itemnameen="' . $v['branden'] . '" itemlink="' . $v['website'] . '">添加</button></td></tr>';
			}
			$result['msg'] .= '</table>';
		} else {
			$result['msg'] = '未找到相关结果！';
		}

		die(json_encode($result));
	}

}

?>