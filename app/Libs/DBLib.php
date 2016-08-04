<?php
/*
* 路径: \app\Libs\DBLib.php
* 描述: PdoMysSQL操作封装库文件
* 作者: Ray
* 日期: 2015.4.26
* 备注: 
*/
class DBLib {

	private $db;
	private $dbParam;
	private $sql;
	public $debug;

	/**
	 * [__construct 初始化]
	 * 获取数据库配置文件，链接数据库
	 */
	public function __construct ($dbName = '') {
		$config = array(
			'write' => array(
				'host' => 'localhost;port=3306',
				'user' => 'root',
				'pass' => 'abc123',
				'db'   => 'bbmst',
				'charset' => 'utf8',
				'charsetClient'=>'utf8',
				'log'  => false
			),
			'read' => array(
				'host' => 'localhost;port=3306',
				'user' => 'root',
				'pass' => 'abc123',
				'db'   => 'bbmst',
				'charset' => 'utf8',
				'charsetClient'=>'utf8',
				'log'  => false
			)
		);
		$this->dbParam = $config[$dbName];
		$this->connect();
	}

	/**
	 * [__destruct 析构函数]
	 * 关闭数据库，根据debug打印sql语句
	 */
	public function __destruct () {
		$this->close();
		if ($this->debug == 1) {
			echo $this->sql . "\r\n";
		}
	}

	/**
	 * [connect 连接数据库]
	 * 设置本地prepare为false，设置编码utf-8
	 * @return [null] 
	 */
	public function connect () {
		try {
			$this->db = new \PDO('mysql:host=' . $this->dbParam['host'] . ';dbname=' . $this->dbParam['db'] . ';charset=' . $this->dbParam['charset'], $this->dbParam['user'], $this->dbParam['pass']);
		} catch ( PDOException $e ) {
			die ("Connect Error Infomation:" . $e->getMessage ());
		}

		$this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		$this->db->query('set names utf8;');
	}

	/**
	 * [close 关闭数据库]
	 * @return [null] 
	 */
	public function close () {
		$this->db = null;
	}

	/**
	 * [getFields 获取列信息]
	 * @param  [str] $table [表名]
	 * @return [arr]        [表中列信息]
	 */
	public function getFields ($table) {
		$temp = $this->db->query("DESCRIBE $table");
		$result = $temp->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * [getInsertId 获取最后插入数据ID]
	 * @return [int] [数据ID]
	 */	
	public function getInsertId () {
		return $this->db->lastInsertId();
	}

	/**
	 * [add 插入数据]
	 * @param [str] $table [表名]
	 * @param [arr] $args  [数据数组]
	 */
	public function add ($table, $args) {
		$param = $this->getParam($args);

		$this->sql = "INSERT INTO `$table` SET " . $param['param'];

		$result = $this->exec($this->sql, $param['bind'], false);

		if ($result) {
			return $this->getInsertId();
		} else {
			return false;
		}
	}

	/**
	 * [update 更新数据]
	 * @param  [str] $table [表名]
	 * @param  [arr] $where [where条件数组]
	 * @param  [arr] $args  [更新数据数组]
	 * @return [int]        [更新条数]
	 */
	public function update ($table, $where, $args) {
		$param = $this->getParam($args);
		$filter = $this->getWhere($where);

		$bind = array_merge($param['bind'], $filter['bind']);
		$this->sql = "UPDATE `$table` SET " . $param['param'] . $filter['param'];

		$result = $this->exec($this->sql, $bind, false);

		return $result;
	}

	/**
	 * [del 逻辑删除数据]
	 * @param  [str] $table [表名]
	 * @param  [arr] $where [where条件数组]
	 * @param  [str] $flag  [删除标记位]
	 * @return [int]        [删除条数]
	 */
	public function del ($table, $where, $flag) {
		$param = array($flag => 1);

		$result = $this->update($table, $where, $param);

		return $result;
	}

	/**
	 * [rm 物理删除数据]
	 * @param  [str] $table [表明]
	 * @param  [arr] $where [where条件]
	 * @return [int]        [物理删除条数]
	 */
	public function rm ($table, $where) {
		$filter = $this->getWhere($where);

		$this->sql = "DELETE FROM `$table` " . $filter['param'];

		$result = $this->exec($this->sql, $filter['bind'], false);

		return $result;
	}

	/**
	 * [getOne 获取一条数据]
	 * @param  [str] $table [表名]
	 * @param  [arr] $where [where条件]
	 * @return [arr]        [结果数组]
	 */
	public function getOne ($table, $where) {
		$filter = $this->getWhere($where);

		$this->sql = "SELECT * FROM `$table` " . $filter['param'];

		$result = $this->exec($this->sql, $filter['bind'], 'fetch');

		return $result;
	}

	/**
	 * [getAll 获取表所有数据]
	 * @param  [str] $table [表名]
	 * @return [arr]        [结果数组]
	 */
	public function getAll ($table) {
		$this->sql = "SELECT * FROM `$table`";

		$result = $this->exec($this->sql, array(), 'fetchAll');

		return $result;
	}

	/**
	 * [getList 按条件获取数据，支持分页排序总数]
	 * @param  [str] $table [表名]
	 * @param  [arr] $where [where条件]
	 * @param  [arr/str] $type  [获取方式：count，总数；数组分页，排序]
	 * @return [arr]        [结果数组]
	 */
	public function getList ($table, $where, $type = 'count') {
		$filter = $this->getWhere($where);

		if (is_array($type)) {
			if (isset($type['page'])) {
				$limit = " LIMIT " . (($type['page'] - 1) > 0 ? ($type['page'] - 1) * $type['pageSize'] : 0) . ", " . $type['pageSize'];
			} elseif (isset($type['limit'])) {
				$limit = " LIMIT " . $type['limit'][0] . ", " . $type['limit'][1];
			} else {
				$limit = '';
			}
			if (isset($type['order'])) {
				$order = " ORDER BY ".$type['order'];
			} else {
				$order = '';
			}
			$this->sql = "SELECT * FROM `$table`" . $filter['param'] . $order . $limit;

			$result = $this->exec($this->sql, $filter['bind'], 'fetchAll');

			if (!empty($result)) {
				return $result;
			} else {
				return array();
			}
		} else {
			$this->sql = "SELECT COUNT(id) AS total FROM `$table`" . $filter['param'];

			$result = $this->exec($this->sql, $filter['bind'], 'fetch');

			return $result['total'];
		}
	}

	/**
	 * [query 直接执行sql语句]
	 * @param  [str]  $sql  [sql语句]
	 * @param  [arr]  $bind [绑定数据数组]
	 * @param  [bool/str] $type [获取方式]
	 * @return [arr]        [结果数组]
	 */
	public function query ($sql, $bind, $type = false) {
		$this->sql = $sql;

		if (is_array($bind)) {
			$result = $this->exec($this->sql, $bind, $type);
		} else {
			$result = $this->db->exec($this->sql);
		}

		return $result;
	}

	/**
	 * [exec 执行sql]
	 * @param  [str]  $sql  [sql语句]
	 * @param  [arr]   $args [绑定数据]
	 * @param  [bool/str] $type [结果方式：false，执行；fetch，获取一条；fetchAll，获取所有]
	 * @return [arr／int]        [结果]
	 */
	private function exec ($sql, $args = array(), $type = false) {
		$prepare = $this->db->prepare($sql);

		if ($prepare) {
			if (!empty($args)) {
				foreach ($args as $key => $val) {
					if(is_array($val)){
						$prepare->bindValue($key, $val[0], $val[1]);
					}else{
						$prepare->bindValue($key, $val);
					}
				}
			}

			$result = $prepare->execute();

			if ($type) {
				if ($type == 'fetchAll') {
					$list = $prepare->fetchAll(\PDO::FETCH_ASSOC);
				} else {
					$list = $prepare->fetch(\PDO::FETCH_ASSOC);
				}
				if (!empty($list)) {
					return $list;
				} else {
					return array();
				}
			} else {
				return $result;
			}
		} else {
			if ($type) {
				return array();
			} else {
				return false;
			}
		}
	}

	/**
	 * [getParam 根据数组整理插入更新语句，返回sql语句及绑定数组]
	 * @param  [arr] $args [数据数组]
	 * @return [arr]       [结果数组：param,sql语句；bind,绑定数组]
	 */
	public function getParam ($args) {
		$param = '';
		$temp = '';
		$bind = array();

		if (is_array ($args)) {
			foreach ($args as $k => $v) {
				$temp .= ", `$k` = :$k";
				$bind[":$k"] = $v;
			}
			$param = substr($temp, 2);
		}

		$result = array('param' => $param, 'bind' => $bind);
		return $result;
	}

	/**
	 * [getWhere 根据数组整理where条件语句，返回sql语句及绑定数组]
	 * @param  [arr] $args [条件数组]
	 * @return [arr]       [结果数组：param,sql语句；bind,绑定数组]
	 */
	public function getWhere ($args) {
		$param = '';
		$temp = '';
		$bind = array();

		if (is_array ($args)) {
			if (!empty($args)) {
				foreach ($args as $k => $v) {
					if ($k != 'where') {
						if (strpos($k, '.')) {
							$kArr = explode(".", $k);
							$temp .= " AND {$kArr[0]}.`{$kArr[1]}` = :{$kArr[0]}_{$kArr[1]}";
							$bind[":{$kArr[0]}_{$kArr[1]}"] = $v;
						} else {
							$temp .= " AND `$k` = :$k";
							$bind[":$k"] = $v;
						}
					} elseif ($v != '') {
						$temp .= $v['sql'];
						$bind = array_merge($bind, $v['bind']);
					}
				}
				$param = ' WHERE' . substr($temp, 4);
			}
		}

		$result = array('param' => $param, 'bind' => $bind);
		return $result;
	}
}