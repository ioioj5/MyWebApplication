<?php
namespace common\components;

use Yii;
use yii\console\Controller;

class ConsoleBaseController extends Controller {
	public $time = 0;
	public $fp = null;

	public function init(){
		parent::init();
		$this->time = time();
	}

	/**
	 * 打开文件句柄
	 *
	 * @param string $fileName
	 */
	public function openFp ($fileName = '') {
		$runtimePath = Yii::$app->getRuntimePath();
		$this->fp = fopen ( $runtimePath . '/logs/'.$fileName.'_' . date ( "Y-m-d", time () ) . '.txt', "a" );

		flock ( $this->fp, LOCK_EX );
		$logMsg = "# time: " . date ( "Y-m-d H:i:s", time () ) . "\n";
		fwrite ( $this->fp, $logMsg );
	}
	/**
	 * 记录日志
	 */
	public function log ( $data ) {
		$logMsg = '';
		$date   = date ( 'Y-m-d H:i:s', time () );
		$i = 0;
		if ( ! empty( $data ) ) {
			if ( is_array ( $data ) ) {
				$count = count ( $data );
				foreach ( $data as $dataK => $dataV ) {
					if ( $i == 0 ) {
						$logMsg .= '[' . $dataK . '=>' . $dataV . ', ';
					} elseif ( $i == ( $count - 1 ) ) {
						$logMsg .= $dataK . '=>' . $dataV . "]";
					} else {
						$logMsg .= $dataK . '=>' . $dataV . ',';
					}
					$i++;
				}
			} else {
				$logMsg .= $data;
			}
		}
		fwrite ( $this->fp, $logMsg );
	}
	/**
	 * 关闭文件句柄
	 */
	public function closeFp () {
		flock ( $this->fp, LOCK_UN );
		fclose ( $this->fp );
	}


}