<?php
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\Manage;
use AdminTools;

class LoginController extends Controller {

	public function __construct () {
		date_default_timezone_set('PRC');

		//COOKIE前缀
		$this->cookiePrefix = 'bbmst_';
	}

	public function getIndex () {
		$ATool = new AdminTools;

		$data = array(
			'footer' => $ATool->getPage('footer')
		);

		$view = view('Manage.login', $data);

		return $view;
	}

	public function getGologin () {
		$EditorClass = new Manage\EditorModel;
		$LogClass = new Manage\LogModel;
		$ATool = new AdminTools;

		$data = $_POST;

		//加盐！！！！！！！
		$salt = "BBMST";

		$now = time();
		$ip = $ATool->getIp();
		$result = array('err' => 1, 'msg' => '');
		ob_clean();

		if ($data['uname'] == '') {
			$result['msg'] = '请填写登录ID！';
			die(json_encode($result));
		}
		if ($data['pwd'] == '') {
			$result['msg'] = '请填写登录密码！';
			die(json_encode($result));
		}

		$param = array(
			'username' => $data['uname'],
		);
		$type = array();
		$list = $EditorClass->getList($param, $type);

		if (count($list) == 0) {
			$result['msg'] = '登录ID/密码错误！';
			die(json_encode($result));
		} else {
			$uInfo = $list[0];
			$param = array(
				'action' => 'loginfail',
				'adminid' => $uInfo['id'],
				'where' => array(
					'sql' => ' AND timeadd >= :timeadd',
					'bind' => array(':timeadd' => ($now - 60 * 60 * 10))
				)
			);
			$type = 'count';
			$count = $LogClass->getList($param, $type);
			if ($count >= 5) {
				$result['msg'] = '您已登录失败5次，此ID已被暂时锁定！<br />请10分钟后再试！';
				die(json_encode($result));
			}

		}

		if ($uInfo['password'] != md5($salt . $data['pwd'])) {
			$log = array(
				'adminid' => $uInfo['id'],
				'action' => 'loginfail',
				'data' => json_encode(array('username' => $data['uname'],'password' => $data['pwd'],'ip' => $ip)),
				'timeadd' => $now
			);
			$LogClass->add($log);
			$result['msg'] = '登录ID/密码错误！';
			die(json_encode($result));
		} else {
			$updateInfo = array(
				'lastlogin' => $now,
				'loginip' => $ip
			);

			$update = $EditorClass->edit($uInfo['id'], $updateInfo);

			$log = array(
				'adminid' => $uInfo['id'],
				'action' => 'login',
				'data' => json_encode(array('ip' => $ip)),
				'timeadd' => $now
			);
			$LogClass->add($log);

			$now = time();
			$auth = md5($uInfo['username'] . $uInfo['password'] . $now . $uInfo['level'] . $salt);

			setcookie($this->cookiePrefix . 'id', $uInfo['id'], time()+3600*24, '/');
			setcookie($this->cookiePrefix . 'auth', $auth, time()+3600*24, '/');
			setcookie($this->cookiePrefix . 'login_time', $now, time()+3600*24, '/');
			setcookie($this->cookiePrefix . 'level', $uInfo['level'], time()+3600*24, '/');

			$result['err'] = 0;
			$result['msg'] = '登录成功！';
			$result['url'] = '/product/list';
			die(json_encode($result));
		}
	}

	public function getOut () {
		$ATool = new AdminTools;

		setcookie($this->cookiePrefix . 'id', Null, -1, '/');
		setcookie($this->cookiePrefix . 'auth', Null, -1, '/');
		setcookie($this->cookiePrefix . 'login_time', Null, -1, '/');
		setcookie($this->cookiePrefix . 'level', Null, -1, '/');

		$ATool->redirect('/login');
	}

}

?>