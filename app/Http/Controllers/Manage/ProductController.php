<?php
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\Manage;
use AdminTools;

class ProductController extends Controller {

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
		$ProductClass = new Manage\ProductModel;
		$ATool = new AdminTools;

		$pageSize = 15;
		$now = time();
		$filter = array(
			'st' => '按标题',
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
					$order = 'timeupdate DESC';
					break;
				case 'update':
					$filter['sort'] = '最后更新';
					$order = 'timeupdate DESC';
					break;
				case 'title':
					$filter['sort'] = '产品名称';
					$order = 'title ASC';
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
				case 'all':
					$filter['stat'] = '全部';
					$param['isdel'] = 0;
					break;
				case 'online':
					$filter['stat'] = '已上线';
					$param['status'] = 1;
					$param['isdel'] = 0;
					break;
				case 'offline':
					$filter['stat'] = '待审核';
					$param['status'] = 0;
					$param['isdel'] = 0;
					break;
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
					case 'title':
						$filter['st'] = '按标题';
						$param['where']['sql'] .= " AND `title` LIKE :title";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':title' => "%{$_GET['sk']}%"));
						break;
					case 'brand':
						$filter['st'] = '按品牌';
						$param['where']['sql'] .= " AND `brand` IN (SELECT id FROM brand WHERE `brand` LIKE :brand_a OR branden LIKE :brand_b)";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':brand_a' => "%{$_GET['sk']}%",':brand_b' => "%{$_GET['sk']}%"));
						break;
					case 'tag':
						$filter['st'] = '按标签';
						$param['where']['sql'] .= " AND `tag` LIKE :tag";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':tag' => "%{$_GET['sk']}%"));
						break;
					default:
						$filter['st'] = '按标题';
						$param['where']['sql'] .= " AND `title` LIKE :title";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':title' => "%{$_GET['sk']}%"));
						break;
				}
			}
		}

		$type = array(
			'page' => $page,
			'pageSize' => $pageSize,
			'order' => $order
		);

		$list = $ProductClass->getList($param, $type);

		if (empty($list)) {
			$count = 0;
		} else {
			$count = $ProductClass->getList($param, 'count');
		}

		if (!empty($_GET)) {
			foreach ($_GET as $k => $v) {
				$urlParam .= '&' . $k . '=' . $v;
			}
			$urlParam = '?' . substr($urlParam, 1);
		}

		$pageStr = $ATool->getListPageStr($page, $pageSize, $count, '/product/list/', $urlParam);

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('productmenu'),
			'request' => $request,
			'filter' => $filter,
			'list' => $list,
			'page' =>$pageStr
		);

		$view = view('Manage.product_list', $data);

		return $view;
	}

	public function getInfo ($id = 1) {
		$ProductClass = new Manage\ProductModel;
		$BrandClass = new Manage\BrandModel;
		$ATool = new AdminTools;

		if (!is_numeric($id)) {
			$ATool->show404();
		}

		$now = time();

		$info = $ProductClass->getOneByIdx($id);
		if ($info) {
			$brandInfo = $BrandClass->getOneByIdx($info['brand']);
			if (!empty($brandInfo)) {
				$info['brandname'] = $brandInfo['brand'];
			} else {
				$info['brandname'] = "品牌已被删除";
			}
			unset($brandInfo);
		}


		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('productmenu'),
			'now' => $now,
			'data' => $info
		);

		$view = view('Manage.product_edit', $data);

		return $view;
	}

	public function getAdd () {
		$ATool = new AdminTools;

		$now = time();

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('productmenu'),
			'now' => $now
		);

		$view = view('Manage.product_add', $data);

		return $view;		
	}

	public function getDealadd () {
		$ProductClass = new Manage\ProductModel;

		$data = $_POST;
		$now = time();
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		if ($data['title'] == '') {
			$result['msg'] = '请填写产品标题！';
			die(json_encode($result));
		}
		if ($data['brand'] == '') {
			$result['msg'] = '请关联品牌！';
			die(json_encode($result));
		}
		if ($data['image'] == '') {
			$result['msg'] = '请上传封图！';
			die(json_encode($result));
		}
		if ($data['tag'] == '') {
			$result['msg'] = '请填写产品标签！';
			die(json_encode($result));
		}

		$info = array(
			'title' => $data['title'],
			'image' => $data['image'],
			'tag' => $data['tag'],
			'brand' => $data['brand'],
			'viewnum' => intval($data['viewnum']),
			'timeadd' => $now,
			'timeupdate' => $now,
			'contents' => $data['contents']
		);

		foreach ($info as $k => $v) {
			if ($k != 'contents') {
				$info[$k] = htmlspecialchars($v);
			}
		}

		$insertID = $ProductClass->add($info);

		if ($insertID) {
			$result['err'] = 0;
			$result['msg'] = '添加成功！';
			$result['url'] = '/product/list';
		} else {
			$result['msg'] = '网络故障，请稍后重试！';
		}
		die(json_encode($result));
	}

	public function getDealedit () {
		$ProductClass = new Manage\ProductModel;

		$data = $_POST;
		$now = time();
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		if (!is_numeric($data['id'])) {
			$result['msg'] = '试用信息错误，请稍后重试！';
			die(json_encode($result));
		}
		if ($data['title'] == '') {
			$result['msg'] = '请填写产品标题！';
			die(json_encode($result));
		}
		if ($data['brand'] == '') {
			$result['msg'] = '请关联品牌！';
			die(json_encode($result));
		}
		if ($data['image'] == '') {
			$result['msg'] = '请上传封图！';
			die(json_encode($result));
		}
		if ($data['tag'] == '') {
			$result['msg'] = '请填写产品标签！';
			die(json_encode($result));
		}

		$id = $data['id'];
		$info = array(
			'title' => $data['title'],
			'image' => $data['image'],
			'tag' => $data['tag'],
			'brand' => $data['brand'],
			'viewnum' => intval($data['viewnum']),
			'timeupdate' => $now,
			'contents' => $data['contents']
		);

		foreach ($info as $k => $v) {
			if ($k != 'contents') {
				$info[$k] = htmlspecialchars($v);
			}
		}

		$update = $ProductClass->edit($id, $info);

		if ($update) {
			$result['err'] = 0;
			$result['msg'] = '更新成功！';
		} else {
			$result['msg'] = '网络故障，请稍后重试！';
		}
		die(json_encode($result));
	}

	public function getDealdel () {
		$ProductClass = new Manage\ProductModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$ProductClass->del($id);
		$result = array('err' => 0, 'msg' => '删除成功！');
		die(json_encode($result));
	}

	public function getDealrec () {
		$ProductClass = new Manage\ProductModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$param = array('isdel' => 0);
		$ProductClass->edit($id,$param);
		$result = array('err' => 0, 'msg' => '恢复成功！');
		die(json_encode($result));
	}

	public function getDealonline () {
		$ProductClass = new Manage\ProductModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$param = array('status' => 1);
		$ProductClass->edit($id,$param);
		$result = array('err' => 0, 'msg' => '上线成功！');
		die(json_encode($result));
	}

	public function getDealoffline () {
		$ProductClass = new Manage\ProductModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$param = array('status' => 0);
		$ProductClass->edit($id,$param);
		$result = array('err' => 0, 'msg' => '下线成功！');
		die(json_encode($result));
	}

	public function getDealtop () {
		$ProductClass = new Manage\ProductModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$now = time();
		$param = array('timeupdate' => $now);
		$ProductClass->edit($id, $param);
		$result = array('err' => 0, 'msg' => '置顶成功！');
		die(json_encode($result));
	}
}

?>