<?php
/**
 *
 * author: dupeng
 * createTime: 2016/10/8 15:27
 */

namespace common\components;


use yii\web\Controller;

class XController extends Controller {
	protected $time = 0;
	protected $response = ['code'=>1, 'msg'=>'', 'status'=>200];

	public function init(){
		parent::init();
		$this->time = time();
	}

	/**
	 * 分页
	 * @param        $currpage
	 * @param        $perpage
	 * @param        $nums
	 * @param        $q
	 * @param string $currPageStyle
	 * @param string $othersPageStyle
	 *
	 * @return bool|string
	 */
	public function pager ( $currpage, $perpage, $nums, $q, $currPageStyle = '', $othersPageStyle = '' ) {
		if ( $nums <= 1 ) return false;
		$dp        = 10; /* 分页链接的数量 */
		$nums      = intval ( $nums );
		$maxPages  = ceil ( $nums / $perpage );
		$pageStart = 1;
		if ( $maxPages == 0 ) $maxPages = 1;
		if ( $currpage > $maxPages ) $currpage = $maxPages;
		if ( $currpage <= 1 ) {
			$s         = "<li><a href='javascript:void(0);'>上页</a></li> ";
			$pageStart = 1;
			$currpage  = 1;
			$pageEnd   = $dp;
		} else {
			$tmp = $currpage - 1;
			$s   = "<li><a href=\"" . str_replace ( urlencode ( '{page}' ), $tmp, $q ) . "\">上页</a></li> ";
			/*** 下面开始计算 1--$dp 以后的 $pageStart ***/
			$rangeOrder = floor ( ( $currpage - 2 ) / ( $dp - 2 ) );
			$pageStart  = $rangeOrder * ( $dp - 2 ) + 1;
			$pageEnd    = $pageStart + $dp - 1;
		}

		for ( $i = $pageStart; $i <= $pageEnd; $i++ ) {
			if ( $i > $maxPages ) break;
			if ( $i != $currpage ) {
				$s .= '<li><a href="' . str_replace ( urlencode ( '{page}' ), $i, $q ) . '" class="' . $othersPageStyle . '">' . $i . '</a></li> ';
			} else {
				$s .= '<li class="' . $currPageStyle . '"><a href="javascript:void(0);">' . $i . '</a></li> ';
			}
		}
		if ( $currpage >= $maxPages ) {
			$s .= '<li><a href="javascript:void(0);">下页</a></li>';
		} else {
			$tmp = $currpage + 1;
			$s .= "<li><a href=\"" . str_replace ( urlencode ( '{page}' ), $tmp, $q ) . "\">下页</a></li>";
		}

		return $s;
	}
}