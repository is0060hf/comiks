<?php

	namespace App\Controller;

	use App\Controller\AppController;
	use App\Utils\AjaxUtil;
	use App\Utils\CategoryUtil;
	use Cake\Event\Event;
	use Cake\Filesystem\File;
	use Cake\I18n\Time;
	use Cake\ORM\TableRegistry;
	use RuntimeException;

	/**
	 * Posts Controller
	 *
	 * @property \App\Model\Table\PostsTable $Posts
	 *
	 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class PostsController extends AppController {

		/**
		 * ログインしていなくてもアクセスできるページを定義する
		 * 投稿関連に関しては情報の閲覧も含めてログインが必要
		 * @param Event $event
		 * @return \Cake\Http\Response
		 */
		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
			$this->Auth->allow([
					'ajaxGetPostIndex',
					'ajaxGetPostLatestCategories',
					'ajaxGetPostView',
					'logout']);
		}

		public function isAuthorized($user) {
			// 誰でも許可するアクション
			if (in_array($this->request->getParam('action'), ['add',
					'index',
					'logout',
					'ajaxGetPostIndex',
					'ajaxGetPostView'])) {
				return true;
			}

			// 本人のみ許可するアクション(各アクションで処理)
			if (in_array($this->request->getParam('action'), ['view', 'edit', 'delete', 'deleteFeaturedImageOnEdit'])) {
				return true;
			}

			return parent::isAuthorized($user);
		}

		/**
		 * 記事の一覧画面
		 * @return \Cake\Http\Response|null
		 */
		public function index() {
			$this->viewBuilder()->setLayout('metrica_index_layout');

			$this->paginate = [
					'contain' => [],
					'limit' => 15,
			];

			$conditions = [];
			$sort = ['open_date' => 'desc'];

			// ソートに指定があれば設定する
			if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
				$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
			}

			// [必須]投稿者で絞り込む
			if ($this->request->session()->read('Auth.User.user_role') != ROLE_SYSTEM) {
				$conditions['user_id'] = $this->request->session()->read('Auth.User.id');
			}

			// 検索クリアボタンが押下された場合は必須条件のみ
			if ($this->request->getQuery('submit_btn') == 'search') {
				if ($this->request->getQuery('title') != '') {
					$conditions['title LIKE'] = '%'.$this->request->getQuery('title').'%';
				}
				if ($this->request->getQuery('category_id') != '-1') {
					$conditions['category_id'] = $this->request->getQuery('category_id');
				}
				if ($this->request->getQuery('upper_open_date') != '') {
					$conditions['open_date <='] = $this->request->getQuery('upper_open_date').' 23:59:59';
				}
				if ($this->request->getQuery('under_open_date') != '') {
					$conditions['open_date >='] = $this->request->getQuery('under_open_date');
				}
			}

			// 検索条件で投稿情報を取得する
			$posts = $this->paginate($this->Posts->find('all', ['order' => $sort, 'conditions' => $conditions]));

			$this->set(compact('posts'));
		}

		/**
		 * View method
		 *
		 * @return \Cake\Http\Response|null
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function view() {
			$post_id = $this->request->getQuery('id');
			if ($post_id) {
				$this->viewBuilder()->setLayout('metrica_view_layout');

				$post = $this->Posts->get($post_id, [
						'contain' => [],
				]);

				if ($post) {
					$this->set('post', $post);
				} else {
					$this->Flash->error(__('指定の記事が存在しません。'));
					return $this->redirect(['controller' => 'posts', 'action' => 'index']);
				}
			} else {
				$this->Flash->error(__('記事IDが指定されていません。'));
				return $this->redirect(['controller' => 'posts', 'action' => 'index']);
			}
		}

		/**
		 * Add method
		 *
		 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
		 */
		public function add() {
			$this->viewBuilder()->setLayout('metrica_editor_layout');

			$post = $this->Posts->newEntity();
			if ($this->request->is('post')) {
				$post = $this->Posts->patchEntity($post, $this->request->getData());

				// トピックスの投稿処理
				if ($this->Posts->save($post)) {
					$this->Flash->success(__('トピックスを登録しました。'));

					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('入力エラーが発生しました'));
					$this->set(compact('post'));
					$this->render("add");
				}
			}
			$this->set(compact('post'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id Post id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');

			$post = $this->Posts->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$post = $this->Posts->patchEntity($post, $this->request->getData());

				// ファイルのアップロード処理
				$dir = realpath(WWW_ROOT . "/upload_img");
				$limitFileSize = 20000000;

				try {
					if ($this->request->getData('featured_image')['tmp_name'] != "") {
						$this->log($this->request->getData('featured_image'));
						$uploadedFileName = $this->file_upload($this->request->getData('featured_image'), $dir, $limitFileSize);
						$post->featured_image = '/upload_img/' . $uploadedFileName;
					} elseif ($post->featured_image == '') {
						$post->featured_image = null;
					}

					if ($this->Posts->save($post)) {
						$this->Flash->success(__('トピックスを登録しました。'));
						return $this->redirect(array('action' => 'view', $id));
					} else {
						$this->Flash->error(__('入力エラーが発生しました'));
						$this->set(compact('post'));
						$this->render("edit");
					}

				} catch (RuntimeException $e) {
					$this->Flash->error(__('ファイルのアップロードができませんでした.'));
					$this->Flash->error(__($e->getMessage()));
				}
			}
			$this->set(compact('post'));
		}

		/**
		 * Delete method
		 *
		 * @param string|null $id Post id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$post = $this->Posts->get($id);

			if ($post->featured_image != '') {
				if (file_exists($post->featured_image)) {
					unlink(WWW_ROOT . $post->featured_image);
				}
			}

			if ($this->Posts->delete($post)) {
				$this->Flash->success(__('The post has been deleted.'));
			} else {
				$this->Flash->error(__('The post could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
		}

		public function file_upload($file = null, $dir = null, $limitFileSize = 1024 * 1024) {
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
				if (!isset($file['error']) || is_array($file['error'])) {
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

				// ファイル情報取得
				$fileInfo = new File($file["tmp_name"]);

				// ファイルサイズのチェック
				if ($fileInfo->size() > $limitFileSize) {
					throw new RuntimeException('Exceeded filesize limit.');
				}

				// ファイルタイプのチェックし、拡張子を取得
				if (false === $ext = array_search($fileInfo->mime(),
								['jpg' => 'image/jpeg',
										'png' => 'image/png',
										'gif' => 'image/gif',],
								true)) {
					throw new RuntimeException('画像ファイル以外がアップロードされました。');
				}

				// ファイル名の生成
				$uploadFile = sha1_file($file["tmp_name"]) . "." . $ext;

				// ファイルの移動
				if (!move_uploaded_file($file["tmp_name"], $dir . "/" . $uploadFile)) {
					throw new RuntimeException('Failed to move uploaded file.');
				}
			} catch (RuntimeException $e) {
				throw $e;
			}
			return $uploadFile;
		}

		/**
		 * 編集画面にてアイキャッチ画像を削除するためのメソッド
		 * @param null $id
		 * @return mixed
		 */
		public function deleteFeaturedImageOnEdit($id = null) {
			$post = $this->Posts->find('All')->where(['id' => $id])->first();

			if ($post->featured_image != '') {
				if (file_exists($post->featured_image)) {
					unlink(WWW_ROOT . $post->featured_image);
				}
			}

			$post->featured_image = null;
			if ($this->Posts->save($post)) {
				$this->Flash->success(__('アイキャッチ画像を削除しました。'));
			} else {
				$this->Flash->error(__('アイキャッチ画像の削除に失敗しました。'));
			}

			$this->set(compact('post'));
			return $this->redirect($this->referer());
		}

		/**
		 * 記事の一覧をJSON形式で取得する
		 *
		 * ■取得条件
		 * ・公開日を過ぎた記事
		 * ・公開設定がされている記事
		 * ・自身が登録した記事
		 *
		 * @return \Cake\Http\Response
		 */
		function ajaxGetPostIndex() {
			$this->autoRender = FALSE;
			$status = false;
			AjaxUtil::setCorsHeaders($this);

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
						// ペジネーション情報の設定
						$len = 15;
						if ($this->request->getQuery('len')) {
							$len = $this->request->getQuery('len');
						}

						// 本文の長さ
						$context_len = 60;
						if ($this->request->getQuery('context_len')) {
							$context_len = $this->request->getQuery('context_len');
						}

						$this->paginate = [
								'contain' => [],
								'limit' => $len,
								'order' => [
										'open_date' => 'desc'
								]
						];

						// クエリより検索条件の生成
						$conditions = [];
						$category = null;
						if ($this->request->getQuery('page_name_id') != '') {
							$categoryNamesCondition = [];
							$categoryNamesCondition['page_name_id'] = $this->request->getQuery('page_name_id');

							if ($this->request->getQuery('slug') != '') {
								$categoryNamesCondition['slug'] = $this->request->getQuery('slug');

								// 後でカテゴリ名を返すときに使用する
								$category = TableRegistry::get('CategoryNames')->find('All')->where(['slug' => $this->request->getQuery('slug')])->first();
							}

							$categoryNames = TableRegistry::get('CategoryNames')->find('All')->where($categoryNamesCondition);
							$categoryNamesIdList = [];
							$index = 0;
							foreach ($categoryNames as $categoryName) {
								$categoryNamesIdList[$index++] = $categoryName->category_id;
							}
							if ($index != 0) {
								$conditions['category_id IN'] = $categoryNamesIdList;
							} else {
								$result = [];
								$error = array(
										'message' => 'ページ指定が不正です。',
										'code' => RES_BAD_REQUEST,
								);

								// json_encodeを使用してJSON形式で返却
								return $this->response->withType('application/json')
										->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
							}
						}

						if ($this->request->getQuery('free_word') != '') {
							$conditions['title LIKE'] = '%' . $this->request->getQuery('free_word') . '%';
						}

						// ブログ記事なので公開しているものに限る
						$conditions['is_open'] = '公開する';

						// ブログ記事なのでシステム日付が公開日よりも後のものに限る
						$conditions['open_date <='] = Time::now();

						// 指定のユーザーが著者であるものに限る
						$conditions['user_id'] = $user_id;

						$posts = $this->paginate($this->Posts->find('All', ['conditions' => $conditions]));

						$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();
						if ($user) {
							$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
							$url = $protocol . $_SERVER['HTTP_HOST'];
							foreach ($posts as $post) {
								$post->context = strip_tags($post->context);

								if (mb_strlen($post->context) > $context_len) {
									$post->context = mb_substr($post->context, 0, $context_len).'…';
								}

								// アイキャッチ画像が設定されていない場合はデフォルト画像を返す。
								// 設定されている場合はそのフルパスを返す
								if ($post->featured_image) {
									$post->featured_image = $url . $post->featured_image;
								} else {
									$categoryDefaultFeaturedImagePath = CategoryUtil::getDefaultFeaturedImagePath($post->category_id);
									if ($categoryDefaultFeaturedImagePath) {
										$post->featured_image = $url . $categoryDefaultFeaturedImagePath;
									}elseif ($user->default_featured_image_path) {
										$post->featured_image = $url . $user->default_featured_image_path;
									}
								}
							}
						} else {
							$result = [];
							$error = array(
									'message' => 'ユーザー情報が間違っています。',
									'code' => RES_UNAUTHORIZED,
							);

							// json_encodeを使用してJSON形式で返却
							return $this->response->withType('application/json')
									->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
						}

						$status = !is_null($posts);

						if ($posts) {
							$result = [
									'posts' => $posts->toList(),
									'category_name' => $category ? $category->category_name : '',
							];
							$error = [
									'message' => '正常に記事情報が取得できました。',
									'code' => RES_OK,
							];
						} else {
							$result = [
									'posts' => [],
							];
							$error = [
									'message' => '記事情報が登録されておりません。',
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

			// json_encodeを使用してJSON形式で返却
			return $this->response->withType('application/json')
					->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
		}

		/**
		 * 固定ページに紐づくカテゴリの最新記事のみを表示する
		 * ぺジネーションは無し
		 *
		 * ■取得条件
		 * ・公開日を過ぎた記事
		 * ・公開設定がされている記事
		 * ・自身が登録した記事
		 *
		 * @return \Cake\Http\Response
		 */
		function ajaxGetPostLatestCategories() {
			$this->autoRender = FALSE;
			$status = false;
			AjaxUtil::setCorsHeaders($this);

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
						// 本文の長さ
						$context_len = 60;
						if ($this->request->getQuery('context_len')) {
							$context_len = $this->request->getQuery('context_len');
						}

						// クエリより検索条件の生成
						$conditions = [];
						$categoryIdList = [];
						$category = null;
						if ($this->request->getQuery('page_name_id') != '') {
							$categoryNamesCondition = [];
							$categoryNamesCondition['page_name_id'] = $this->request->getQuery('page_name_id');

							if ($this->request->getQuery('slug') != '') {
								$categoryNamesCondition['slug'] = $this->request->getQuery('slug');

								// 後でカテゴリ名を返すときに使用する
								$category = TableRegistry::get('CategoryNames')->find('All')->where(['slug' => $this->request->getQuery('slug')])->first();
							}

							$categoryNames = TableRegistry::get('CategoryNames')->find('All')->where($categoryNamesCondition);
							$index = 0;
							foreach ($categoryNames as $categoryName) {
								$categoryIdList[$index++] = $categoryName->category_id;
							}
						}

						if ($this->request->getQuery('free_word') != '') {
							$conditions['title LIKE'] = '%' . $this->request->getQuery('free_word') . '%';
						}

						// ブログ記事なので公開しているものに限る
						$conditions['is_open'] = '公開する';

						// ブログ記事なのでシステム日付が公開日よりも後のものに限る
						$conditions['open_date <='] = Time::now();

						// 指定のユーザーが著者であるものに限る
						$conditions['user_id'] = $user_id;

						$posts = Array();
						foreach ($categoryIdList as $categoryId) {
							$post = $this->Posts->find('All', ['conditions' => $conditions])->where(['category_id' => $categoryId])->order(['open_date' => 'desc'])->first();
							if ($post) {
								array_push($posts, $post);
							}
						}

						$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();
						if ($user) {
							$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
							$url = $protocol . $_SERVER['HTTP_HOST'];
							foreach ($posts as $post) {
								$post->context = strip_tags($post->context);

								if (mb_strlen($post->context) > $context_len) {
									$post->context = mb_substr($post->context, 0, $context_len).'…';
								}

								// アイキャッチ画像が設定されていない場合はデフォルト画像を返す。
								// 設定されている場合はそのフルパスを返す
								if ($post->featured_image) {
									$post->featured_image = $url . $post->featured_image;
								} else {
									$categoryDefaultFeaturedImagePath = CategoryUtil::getDefaultFeaturedImagePath($post->category_id);
									if ($categoryDefaultFeaturedImagePath) {
										$post->featured_image = $url . $categoryDefaultFeaturedImagePath;
									}elseif ($user->default_featured_image_path) {
										$post->featured_image = $url . $user->default_featured_image_path;
									}
								}
							}
						} else {
							$result = [];
							$error = array(
								'message' => 'ユーザー情報が間違っています。',
								'code' => RES_UNAUTHORIZED,
							);

							// json_encodeを使用してJSON形式で返却
							return $this->response->withType('application/json')
								->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
						}

						$status = !is_null($posts);

						if ($posts) {
							$result = [
								'posts' => $posts,
								'category_name' => $category ? $category->category_name : '',
							];
							$error = [
								'message' => '正常に記事情報が取得できました。',
								'code' => RES_OK,
							];
						} else {
							$result = [
								'posts' => [],
							];
							$error = [
								'message' => '記事情報が登録されておりません。',
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

			// json_encodeを使用してJSON形式で返却
			return $this->response->withType('application/json')
				->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
		}

		/**
		 * 記事IDを指定して記事詳細情報をJSON形式で取得する
		 * 紐づくコメント類は別のAPIで
		 * @return \Cake\Http\Response
		 */
		function ajaxGetPostView() {
			$this->autoRender = FALSE;
			$status = false;

			if (!$this->request->is('ajax')) {
				$result = [];
				$error = array(
						'message' => '不正なアクセスです。' . $this->request->getMethod(),
						'code' => RES_BAD_REQUEST,
				);
			} else {
				$id = $this->request->getQuery('id');
				$user_id = $this->request->getQuery('user_id');
				// 記事IDの取得
				if ($id) {
					if ($user_id) {
						if (AjaxUtil::isCorrectUserId($user_id)) {
							// クエリより検索条件の生成
							$conditions = [];
							$conditions['id'] = $id;

							// ブログ記事なので公開しているものに限る
							$conditions['is_open'] = '公開する';

							// ブログ記事なのでシステム日付が公開日よりも後のものに限る
							$conditions['open_date <='] = Time::now();

							//　指定のユーザーが著者であるものに限る
							$conditions['user_id'] = $user_id;

							$post = $this->Posts->find('All', ['conditions' => $conditions])->first();

							// 条件にマッチする記事が存在しない場合はエラー
							if (is_null($post)) {
								$result = [];
								$error = array(
										'message' => '指定の記事が存在しません。',
										'code' => RES_NOT_FROUND
								);

								// json_encodeを使用してJSON形式で返却
								return $this->response->withType('application/json')
										->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
							}

							$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();
							if ($user) {
								$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
								$url = $protocol . $_SERVER['HTTP_HOST'];

								$post->context = str_replace('src="/upload_img', 'src="' . $url . '/upload_img', $post->context);

								$post->title_sub1 = $post->title_sub1 ? $post->title_sub1 : '';
								$post->title_sub2 = $post->title_sub2 ? $post->title_sub2 : '';

								// アイキャッチ画像が設定されていない場合はデフォルト画像を返す。
								// 設定されている場合はそのフルパスを返す
								if ($post->featured_image) {
									$post->featured_image = $url . $post->featured_image;
								} else {
									$categoryDefaultFeaturedImagePath = CategoryUtil::getDefaultFeaturedImagePath($post->category_id);
									if ($categoryDefaultFeaturedImagePath) {
										$post->featured_image = $url . $categoryDefaultFeaturedImagePath;
									}elseif ($user->default_featured_image_path) {
										$post->featured_image = $url . $user->default_featured_image_path;
									}
								}
							} else {
								$result = [];
								$error = array(
										'message' => 'ユーザー情報が間違っています。',
										'code' => RES_UNAUTHORIZED,
								);

								// json_encodeを使用してJSON形式で返却
								return $this->response->withType('application/json')
										->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
							}

							$status = true;
							$result = [
									'post' => $post,
							];
							$error = [];
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
				} else {
					$result = [];
					$error = array(
							'message' => '記事を指定してください。',
							'code' => RES_NOT_FROUND
					);
				}
			}

			AjaxUtil::setCorsHeaders($this);

			// json_encodeを使用してJSON形式で返却
			return $this->response->withType('application/json')
					->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
		}
	}
