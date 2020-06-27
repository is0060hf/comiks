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

class PostUtil {
	/**
	 * 指定のユーザーが投稿した記事一覧を取得する
	 * @param $user_id
	 * @return array
	 */
	static public function getPostListFromUserId($user_id) {
		return TableRegistry::get('Posts')->find('All')->where(['user_id' => $user_id])->toArray();
	}
}
