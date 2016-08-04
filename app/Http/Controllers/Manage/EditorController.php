<?php
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\Manage;
use AdminTools;

class EditorController extends Controller {

	public function __construct () {
		date_default_timezone_set('PRC');

		//加盐！！！！！！！
		$this->salt = "BBMST";
		//COOKIE前缀
		$this->cookiePrefix = 'bbmst_';

		$EditorClass = new Manage\EditorModel;
		$loginStat = $EditorClass->chkLogin();
		if (!$loginStat) {
			$ATool = new AdminTools;
			$ATool->redirect('/login');
		}
	}


	public function getIndex () {
		#code...
	}

	public function getList($page = 1) {
		$EditorClass = new Manage\EditorModel;
		$ATool = new AdminTools;

		if ($_COOKIE[$this->cookiePrefix . 'level'] != 1) {
			$ATool->redirect('/editor/info');
		}		

		$pageSize = 20;
		$now = time();
		$filter = array(
			'st' => '按登陆ID',
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
				case 'lastlogin':
					$filter['sort'] = '最后登录';
					$order = 'lastlogin DESC';
					break;
				case 'username':
					$filter['sort'] = '登陆ID';
					$order = 'username ASC';
					break;
				case 'realname':
					$filter['sort'] = '真实姓名';
					$order = 'realname ASC';
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
					case 'username':
						$filter['st'] = '按登录ID';
						$param['where']['sql'] .= " AND `username` LIKE :username";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':username' => "%{$_GET['sk']}%"));
						break;
					case 'realname':
						$filter['st'] = '按真实姓名';
						$param['where']['sql'] .= " AND `realname` LIKE :realname";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':realname' => "%{$_GET['sk']}%"));
						break;
					default:
						$filter['st'] = '按登录ID';
						$param['where']['sql'] .= " AND `username` LIKE :username";
						$param['where']['bind'] = array_merge($param['where']['bind'], array(':username' => "%{$_GET['sk']}%"));
						break;
				}
			}
		}

		$type = array(
			'page' => $page,
			'pageSize' => $pageSize,
			'order' => $order
		);

		$list = $EditorClass->getList($param, $type);

		if (empty($list)) {
			$count = 0;
		} else {
			$count = $EditorClass->getList($param, 'count');
		}

		if (!empty($_GET)) {
			foreach ($_GET as $k => $v) {
				$urlParam .= '&' . $k . '=' . $v;
			}
			$urlParam = '?' . substr($urlParam, 1);
		}

		$pageStr = $ATool->getListPageStr($page, $pageSize, $count, '/editor/list/', $urlParam);

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('editormenu'),
			'request' => $request,
			'filter' => $filter,
			'list' => $list,
			'page' =>$pageStr
		);

		$view = view('Manage.editor_list', $data);

		return $view;
	}

	public function getInfo ($id = 0) {
		$EditorClass = new Manage\EditorModel;
		$ATool = new AdminTools;

		if (!is_numeric($id)) {
			$ATool->show404();
		}

		if ($id == 0) {
			$id = $_COOKIE[$this->cookiePrefix . 'id'];
		}

		if ($_COOKIE[$this->cookiePrefix . 'level'] != 1) {
			$id = $_COOKIE[$this->cookiePrefix . 'id'];
		}

		$info = $EditorClass->getOneByIdx($id);

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('editormenu'),
			'data' => $info
		);

		$view = view('Manage.editor_edit', $data);

		return $view;
	}

	public function getAdd () {
		$ATool = new AdminTools;

		$data = array(
			'header' => $ATool->getPage('header'),
			'footer' => $ATool->getPage('footer'),
			'menu' => $ATool->getPage('editormenu')
		);

		$view = view('Manage.editor_add', $data);

		return $view;
	}

	public function getDealadd () {
		$EditorClass = new Manage\EditorModel;

		$data = $_POST;
		$now = time();
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		if ($data['username'] == '') {
			$result['msg'] = '请填写编辑登录ID！';
			die(json_encode($result));
		}
		if ($data['realname'] == '') {
			$result['msg'] = '请填写编辑真实姓名！';
			die(json_encode($result));
		}
		if ($data['password'] == '') {
			$result['msg'] = '请填写登录密码！';
			die(json_encode($result));
		}

		$param = array('username' => $data['username']);
		$type = 'count';
		$count = $EditorClass->getList($param, $type);

		if ($count > 0) {
			$result['msg'] = '该登录ID已存在，请更换其他ID！';
			die(json_encode($result));
		}

		$info = array(
			'username' => $data['username'],
			'password' => md5($this->salt . $data['password']),
			'realname' => $data['realname'],
			'lastlogin' => $now,
			'loginip' => '',
			'level' => $data['level'],
			'timeadd' => $now
		);

		foreach ($info as $k => $v) {
			if ($k != 'password') {
				$info[$k] = htmlspecialchars($v);
			}
		}

		$insertID = $EditorClass->add($info);

		if ($insertID) {
			$result['err'] = 0;
			$result['msg'] = '添加成功！';
			$result['url'] = '/editor/list';
		} else {
			$result['msg'] = '网络故障，请稍后重试！';
		}
		die(json_encode($result));
	}

	public function getDealedit () {
		$EditorClass = new Manage\EditorModel;

		$data = $_POST;
		$now = time();
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		if ($data['realname'] == '') {
			$result['msg'] = '请填写编辑真实姓名！';
			die(json_encode($result));
		}

		$id = $data['id'];
		$info = array(
			'realname' => $data['realname'],
			'level' => $data['level']
		);

		if ($data['password'] != '') {
			$info['password'] = md5($this->salt . $data['password']);
		}

		foreach ($info as $k => $v) {
			if ($k != 'password') {
				$info[$k] = htmlspecialchars($v);
			}
		}

		$update = $EditorClass->edit($id, $info);

		if ($update) {
			$result['err'] = 0;
			$result['msg'] = '更新成功！';
		} else {
			$result['msg'] = '网络故障，请稍后重试！';
		}
		die(json_encode($result));
	}

	public function getDealdel () {
		$EditorClass = new Manage\EditorModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$EditorClass->del($id);
		$result = array('err' => 0, 'msg' => '删除成功！');
		die(json_encode($result));
	}

	public function getDealrec () {
		$EditorClass = new Manage\EditorModel;

		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$param = array('isdel' => 0);
		$EditorClass->edit($id,$param);
		$result = array('err' => 0, 'msg' => '恢复成功！');
		die(json_encode($result));
	}

}

?>