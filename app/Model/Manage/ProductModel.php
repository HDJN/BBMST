<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use DBLib;

class ProductModel extends Model {

	/**
	 * [__construct 初始化模型,定义主从数据库,读写分离]
	 */
	public function __construct () {
		$this->Ma = new DBLib('write');
		$this->Sl = new DBLib('read');
		$this->table = 'product';
	}

	/**
	 * [add 添加产品]
	 * @param [arr] $data [产品基本信息数组]
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
	 * [update 更新产品数据]
	 * @param  [int] $id   [产品id]
	 * @param  [arr] $data [产品基本信息数组]
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
	 * [del 删除产品]
	 * @param  [int] $id [产品id]
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
	 * [getOneByIdx 通过索引获取产品数据]
	 * @param  [int/str] $idx [产品id或者产品标题]
	 * @return [arr]      [产品数据数组]
	 */
	public function getOneByIdx ($id) {
		$where = array('id' => $id);

		$result = $this->Sl->getOne($this->table, $where);

		return $result;
	}

	/**
	 * [getList 通过参数获得产品列表]
	 * @param  [arr] $param [参数数组]
	 * @param  [str/arr] $type  [count时返回总数，数组时返回列表，支持分页]
	 * @return [arr]        [产品列表数组]
	 */
	public function getList ($data, $type = 'count') {
		$list = $this->Sl->getList($this->table, $data, $type);

		return $list;
	}
}
