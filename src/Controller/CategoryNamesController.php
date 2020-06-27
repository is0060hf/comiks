<?php

	namespace App\Controller;

	use App\Utils\AjaxUtil;
	use Cake\Event\Event;

	/**
	 * Posts Controller
	 *
	 * @property \App\Model\Table\CategoryNamesTable $CategoryNames
	 *
	 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class CategoryNamesController extends AppController {

		/**
		 * ログインしていなくてもアクセスできるページを定義する
		 * 投稿関連に関しては情報の閲覧も含めてログインが必要
		 * @param Event $event
		 * @return \Cake\Http\Response
		 */
		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
			$this->Auth->allow(['ajaxGetCategoryIndex']);
		}

		public function isAuthorized($user) {
			// 誰でも実行を許可する
			if (in_array($this->request->getParam('action'), ['ajaxGetCategoryIndex'])) {
				return true;
			}

			// 本人のみ許可するアクション(各アクションで処理)
			if (in_array($this->request->getParam('action'), ['index', 'view', 'add', 'edit', 'delete', 'deleteFromPageName'])) {
				return true;
			}

			return parent::isAuthorized($user);
		}

		/**
		 * カテゴリの一覧画面
		 */
		public function index() {
			$this->viewBuilder()->setLayout('editor_layout');

			if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
				// 管理者は全件表示させる
				$categoryNames = $this->CategoryNames->find('All');
			} else {
				// 自身が登録したカテゴリを全件取得
				$categoryNames = $this->CategoryNames->find('All')->where(['user_id' => $this->request->session()->read('Auth.User.id')]);
			}

			$this->set(compact('categoryNames'));
		}

		/**
		 * カテゴリの詳細画面
		 *
		 * @param string|null $id カテゴリid.
		 */
		public function view($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');

			$categoryName = $this->CategoryNames->get($id, [
					'contain' => [],
			]);

			$this->set(compact('categoryName'));
		}

		/**
		 * カテゴリの登録画面
		 *
		 * @return \Cake\Http\Response|null
		 */
		public function add() {
			$this->viewBuilder()->setLayout('editor_layout');

			$categoryName = $this->CategoryNames->newEntity();

			if ($this->request->is('post')) {
				// 入力内容のセット
				$categoryName = $this->CategoryNames->patchEntity($categoryName, $this->request->getData());

				// カテゴリ登録処理
				if ($this->CategoryNames->save($categoryName)) {
					$this->Flash->success(__('カテゴリを登録しました。'));

					// ページIDを設定する
					if ($this->request->getQuery('page_id')) {
						return $this->redirect(array('controller' => 'PageNames', 'action' => 'view', $this->request->getQuery('page_id')));
					} else {
						return $this->redirect($this->referer());
					}
				} else {
					$this->Flash->error(__('入力エラーが発生しました。'));
					$this->set(compact('categoryName'));
					$this->render("add");
				}
			} elseif ($this->request->is('get')) {

				// ページIDを設定する
				if ($this->request->getQuery('page_id')) {
					$categoryName->page_name_id = $this->request->getQuery('page_id');
				} else {
					$this->Flash->error(__('カテゴリを追加するために必要な情報が足りません。'));
					return $this->redirect($this->referer());
				}
			}
			$this->set(compact('categoryName'));
		}

		/**
		 * カテゴリ編集画面
		 *
		 * @param string|null $id カテゴリid.
		 * @return \Cake\Http\Response|null
		 */
		public function edit($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');

			$categoryName = $this->CategoryNames->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				// 入力内容のセット
				$categoryName = $this->CategoryNames->patchEntity($categoryName, $this->request->getData());

				// カテゴリ登録処理
				if ($this->CategoryNames->save($categoryName)) {
					$this->Flash->success(__('カテゴリを登録しました。'));
					return $this->redirect(array('action' => 'view', $id));
				} else {
					$this->Flash->error(__('入力エラーが発生しました。'));
					$this->set(compact('categoryName'));
					$this->render("edit");
				}
			}
			$this->set(compact('categoryName'));
		}

		/**
		 * カテゴリ削除
		 *
		 * @param string|null $id Post id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$categoryName = $this->CategoryNames->get($id);

			if ($this->CategoryNames->delete($categoryName)) {
				$this->Flash->success(__('カテゴリを削除しました。'));
			} else {
				$this->Flash->error(__('削除エラーが発生しました。'));
			}

			return $this->redirect(['action' => 'index']);
		}

		/**
		 * 固定ページからカテゴリ削除
		 *
		 * @return \Cake\Http\Response|null Redirects to index.
		 */
		public function deleteFromPageName() {
			$this->request->allowMethod(['post', 'delete']);
			$id = $this->request->getQuery('id');
			$page_id = $this->request->getQuery('page_id');

			if ($id && $page_id) {
				$categoryName = $this->CategoryNames->get($id);

				if ($this->CategoryNames->delete($categoryName)) {
					$this->Flash->success(__('カテゴリを削除しました。'));
				} else {
					$this->Flash->error(__('削除エラーが発生しました。'));
				}
				return $this->redirect(['controller' => 'PageNames', 'action' => 'view', $page_id]);
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

						$categoryNames = $this->CategoryNames->find('All', ['conditions' => $conditions]);
						$status = !is_null($categoryNames);

						if ($status) {
							$result = [
									'categories' => $categoryNames->toList(),
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
	}
