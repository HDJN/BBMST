<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use DBLib;

class EditorModel extends Model {

	/**
	 * [__construct 初始化模型,定义主从数据库,读写分离]
	 */
	public function __construct () {
		$this->Ma = new DBLib('write');
		$this->Sl = new DBLib('read');
		$this->table = 'admin';
		//COOKIE前缀
		$this->cookiePrefix = 'bbmst_';
	}


	/**
	 * [add 添加管理员]
	 * @param [arr] $data [管理员基本信息数组]
	 */
	public function add ($data) {
		if (!empty($data)) {
			$result = $this->Ma->add($this->table, $data);

			return $result;
		} else {
			return false;
		}
	}

	/**
	 * [update 更新管理员数据]
	 * @param  [int] $id   [管理员id]
	 * @param  [arr] $data [管理员基本信息数组]
	 * @return [bool]       [成功／失败]
	 */
	public function edit ($ids, $data) {
		if (!empty($data)) {
			if (is_numeric($ids)) {
				$where = array('id' => $ids);
			} else {
				$bind = array();
				$param = '';
				for ($i=0; $i < count($ids); $i++) { 
					$bind[':ids_' . $i] = $ids[$i];
					$param .= ', :ids_' . $i;
				}
				$param = substr($param, 2);
				$where = array('where' => array('sql' => " AND `id` IN ($param)", 'bind' => $bind));
			}

			$result = $this->Ma->update($this->table, $where, $data);

			return true;
		} else {
			return false;
		}
	}

	/**
	 * [del 删除管理员]
	 * @param  [int] $id [管理员id]
	 */
	public function del ($ids) {
		if (is_numeric($ids)) {
			$where = array('id' => $ids);
		} else {
			$bind = array();
			$param = '';
			for ($i=0; $i < count($ids); $i++) { 
				$bind[':ids_' . $i] = $ids[$i];
				$param .= ', :ids_' . $i;
			}
			$param = substr($param, 2);
			$where = array('where' => array('sql' => " AND `id` IN ($param)", 'bind' => $bind));
		}
		
		$result = $this->Ma->del($this->table, $where, 'isdel');

		return true;
	}

	/**
	 * [getOneByIdx 通过索引获取管理员数据]
	 * @param  [int/str] $idx [管理员id或者管理员标题]
	 * @return [arr]      [管理员数据数组]
	 */
	public function getOneByIdx ($id) {
		$where = array('id' => $id);

		$result = $this->Sl->getOne($this->table, $where);

		return $result;
	}

	/**
	 * [getList 通过参数获得管理员列表]
	 * @param  [arr] $param [参数数组]
	 * @param  [str/arr] $type  [count时返回总数，数组时返回列表，支持分页]
	 * @return [arr]        [管理员列表数组]
	 */
	public function getList ($data, $type = 'count') {
		$list = $this->Sl->getList($this->table, $data, $type);

		return $list;
	}

	/**
	 * [getAll 获取所有管理员]
	 * @return [arr] [管理员列表数组]
	 */
	public function getAll () {
		$list = $this->Sl->getAll($this->table);

		return $list;
	}
	/**
	 * [chkLogin 通过cookie中的uid,auth,登录时间三项验证用户是否已经登录]
	 * @param  [int] $level [权限]
	 * @return [bool] [是否登录]
	 */
	public function chkLogin () {
		$uid = isset($_COOKIE[$this->cookiePrefix .'id']) ? $_COOKIE[$this->cookiePrefix .'id'] : '';
		$auth = isset($_COOKIE[$this->cookiePrefix .'auth']) ? $_COOKIE[$this->cookiePrefix .'auth'] : '';
		$level = isset($_COOKIE[$this->cookiePrefix .'level']) ? $_COOKIE[$this->cookiePrefix .'level'] : '';
		$loginTime = isset($_COOKIE[$this->cookiePrefix .'login_time']) ? $_COOKIE[$this->cookiePrefix .'login_time'] : '';

		//加盐！！！！！！！
		$salt = "BBMST";

		if ($uid && $auth && $loginTime) {
			$now = time();
			if (($loginTime + 86400 * 1) >= $now) {
				$sql = "SELECT * FROM $this->table WHERE `id` = '$uid'";
				$where = array('id' => $uid);
				$list = $this->Sl->getOne($this->table, $where);
				if (!empty($list)) {
					$dbAuth = md5($list['username'] . $list['password'] . $loginTime . $list['level'] . $salt);
					if ($auth == $dbAuth) {
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
