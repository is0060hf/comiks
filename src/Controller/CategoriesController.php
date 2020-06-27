<?php

	namespace App\Controller;

	use App\Utils\AjaxUtil;
	use App\Utils\FileUtil;
	use Cake\Datasource\ConnectionManager;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;
	use RuntimeException;

	/**
	 * Posts Controller
	 *
	 * @property \App\Model\Table\CategoriesTable $Categories
	 *
	 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class CategoriesController extends AppController {

		/**
		 * ログインしていなくてもアクセスできるページを定義する
		 * 投稿関連に関しては情報の閲覧も含めてログインが必要
		 * @param Event $event
		 */
		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
			$this->Auth->allow(['ajaxGetCategoryIndex',
					'ajaxUpdateFeaturedImagePath',
					'ajaxDeleteFeaturedImagePath']);
		}

		public function isAuthorized($user) {
			// 誰でも実行を許可する
			if (in_array($this->request->getParam('action'), ['ajaxGetCategoryIndex',
					'ajaxUpdateIconImagePath',
					'ajaxUpdateFeaturedImagePath',
					'ajaxDeleteIconImagePath',
					'ajaxDeleteFeaturedImagePath'])) {
				return true;
			}

			// 本人のみ許可するアクション(各アクションで処理)
			if (in_array($this->request->getParam('action'), ['index', 'view', 'add', 'edit', 'delete', 'deleteFromPageName', 'deleteDefaultFeaturedImageOnEdit'])) {
				return true;
			}

			return parent::isAuthorized($user);
		}

		/**
		 * フォームで指定されたカテゴリの
		 * アイキャッチデータを更新する
		 * @return array|string|null
		 */
		public function ajaxUpdateFeaturedImagePath() {
			$this->autoRender = FALSE;
			$category_id = $this->request->getData('category_id');
			$file = $this->request->getData('file');
			$dir_name = '/'.FILE_UPLOAD_DIRECTORY_NAME;
			$dirFullPath = realpath(WWW_ROOT.$dir_name);

			$status = false;
			$result = [];
			$error = [];

			$category = TableRegistry::get('Categories')->find('All')->where(['id' => $category_id])->first();

			if (!is_null($file)) {
				if ($file['tmp_name'] != '') {
					if ($category) {
						if ($category->default_featured_image_path != '') {
							FileUtil::deleteFile($category->default_featured_image_path);
						}
						$uploadResult = FileUtil::file_upload($file, $dirFullPath, UPLOAD_ICON_IMAGE_CAPACITY);
						// ファイル情報をDBへ登録
						$category->default_featured_image_path = $dir_name.'/'.$uploadResult['path'];

						if (TableRegistry::get('Categories')->save($category)) {
							$status = true;
						} else {
							$error = array(
									'message' => 'データ更新に失敗しました。',
									'code' => RES_INTERNAL_SERVER_ERROR,
							);
						}
					} else {
						$error = array(
								'message' => '指定のカテゴリが存在しません。',
								'code' => RES_BAD_REQUEST,
						);
					}
				} else {
					$error = array(
							'message' => '[ERR001]アップロードファイルが存在しません。',
							'code' => RES_BAD_REQUEST,
					);
				}
			} else {
				$error = array(
						'message' => '[ERR002]アップロードファイルが存在しません。',
						'code' => RES_BAD_REQUEST,
				);
			}

			return $this->response->withType('application/json')
					->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
		}

		/**
		 * フォームで指定されたカテゴリの
		 * アイキャッチデータを削除する
		 * @return \Cake\Http\Response
		 */
		public function ajaxDeleteFeaturedImagePath() {
			$this->autoRender = FALSE;
			$category_id = $this->request->getData('category_id');

			$status = false;
			$result = [];
			$error = [];

			$category = TableRegistry::get('Categories')->find('All')->where(['id' => $category_id])->first();

			if ($category) {
				FileUtil::deleteFile($category->default_featured_image_path);
				$category->default_featured_image_path = null;

				if (TableRegistry::get('Categories')->save($category)) {
					$status = true;
				} else {
					$error = array(
							'message' => 'データ更新に失敗しました。',
							'code' => RES_INTERNAL_SERVER_ERROR,
					);
				}
			} else {
				$error = array(
						'message' => '指定のカテゴリが存在しません。',
						'code' => RES_BAD_REQUEST,
				);
			}

			return $this->response->withType('application/json')
					->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
		}

		/**
		 * カテゴリの一覧画面
		 */
		public function index() {
			$this->viewBuilder()->setLayout('metrica_index_layout');

			if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
				// 管理者は全件表示させる
				$categories = $this->Categories->find('All');
			} else {
				// 自身が登録したカテゴリを全件取得
				$categories = $this->Categories->find('All')->where(['user_id' => $this->request->session()->read('Auth.User.id')]);
			}

			$this->set(compact('categories'));
		}

		/**
		 * カテゴリの詳細画面
		 *
		 * @return \Cake\Http\Response|null
		 */
		public function view() {
			$category_id = $this->request->getQuery('id');
			if ($category_id) {
				$this->viewBuilder()->setLayout('metrica_view_layout');
				$category = $this->Categories->find('All')->where(['id' => $category_id])->first();

				if ($category) {
					if ($this->request->session()->read('Auth.User.user_role') != ROLE_SYSTEM && $this->request->session()->read('Auth.User.id') != $category->user_id) {
						$this->Flash->error(__('ご指定の操作は権限がありません。'));
						return $this->redirect(['controller' => 'Categories',
								'action' => 'index']);
					}
					$this->set(compact('category'));
				} else {
					$this->Flash->error(__('指定のカテゴリが存在しません。'));
					return $this->redirect(['controller' => 'Categories', 'action' => 'index']);
				}
			} else {
				$this->Flash->error(__('ユーザーIDが指定されていません。'));
				return $this->redirect(['controller' => 'Categories', 'action' => 'index']);
			}
		}

		/**
		 * カテゴリの登録画面
		 *
		 * @return \Cake\Http\Response|null
		 */
		public function add() {
			$this->viewBuilder()->setLayout('metrica_editor_layout');

			$category = $this->Categories->newEntity();
			if ($this->request->is('post')) {
				// 入力内容のセット
				$category = $this->Categories->patchEntity($category, $this->request->getData());

				// ページ登録処理
				if ($this->Categories->save($category)) {
					$this->Flash->success(__('カテゴリを登録しました。'));

					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('入力エラーが発生しました。'));
					$this->set(compact('category'));
					$this->render("add");
				}
			}
			$this->set(compact('category'));
		}

		/**
		 * カテゴリ編集画面
		 *
		 * @return \Cake\Http\Response|null
		 */
		public function edit() {
			$categoryId = $this->request->getQuery('id');

			if ($categoryId) {
				$this->viewBuilder()->setLayout('metrica_editor_layout');
				$category = $this->Categories->find('All')->where(['id' => $categoryId])->first();

				if ($category) {
					if ($this->request->is(['patch', 'post', 'put'])) {
						if ($this->request->session()->read('Auth.User.user_role') != ROLE_SYSTEM && $this->request->session()->read('Auth.User.id') != $category->user_id) {
							$this->Flash->error(__('ご指定の操作は権限がありません。'));
							return $this->redirect(['controller' => 'Categories',
									'action' => 'index']);
						}

						// 入力内容のセット
						$category = $this->Categories->patchEntity($category, $this->request->getData());

						// ページ登録処理
						if ($this->Categories->save($category)) {
							$this->Flash->success(__('カテゴリを登録しました。'));
							return $this->redirect(array('action' => 'view', '?' => ['id' => $category->id]));
						} else {
							$this->Flash->error(__('入力エラーが発生しました。'));
							$this->set(compact('category'));
							$this->render("edit");
						}
					}
				} else {
					$this->Flash->error(__('指定のカテゴリが存在しません。'));
					return $this->redirect(['controller' => 'Categories', 'action' => 'index']);
				}
			} else {
				$this->Flash->error(__('カテゴリIDが指定されていません。'));
				return $this->redirect(['controller' => 'Categories', 'action' => 'index']);
			}
			$this->set(compact('category'));
		}

		/**
		 * カテゴリ削除
		 *
		 * @param string|null $id Post id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->autoRender = FALSE;
			$category = $this->Categories->get($id);

			if ($this->request->session()->read('Auth.User.user_role') != ROLE_SYSTEM && $this->request->session()->read('Auth.User.id') != $category->user_id) {
				$this->Flash->error(__('ご指定の操作は権限がありません。'));
				return $this->redirect(['controller' => 'Categories',
					'action' => 'index']);
			}
			$this->request->allowMethod(['post', 'delete']);

			// ユーザーを削除するときには紐づく画像も削除する
			FileUtil::deleteDefaultFeaturedImageOnEdit($category, $this->Categories);


			if ($this->Categories->delete($category)) {
				$this->Flash->success(__('カテゴリを削除しました。'));
			} else {
				$this->Flash->error(__('削除エラーが発生しました。'));
			}

			return $this->redirect(['action' => 'index']);
		}

		/**
		 * ユーザーに紐づくカテゴリを全て削除する
		 *
		 * @return \Cake\Http\Response|null Redirects to index.
		 */
		public function deleteFromUserId() {
			$this->autoRender = FALSE;
			$this->request->allowMethod(['post', 'delete']);
			$user_id = $this->request->getQuery('user_id');

			if ($user_id) {
				if ($this->request->session()->read('Auth.User.user_role') != ROLE_SYSTEM && $this->request->session()->read('Auth.User.id') != $user_id) {
					$this->Flash->error(__('ご指定の操作は権限がありません。'));
					return $this->redirect($this->referer());
				}

				$categories = $this->Categories->find('All')->where(['user_id' => $user_id])->all();

				// トランザクション開始
				$connection = ConnectionManager::get('default');
				$connection->begin();

				foreach ($categories as $category) {
					if ($this->Categories->delete($category)) {
						continue;
					} else {
						$this->Flash->error(__('削除エラーが発生しました。'));
						$connection->rollback();
						return $this->redirect($this->referer());
					}
				}

				$connection->commit();
				$this->Flash->success(__('ユーザーに紐づくカテゴリを全て削除しました。'));
				return $this->redirect($this->referer());
			} else {
				$this->Flash->error(__('カテゴリの削除に必要な情報が足りません。'));
				return $this->redirect($this->referer());
			}
		}

		/**
		 * カテゴリ情報の一覧をJSON形式で取得する
		 *
		 * ■取得条件
		 * ・自身が登録したカテゴリ
		 *
		 * @return \Cake\Http\Response
		 */
		function ajaxGetCategoryIndex() {
			$this->autoRender = FALSE;
			$status = false;

			if (!$this->request->is('ajax')) {
				$result = [];
				$error = array(
						'message' => '不正なアクセスです。' . $this->request->getMethod(),
						'code' => RES_BAD_REQUEST,
				);
			} else {
				$user_id = $this->request->getQuery('user_id');
				if ($user_id) {
					if (AjaxUtil::isCorrectUserId($user_id)) {
						// 自身が登録したカテゴリに限る
						$conditions['user_id'] = $user_id;

						$categories = $this->Categories->find('All', ['conditions' => $conditions]);
						$status = !is_null($categories);

						if ($status) {
							$result = [
									'categories' => $categories->toList(),
							];
							$error = [
									'message' => '正常にカテゴリが取得できました。',
									'code' => RES_OK,
							];
						} else {
							$result = [
									'posts' => [],
							];
							$error = [
									'message' => 'カテゴリが登録されておりません。',
									'code' => RES_OK,
							];
						}
					} else {
						$result = [];
						$error = array(
								'message' => 'ユーザー情報が間違っています。',
								'code' => RES_UNAUTHORIZED,
						);
					}
				} else {
					$result = [];
					$error = array(
							'message' => 'ユーザー情報を入力してください。',
							'code' => RES_UNAUTHORIZED,
					);
				}
			}

			AjaxUtil::setCorsHeaders($this);

			// json_encodeを使用してJSON形式で返却
			return $this->response->withType('application/json')
					->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
		}

		/**
		 * 編集画面にてデフォルトアイキャッチ画像を削除するためのメソッド
		 *
		 * @param null $id
		 * @return mixed
		 *
		 * 権限：誰でも
		 * ログイン要否：要
		 * 画面遷移：なし
		 */
		public function deleteDefaultFeaturedImageOnEdit($id = null) {
			$this->request->allowMethod(['post',
				'delete']);
			$category = $this->Categories->get($id);

			if (FileUtil::deleteDefaultFeaturedImageOnEdit($category, $this->Categories)) {
				$this->Flash->success(__('デフォルトアイキャッチ画像を削除しました。'));
			} else {
				$this->Flash->error(__('デフォルトアイキャッチ画像の削除に失敗しました。'));
			}

			$this->set(compact('user'));
			return $this->redirect($this->referer());
		}
	}
