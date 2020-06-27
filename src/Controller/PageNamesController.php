<?php

	namespace App\Controller;

	use App\Utils\AjaxUtil;
	use Cake\Event\Event;

	/**
	 * Posts Controller
	 *
	 * @property \App\Model\Table\PageNamesTable $PageNames
	 *
	 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
	 */
	class PageNamesController extends AppController {

		/**
		 * ログインしていなくてもアクセスできるページを定義する
		 * 投稿関連に関しては情報の閲覧も含めてログインが必要
		 * @param Event $event
		 * @return \Cake\Http\Response
		 */
		public function beforeFilter(Event $event) {
			parent::beforeFilter($event);
		}

		public function isAuthorized($user) {
			// 本人のみ許可するアクション(各アクションで処理)
			if (in_array($this->request->getParam('action'), ['index', 'view', 'add', 'edit', 'delete'])) {
				return true;
			}

			// システム管理者以外はユーザー情報に関して全アクション拒否
			if (isset($user) && $user['user_role'] == ROLE_SYSTEM) {
				if (in_array($this->request->getParam('action'), ['addAdmin'])) {
					return true;
				}
			}

			return parent::isAuthorized($user);
		}

		/**
		 * ページの一覧画面
		 */
		public function index() {
			$this->viewBuilder()->setLayout('metrica_index_layout');

			$conditions = [];
			$sort = ['created' => 'desc'];

			if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
				$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
			}

			//検索条件のクリアが選択された場合は全件検索をする
			if ($this->request->getQuery('submit_btn') == 'clear') {
				$pageNames = $this->paginate($this->PageNames->find('all', ['order' => $sort]));
			} else {
				if ($this->request->getQuery('page_name') != '') {
					$conditions['page_name like'] = '%'.$this->request->getQuery('page_name').'%';
				}
				if ($this->request->getQuery('user_id') != '' && $this->request->getQuery('user_id') != '0') {
					$conditions['user_id'] = $this->request->getQuery('user_id');
				}
				if ($this->request->session()->read('Auth.User.user_role') == ROLE_SYSTEM) {
					// 管理者は全件表示させる
					$pageNames = $this->paginate($this->PageNames->find('all', ['order' => $sort,
						'conditions' => $conditions]));
				} else {
					// 自身が登録したページを全件取得
					$conditions['user_id'] = $this->request->session()->read('Auth.User.id');
					$pageNames = $this->paginate($this->PageNames->find('all', ['order' => $sort,
						'conditions' => $conditions]));
				}
			}

			$this->set(compact('pageNames'));
		}

		/**
		 * 固定ページの詳細画面
		 * @return \Cake\Http\Response|null
		 */
		public function view() {
			$pageNameId = $this->request->getQuery('id');

			if ($pageNameId) {
				$this->viewBuilder()->setLayout('metrica_view_layout');
				$pageName = $this->PageNames->find('All')->where(['id' => $pageNameId])->first();

				if ($pageName) {
					$this->set(compact('pageName'));
				} else {
					$this->Flash->error(__('指定の固定ページが存在しません。'));
					return $this->redirect(['controller' => 'PageNames', 'action' => 'index']);
				}
			} else {
				$this->Flash->error(__('固定ページIDが指定されていません。'));
				return $this->redirect(['controller' => 'PageNames', 'action' => 'index']);
			}
		}

		/**
		 * ページの登録画面
		 *
		 * @return \Cake\Http\Response|null
		 */
		public function add() {
			$this->viewBuilder()->setLayout('metrica_editor_layout');

			$pageName = $this->PageNames->newEntity();
			if ($this->request->is('post')) {
				// 入力内容のセット
				$pageName = $this->PageNames->patchEntity($pageName, $this->request->getData());

				// ページ登録処理
				if ($this->PageNames->save($pageName)) {
					$this->Flash->success(__('ページを登録しました。'));

					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('入力エラーが発生しました。'));
					$this->set(compact('pageName'));
					$this->render("add");
				}
			}
			$this->set(compact('pageName'));
		}

		/**
		 * ページの登録画面
		 *
		 * @return \Cake\Http\Response|null
		 */
		public function addAdmin() {
			$this->viewBuilder()->setLayout('metrica_editor_layout');

			$pageName = $this->PageNames->newEntity();
			if ($this->request->is('post')) {
				// 入力内容のセット
				$pageName = $this->PageNames->patchEntity($pageName, $this->request->getData());

				// ページ登録処理
				if ($this->PageNames->save($pageName)) {
					$this->Flash->success(__('ページを登録しました。'));

					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('入力エラーが発生しました。'));
					$this->set(compact('pageName'));
					$this->render("add");
				}
			}
			$this->set(compact('pageName'));
		}

		/**
		 * ページ編集画面
		 *
		 * @param string|null $id ページid.
		 * @return \Cake\Http\Response|null
		 */
		public function edit($id = null) {
			$pageNameId = $this->request->getQuery('id');

			if ($pageNameId) {
				$this->viewBuilder()->setLayout('metrica_editor_layout');
				$pageName = $this->PageNames->find('All')->where(['id' => $pageNameId])->first();

				if ($pageName) {
					if ($this->request->is(['patch', 'post', 'put'])) {
						// 入力内容のセット
						$pageName = $this->PageNames->patchEntity($pageName, $this->request->getData());

						// ページ登録処理
						if ($this->PageNames->save($pageName)) {
							$this->Flash->success(__('ページを登録しました。'));
							return $this->redirect(array('action' => 'view', '?' => ['id' => $pageName->id]));
						} else {
							$this->Flash->error(__('入力エラーが発生しました。'));
							$this->set(compact('pageName'));
							$this->render("edit");
						}
					}
				} else {
					$this->Flash->error(__('指定の固定ページが存在しません。'));
					return $this->redirect(['controller' => 'PageNames', 'action' => 'index']);
				}
			} else {
				$this->Flash->error(__('固定ページIDが指定されていません。'));
				return $this->redirect(['controller' => 'PageNames', 'action' => 'index']);
			}

			$this->set(compact('pageName'));
		}

		/**
		 * ページ削除
		 *
		 * @param string|null $id Post id.
		 * @return \Cake\Http\Response|null Redirects to index.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function delete($id = null) {
			$this->request->allowMethod(['post', 'delete']);
			$pageName = $this->PageNames->get($id);

			if ($this->PageNames->delete($pageName)) {
				$this->Flash->success(__('ページを削除しました。'));
			} else {
				$this->Flash->error(__('削除エラーが発生しました。'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
