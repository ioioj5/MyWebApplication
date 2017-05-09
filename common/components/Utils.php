<?php
namespace common\components;

/**
 * 工具类
 * Class Utils
 * @package common\components
 */
class Utils {
	/**
	 * 获取客户端IP地址
	 * @return null|string
	 */
	static public function getClientIP () {
		static $ip = NULL;
		if ( $ip !== NULL )
			return $ip;
		if ( isset ( $_SERVER [ 'HTTP_X_FORWARDED_FOR' ] ) ) {
			$arr = explode ( ',', $_SERVER [ 'HTTP_X_FORWARDED_FOR' ] );
			$pos = array_search ( 'unknown', $arr );
			if ( false !== $pos )
				unset ( $arr [ $pos ] );
			$ip = trim ( $arr [ 0 ] );
		} elseif ( isset ( $_SERVER [ 'HTTP_CLIENT_IP' ] ) ) {
			$ip = $_SERVER [ 'HTTP_CLIENT_IP' ];
		} elseif ( isset ( $_SERVER [ 'REMOTE_ADDR' ] ) ) {
			$ip = $_SERVER [ 'REMOTE_ADDR' ];
		}
		// IP地址合法验证
		$ip = ( false !== ip2long ( $ip ) ) ? $ip : '0.0.0.0';

		return $ip;
	}

	/**
	 * 循环创建目录
	 *
	 * @param     $dir
	 * @param int $mode
	 *
	 * @return bool
	 */
	static public function mkdir ( $dir, $mode = 0777 ) {
		if ( is_dir ( $dir ) || @mkdir ( $dir, $mode ) )
			return true;
		if ( ! mkdir ( dirname ( $dir ), $mode ) )
			return false;

		return @mkdir ( $dir, $mode );
	}

	/**
	 * 格式化单位
	 *
	 * @param     $size
	 * @param int $dec
	 *
	 * @return string
	 */
	static public function byteFormat ( $size, $dec = 2 ) {
		$a   = array (
			"B",
			"KB",
			"MB",
			"GB",
			"TB",
			"PB"
		);
		$pos = 0;
		while ( $size >= 1024 ) {
			$size /= 1024;
			$pos++;
		}

		return round ( $size, $dec ) . " " . $a [ $pos ];
	}

	/**
	 * 过滤掉字符串内非法字符
	 *
	 * @param $string
	 *
	 * @return mixed
	 */
	static function filterStr ( $string ) {
		return str_replace ( array (
			'&',
			'"',
			'<',
			'>',
			',',
			'(',
			')',
			"'"
		), array (
			'&amp;',
			'&quot;',
			'&lt;',
			'&gt;',
			'&sbquo;',
			'（',
			'）',
			'&rsquo'
		), $string );
	}

	/**
	 * 格式化时间
	 *
	 * @param $beforeTime
	 *
	 * @return false|string
	 * @internal param $beforeTime
	 *
	 */
	static function format_date ( $beforeTime ) {
		$time  = time () - $beforeTime;
		$today = strtotime ( date ( "M-d-y", mktime ( 0, 0, 0, date ( "m" ), date ( "d" ), date ( "Y" ) ) ) );
		if ( $time <= 60 ) {
			return '刚刚';
		} elseif ( $time >= 60 && $time < 3600 ) {
			$return = intval ( $time / 60 ) . " 分钟前";
		} else {
			if ( $beforeTime > $today ) {
				$return = "今天 " . date ( "H:i", $beforeTime );
			} elseif ( $beforeTime < $today && $beforeTime > ( $today - 86400 ) ) {
				$return = "昨天 " . date ( "H:i", $beforeTime );
			} else {
				$return = date ( "Y-m-d H:i", $beforeTime );
			}
		}

		return $return;
	}

	/**
	 * 获取文件后缀
	 *
	 * @param $file
	 *
	 * @return string
	 */
	static function getExtension ( $file ) {
		return substr ( $file, strrpos ( $file, '.' ) + 1 );
	}

	/**
	 * 创建GUID
	 * @return string
	 */
	static function createGuid () {
		if ( function_exists ( 'com_create_guid' ) ) {
			return com_create_guid ();
		} else {
			mt_srand ( (double) microtime () * 10000 );//optional for php 4.2.0 and up.
			$charid = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
			$hyphen = chr ( 45 );// "-"
			$uuid   = chr ( 123 )// "{"
				. substr ( $charid, 0, 8 ) . $hyphen
				. substr ( $charid, 8, 4 ) . $hyphen
				. substr ( $charid, 12, 4 ) . $hyphen
				. substr ( $charid, 16, 4 ) . $hyphen
				. substr ( $charid, 20, 12 )
				. chr ( 125 );// "}"
			return $uuid;
		}
	}

	static function udate($format = 'u', $utimestamp = null) {
		if (is_null($utimestamp))
			$utimestamp = microtime(true);

		$timestamp = floor($utimestamp);
		$milliseconds = round(($utimestamp - $timestamp) * 1000000);

		return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
	}
}