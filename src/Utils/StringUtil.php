<?php
/**
 * Created by PhpStorm.
 * User: SOLA2
 * Date: 2019/09/29
 * Time: 17:24
 */

namespace App\Utils;

use App\Controller\AppController;

class StringUtil {

	/**
	 * 指定した文字列を超える場合は文字数以下を削除したものを返す
	 * @param $text
	 * @param int $limit
	 * @return string
	 */
	static public function getLimitedLengthStr($text, $limit = 32) {
		if(mb_strlen($text) > $limit) {
			$resultStr = mb_substr($text,0,$limit-2);
			return $resultStr.'...';
		} else {
			echo $text;
		}
	}
}
