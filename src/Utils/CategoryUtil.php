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

class CategoryUtil {

	/**
	 * カテゴリIDからカテゴリ名を取得する
	 * @param $category_id
	 * @return string
	 */
	static public function getCategoryNameFromId($category_id) {
		$category = TableRegistry::get('Categories')->find('All')->where(['id' => $category_id])->first();

		if ($category) {
			return $category->category_name;
		}
		return '';
	}

	/**
	 * 指定のユーザーで登録されているカテゴリの一覧を取得する
	 * @param $user_id
	 * @return array
	 */
	static public function getCategoryListFromUserId($user_id) {
		return TableRegistry::get('Categories')->find('All')->where(['user_id' => $user_id])->toArray();
	}

	static public function getDefaultFeaturedImagePath($category_id) {
		$category = TableRegistry::get('Categories')->find('All')->where(['id' => $category_id])->first();

		if ($category) {
			return $category->default_featured_image_path;
		}
		return null;
	}
}
