<?php
/**
 * Created by PhpStorm.
 * User: SOLA2
 * Date: 2019/09/29
 * Time: 17:24
 */

namespace App\Utils;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class AjaxUtil {

	/**
	 * 指定のユーザーが存在するかどうかを返す
	 * @param $user_id
	 * @return bool
	 */
	static public function isCorrectUserId($user_id) {
		$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();
		if ($user) {
			return true;
		}
		return false;
	}

	/**
	 * Ajaxを返すときにヘッダーに必要な情報を追加する処理
	 * @param AppController $appController
	 */
	static public function setCorsHeaders(AppController $appController) {
		$appController->response->withHeader('Access-Control-Allow-Origin', '*');
		$appController->response->withHeader('Access-Control-Allow-Methods', '*');
		$appController->response->withHeader('Access-Control-Allow-Headers', 'X-Requested-With');
		$appController->response->withHeader('Access-Control-Allow-Headers', 'C​​ontent-Type、x-xsrf-token');
		$appController->response->withHeader('Access-Control-Max-Age', '172800');
	}
}
