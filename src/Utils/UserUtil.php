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

class UserUtil {

	/**
	 * カテゴリIDからカテゴリ名を取得する
	 * @param $user_id
	 * @return string
	 */
	static public function getUserNameFromId($user_id) {
		$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();

		if ($user) {
			return $user->login_name;
		}
		return '';
	}

	/**
	 * SNSリンクとアイコンからボタン生成して返す
	 * @param $sns_link
	 * @param $icon
	 * @param $btn_class
	 * @return string
	 */
	static public function getSNSButton($sns_link, $icon, $btn_class) {
		if ($sns_link) {
			return '<a href="'.$sns_link.'" target="_blank" class="btn '.$btn_class.' btn-circle"><i class="fab '.$icon.'"></i></a>';
		}
		return '';
	}

	static public function getContactList($user_id) {
		return TableRegistry::get('Contacts')->find('All')->where(['user_id' => $user_id])->all();
	}
}
