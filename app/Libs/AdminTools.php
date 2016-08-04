<?php
class AdminTools {
	//获取列表页翻页html
	public function getListPageStr ($page, $pageSize, $count, $url, $param) {
		if ($count > 0) {
			$pageCount = ceil($count / $pageSize);
		} else {
			$pageCount = 1;
		}
		$pageStart = $pageEnd = 0;

		if ($page != 1) {
			$pageStr = '<li><a href="' . $url . ($page - 1) . $param . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		} else {
			$pageStr = '<li class="disabled"><a href="javascript:void(0);" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		}

		if ($pageCount > 5) {
			if ($page > 3) {
				$pageStart = $page - 2;
				$pageStart = ($pageCount - $page > 1) ? $pageStart : $pageStart - (2 - ($pageCount - $page));
			} else {
				$pageStart = 1;
			}
			if ($page + 2 < $pageCount) {
				$pageEnd = $page + 2;
				$pageEnd = ($pageEnd >= 5) ? $pageEnd : 5;
			} else {
				$pageEnd = $pageCount;
			}

			if ($pageStart != 1) {
				$pageStr .= '<li><a href="' . $url . '1' . $param . '">1</a></li><li class="disabled"><a>...</a></li>';
			}
			for ($i = $pageStart; $i <= $pageEnd; $i++) {
				if ($i != $page) {
					$pageStr .= '<li><a href="' . $url . $i . $param . '">' . $i . '</a></li>';
				} else {
					$pageStr .= '<li class="active"><a href="javascript:void(0);">' . $i . '</a></li>';				
				}
			}
			if ($pageEnd != $pageCount) {
				$pageStr .= '<li class="disabled"><a>...</a></li><li><a href="' . $url . $pageCount . $param . '">' . $pageCount . '</a></li>';
			}
		} else {
			for ($i=1; $i <= $pageCount; $i++) { 
				if ($i != $page) {
					$pageStr .= '<li><a href="' . $url . $i . $param . '">' . $i . '</a></li>';
				} else {
					$pageStr .= '<li class="active"><a href="javascript:void(0);">' . $i . '</a></li>';				
				}
			}
		}

		if ($page != $pageCount) {
			$pageStr .= '<li><a href="' . $url . ($page + 1) . $param . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		} else {
			$pageStr .= '<li class="disabled"><a href="javascript:void(0);" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		}

		return $pageStr;
	}

	/**
	 * 请用框架内方法代替
	 * [getPage 获取模板数据]
	 * @param  [type] $page [description]
	 * @return [type]       [description]
	 */
	public function getPage ($page) {
		$viewPath = realpath(base_path('resources/views'));
		switch ($page) {
			case 'header':
				$str = file_get_contents($viewPath . '/manage/header.php');
				break;
			
			case 'footer':
				$str = file_get_contents($viewPath . '/manage/footer.php');
				break;
			
			case 'productmenu':
				$str = file_get_contents($viewPath . '/manage/product_menu.php');
				break;
			
			case 'brandmenu':
				$str = file_get_contents($viewPath . '/manage/brand_menu.php');
				break;
	
			case 'editormenu':
				$str = file_get_contents($viewPath . '/manage/editor_menu.php');
				break;
			
			default:
				$str = "";
				break;
		}

		return $str;
	}

	/**
	 * 请用框架内方法代替
	 * [show404 显示404]
	 * @return [type] [description]
	 */
	public function show404 () {
		header('HTTP/1.1 404 Not Found'); 
		header('status: 404 Not Found');
		exit();
	}

	/**
	 * [getIp 获取客户端IP地址]
	 * @return [type] [description]
	 */
	public function getIp () {
		if (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else if(getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else if(getenv("REMOTE_ADDR")) {
			$ip = getenv("REMOTE_ADDR");
		} else {
			$ip = "Unknow"; 
		}

		return $ip;
	}

	/**
	 * 请用框架内方法代替
	 * [redirect 301页面跳转]
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	public function redirect ($url) {
		ob_clean();
		header('HTTP/1.1 301 Moved Permanently');
		header ("Location:{$url}");
		die();
	}
}
