<?php
/**
 * Created by PhpStorm.
 * User: SOLA2
 * Date: 2019/09/29
 * Time: 17:24
 */

namespace App\Utils;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Psr\Log\LogLevel;
use RuntimeException;
use Cake\Filesystem\File;

class FileUtil {
	static public function file_db_registration($path) {
		$table = TableRegistry::get('UploadedFiles');
		$newEntity = $table->newEntity();
		$newEntity->file_path = $path;
		return $table->save($newEntity);
	}

	static public function file_upload($file = null, $dir = null, $limitFileSize = 1024 * 1024) {
		try {
			// ファイルを保存するフォルダ $dirの値のチェック
			if ($dir) {
				if (!file_exists($dir)) {
					throw new RuntimeException('指定のディレクトリがありません。');
				}
			} else {
				throw new RuntimeException('ディレクトリの指定がありません。');
			}

			// 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
			if (!isset($file['error'])) {
				throw new RuntimeException('Invalid parameters.');
			}

			// エラーのチェック
			switch ($file['error']) {
				case 0:
					break;
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Exceeded filesize limit.');
				default:
					throw new RuntimeException('Unknown errors.');
			}

			if (is_array($file['error'])) {
				throw new RuntimeException('複数のファイルが同時にアップされました'.$file['error']);
			}

			// ファイル情報取得
			$fileInfo = new File($file["tmp_name"]);

			// ファイルサイズのチェック
			$fileSize = $fileInfo->size();
			if ($fileSize > $limitFileSize) {
				throw new RuntimeException('Exceeded filesize limit.');
			}

			// ファイルタイプのチェックし、拡張子を取得
			if (false === $ext = array_search($fileInfo->mime(), MIME_TYPE, true)) {
				throw new RuntimeException('画像ファイル以外がアップロードされました。');
			}

			// ファイル名の生成
			//            $uploadFile = $file["name"] . "." . $ext;
			$now = microtime(true);
			$uploadFile = sha1($now.$file["tmp_name"]).".".$ext;
			Log::write('debug', $uploadFile);

			// ファイルの移動
			if (!move_uploaded_file($file["tmp_name"], $dir."/".$uploadFile)) {
				throw new RuntimeException('Failed to move uploaded file.');
			}

			// 処理を抜けたら正常終了
			//            echo 'File is uploaded successfully.';

		} catch (RuntimeException $e) {
			throw $e;
		}

		$returnValue = ['path' => $uploadFile,
			'ext' => $ext,
			'type' => MIME_TYPE[$ext],
			'name' => $file["name"],
			'size' => $fileSize,];

		return $returnValue;
	}

	/**
	 * 実データとアップロードファイルテーブルの該当レコードのみを削除する
	 * 関連テーブルのデータ更新は行わない
	 * @param $path
	 */
	static public function deleteFile($path) {
		if ($path != '') {
			if (file_exists(WWW_ROOT.$path)) {
				// ファイルが存在したら削除する
				unlink(WWW_ROOT.$path);

				// 削除後にアップロードファイルテーブルの該当レコードを削除する
				$uploadedFile = TableRegistry::get('UploadedFiles')->find('All')->where(['file_path' => $path])->first();
				if ($uploadedFile) {
					TableRegistry::get('UploadedFiles')->delete($uploadedFile);
				}
			}
		}
	}

	/**
	 * 編集画面にてアイコン画像を削除するためのメソッド
	 *
	 * @param $entity
	 * @param $table
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	static public function deleteIconImageOnEdit($entity, $table) {
		if ($entity->icon_image_path != '') {
			if (file_exists(WWW_ROOT.$entity->icon_image_path)) {
				unlink(WWW_ROOT.$entity->icon_image_path);
			}
		}

		$entity->icon_image_path = null;
		return $table->save($entity);
	}

	/**
	 * 編集画面にてデフォルトアイキャッチ画像を削除するためのメソッド
	 *
	 * @param $entity
	 * @param $table
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	static public function deleteDefaultFeaturedImageOnEdit($entity, $table) {
		if ($entity->default_featured_image_path != '') {
			if (file_exists(WWW_ROOT.$entity->default_featured_image_path)) {
				unlink(WWW_ROOT.$entity->default_featured_image_path);
			}
		}

		$entity->default_featured_image_path = null;
		return $table->save($entity);
	}



	/**
	 * 編集画面にてカバー画像を削除するためのメソッド
	 *
	 * @param $entity
	 * @param $table
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	static public function deleteCoverImageOnEdit($entity, $table) {
		if ($entity->cover_image_path != '') {
			if (file_exists(WWW_ROOT.$entity->cover_image_path)) {
				unlink(WWW_ROOT.$entity->cover_image_path);
			}
		}

		$entity->cover_image_path = null;
		return $table->save($entity);
	}

	/**
	 * ○○イメージテーブルの画像を削除するためのメソッド
	 *
	 * @param $entity
	 * @param $table
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	static public function deleteImageOnEdit($entity, $table) {
		if ($entity->image_path != '') {
			if (file_exists(WWW_ROOT.$entity->image_path)) {
				unlink(WWW_ROOT.$entity->image_path);
			}
		}

		return $table->delete($entity);
	}
}
