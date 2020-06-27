<?php

namespace App\Controller;

use App\Model\Entity\UploadedFile;
use App\Model\Table\UploadedFilesTable;
use App\Utils\AjaxUtil;
use Cake\Core\Exception\Exception;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Psr\Log\LogLevel;
use RuntimeException;
use App\Utils\FileUtil;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 基本的に、ログアウトのみ
	 * ユーザーに関しては権限エラーも
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['logout',
				'login',
				'add',
				'index',
				'ajaxUpdateIconImagePath',
				'ajaxUpdateFeaturedImagePath',
				'ajaxDeleteIconImagePath',
				'ajaxDeleteFeaturedImagePath']);
	}

	public function isAuthorized($user) {
		// 誰でも許可するアクション
		if (in_array($this->request->getParam('action'), ['logout',
				'login',
				'add',
				'view',
				'index',
				'contact',
				'ajaxUpdateIconImagePath',
				'ajaxUpdateFeaturedImagePath',
				'ajaxDeleteIconImagePath',
				'ajaxDeleteFeaturedImagePath'])) {
			return true;
		}

		// 本人のみ許可するアクション(各アクションで処理)
		if (in_array($this->request->getParam('action'), ['passwordUpdate','edit','delete','deleteIconImageOnEdit', 'deleteDefaultFeaturedImageOnEdit'])) {
			return true;
		}

		return parent::isAuthorized($user);
	}

	/**
	 * IDとパスワードでログイン処理をする
	 * 成功した場合は、親クラスに設定したパスへ遷移する
	 * @return \Cake\Http\Response|null
	 */
	public function login() {
		$this->viewBuilder()->setLayout('metrica_login_layout');
		if ($this->request->is('post')) {
			$login_name = $this->request->getData('login_cd');
			$user = $this->Users->find('All')->where(['login_cd' => $login_name])->first();

			if ($user) {
				$password = $this->request->getData('password');
				if (password_verify($password, $user->password)) {
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}
			}
			$this->Flash->error(__('ログイン情報に誤りがあります。'));
			$this->set(compact('user'));
		}
		return null;
	}

	/**
	 * ログアウト処理を実施する
	 * @return \Cake\Http\Response|null
	 */
	public function logout() {
		$this->request->session()->destroy();
		return $this->redirect($this->Auth->logout());
	}

	/**
	 * フォームで指定されたユーザーの
	 * アイコンデータを更新する
	 * @return array|string|null
	 */
	public function ajaxUpdateIconImagePath() {
		$this->autoRender = FALSE;
		$user_id = $this->request->getData('user_id');
		$file = $this->request->getData('file');
		$dir_name = '/'.FILE_UPLOAD_DIRECTORY_NAME;
		$dirFullPath = realpath(WWW_ROOT.$dir_name);

		$status = false;
		$result = [];
		$error = [];

		$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();

		if (!is_null($file)) {
			if ($file['tmp_name'] != '') {
				if ($user) {
					if ($user->icon_image_path != '') {
						FileUtil::deleteFile($user->icon_image_path);
					}
					$uploadResult = FileUtil::file_upload($file, $dirFullPath, UPLOAD_ICON_IMAGE_CAPACITY);
					// ファイル情報をDBへ登録
					$user->icon_image_path = $dir_name.'/'.$uploadResult['path'];

					if (TableRegistry::get('Users')->save($user)) {
						$status = true;
					} else {
						$error = array(
							'message' => 'データ更新に失敗しました。',
							'code' => RES_INTERNAL_SERVER_ERROR,
						);
					}
				} else {
					$error = array(
						'message' => '指定のユーザーが存在しません。',
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
	 * フォームで指定されたユーザーの
	 * アイキャッチデータを更新する
	 * @return array|string|null
	 */
	public function ajaxUpdateFeaturedImagePath() {
		$this->autoRender = FALSE;
		$user_id = $this->request->getData('user_id');
		$file = $this->request->getData('file');
		$dir_name = '/'.FILE_UPLOAD_DIRECTORY_NAME;
		$dirFullPath = realpath(WWW_ROOT.$dir_name);

		$status = false;
		$result = [];
		$error = [];

		$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();

		if (!is_null($file)) {
			if ($file['tmp_name'] != '') {
				if ($user) {
					if ($user->default_featured_image_path != '') {
						FileUtil::deleteFile($user->default_featured_image_path);
					}
					$uploadResult = FileUtil::file_upload($file, $dirFullPath, UPLOAD_ICON_IMAGE_CAPACITY);
					// ファイル情報をDBへ登録
					$user->default_featured_image_path = $dir_name.'/'.$uploadResult['path'];

					if (TableRegistry::get('Users')->save($user)) {
						$status = true;
					} else {
						$error = array(
							'message' => 'データ更新に失敗しました。',
							'code' => RES_INTERNAL_SERVER_ERROR,
						);
					}
				} else {
					$error = array(
						'message' => '指定のユーザーが存在しません。',
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
	 * フォームで指定されたユーザーの
	 * アイコンデータを削除する
	 * @return \Cake\Http\Response
	 */
	public function ajaxDeleteIconImagePath() {
		$this->autoRender = FALSE;
		$user_id = $this->request->getData('user_id');

		$status = false;
		$result = [];
		$error = [];

		$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();

		if ($user) {
			FileUtil::deleteFile($user->icon_image_path);
			$user->icon_image_path = null;

			if (TableRegistry::get('Users')->save($user)) {
				$status = true;
			} else {
				$error = array(
					'message' => 'データ更新に失敗しました。',
					'code' => RES_INTERNAL_SERVER_ERROR,
				);
			}
		} else {
			$error = array(
				'message' => '指定のユーザーが存在しません。',
				'code' => RES_BAD_REQUEST,
			);
		}

		return $this->response->withType('application/json')
			->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
	}

	/**
	 * フォームで指定されたユーザーの
	 * アイキャッチデータを削除する
	 * @return \Cake\Http\Response
	 */
	public function ajaxDeleteFeaturedImagePath() {
		$this->autoRender = FALSE;
		$user_id = $this->request->getData('user_id');

		$status = false;
		$result = [];
		$error = [];

		$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();

		if ($user) {
			FileUtil::deleteFile($user->default_featured_image_path);
			$user->default_featured_image_path = null;

			if (TableRegistry::get('Users')->save($user)) {
				$status = true;
			} else {
				$error = array(
					'message' => 'データ更新に失敗しました。',
					'code' => RES_INTERNAL_SERVER_ERROR,
				);
			}
		} else {
			$error = array(
				'message' => '指定のユーザーが存在しません。',
				'code' => RES_BAD_REQUEST,
			);
		}

		return $this->response->withType('application/json')
			->withStringBody(json_encode(compact('status', 'result', 'error'), JSON_UNESCAPED_UNICODE));
	}

	/**
	 * ユーザー登録画面のバリデーションを追加する
	 * @param Validator $validator
	 * @return Validator
	 */
	private function makeValidation(Validator $validator) {
		$validator->email('mail_address', false, __('メールアドレスのフォーマットで入力してください'));
		$validator->add('twitter_account', 'valid', ['rule' => 'url', 'message' => __('URLのフォーマットで入力してください')]);
		$validator->add('youtube_account', 'valid', ['rule' => 'url', 'message' => __('URLのフォーマットで入力してください')]);
		$validator->add('instagram_account', 'valid', ['rule' => 'url', 'message' => __('URLのフォーマットで入力してください')]);
		$validator->add('facebook_account', 'valid', ['rule' => 'url', 'message' => __('URLのフォーマットで入力してください')]);
		return $validator;
	}

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null
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
			$users = $this->paginate($this->Users->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%'.$this->request->getQuery('mail_address').'%';
			}
			if ($this->request->getQuery('login_name') != '') {
				$conditions['login_name like'] = '%'.$this->request->getQuery('login_name').'%';
			}
			if ($this->request->getQuery('role') != '' && $this->request->getQuery('role') != '-1') {
				$conditions['role'] = $this->request->getQuery('role');
			}
			$users = $this->paginate($this->Users->find('all', ['order' => $sort,
				'conditions' => $conditions]));
		}

		$this->set(compact('users'));
	}

	/**
	 * View method
	 *
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view() {
		$login_cd = $this->request->getQuery('id');
		if ($login_cd) {
			$this->viewBuilder()->setLayout('metrica_view_layout');
			$user = $this->Users->find('All')->where(['login_cd' => $login_cd])->first();

			if ($user) {
				$this->set('user', $user);
			} else {
				$this->Flash->error(__('指定のユーザーが存在しません。'));
				return $this->redirect(['controller' => 'users', 'action' => 'index']);
			}
		} else {
			$this->Flash->error(__('ユーザーIDが指定されていません。'));
			return $this->redirect(['controller' => 'users', 'action' => 'index']);
		}
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$this->viewBuilder()->setLayout('metrica_editor_layout');

		// バリデーションの追加設定
		$validator = $this->makeValidation($this->Users->getValidator('default'));
		$this->Users->setValidator('default', $validator);

		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$user->password = password_hash($user->password, PASSWORD_DEFAULT);
			$user->rank_kb = 1;

			if (!$user->hasErrors()) {
				if ($this->request->getData('password') === $this->request->getData('confirm_password')) {
					if ($this->Users->save($user)) {
						$this->Flash->success(__('新規ユーザーの登録が完了致しました。'));
						return $this->redirect(['controller' => 'users', 'action' => 'index']);
					} else {
						$this->Flash->error(__('ユーザー登録中に予期しないエラーが発生しました。'));
					}
				} else {
					$this->Flash->error(__('パスワードと確認用パスワードが一致しません。'));
				}
			} else {
				$this->Flash->error(__('入力値のフォーマットが正しくありません。'));
			}
		}
		$this->set(compact('user'));
	}

	public function contact() {
		$this->autoRender = FALSE;
		$user_id = $this->request->getData('user_id');
		$user = TableRegistry::get('Users')->find('All')->where(['id' => $user_id])->first();

		if (!$user) {
			return $this->redirect(['controller' => 'users', 'action' => 'index']);
		}

		$contactTable = TableRegistry::get('Contacts');
		$contact = $contactTable->newEntity();
		if ($this->request->is('post')) {
			$contact = $contactTable->patchEntity($contact, $this->request->getData());

			if (!$contact->hasErrors()) {
				if ($contactTable->save($contact)) {
					$this->Flash->success(__('正常に問い合わせが完了しました。'));
					return $this->redirect(['controller' => 'users', 'action' => 'view', '?' => ['id' => $user_id]]);
				}
			} else {
				$this->Flash->error(__('正常に問い合わせが完了しませんでした。もう一度お試しください。'));
				return $this->redirect(['controller' => 'users', 'action' => 'view', '?' => ['id' => $user_id]]);
			}
		} else {
			return $this->redirect(['controller' => 'users', 'action' => 'index']);
		}
	}

	/**
	 * Edit method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit() {
		$login_cd = $this->request->getQuery('id');
		if ($login_cd) {
			$user = $this->Users->find('All')->where(['login_cd' => $login_cd])->first();

			if ($this->request->session()->read('Auth.User.user_role') != ROLE_SYSTEM && $this->request->session()->read('Auth.User.id') != $user->id) {
				$this->Flash->error(__('ご指定の操作は権限がありません。'));
				return $this->redirect(['controller' => 'users',
					'action' => 'index']);
			}

			$this->viewBuilder()->setLayout('metrica_editor_layout');

			// バリデーションの追加設定
			$validator = $this->makeValidation($this->Users->getValidator('default'));
			$this->Users->setValidator('default', $validator);


			if ($this->request->is(['patch',
				'post',
				'put'])) {
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if ($this->Users->save($user)) {
					$this->Flash->success(__('会員情報を正常に更新致しました。'));
					return $this->redirect(['action' => 'view', '?' => ['id' => $user->login_cd]]);
				} else {
					$this->Flash->error(__('更新中に予期しないエラーが発生しました。'));
				}
			}
			$this->set(compact('user'));
		} else {
			$this->Flash->error(__('ユーザーIDが指定されていません。'));
			return $this->redirect(['controller' => 'users', 'action' => 'index']);
		}
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function passwordUpdate($id = null) {
		if ($this->request->session()->read('Auth.User.user_role') != ROLE_SYSTEM && $this->request->session()->read('Auth.User.id') != $id) {
			$this->Flash->error(__('ご指定の操作は権限がありません。'));
			return $this->redirect(['controller' => 'users',
				'action' => 'index']);
		}

		$this->viewBuilder()->setLayout('editor_layout');

		$user = $this->Users->get($id, ['contain' => []]);
		if ($this->request->is(['patch',
				'post',
				'put'])) {
			$old_password = $this->request->getData('old_password');
			if (password_verify($old_password, $user->password)) {
				if ($this->request->getData('password') === $this->request->getData('confirm_password')) {
					$user->password = $this->request->getData('password');
					$user->password = password_hash($user->password, PASSWORD_DEFAULT);
					if ($this->Users->save($user)) {
						$this->Flash->success(__('パスワードを正常に更新しました'));
						return $this->redirect(['action' => 'view',
								$user->id]);
					} else {
						$this->Flash->error(__('システムエラーが発生致しました。'));
					}
				} else {
					$this->Flash->error(__('確認用パスワードと一致しません。'));
				}
			} else {
				$this->Flash->error(__('入力されたパスワードが異なります。'));
			}

		}
		$this->set(compact('user'));
		return null;
	}


	/**
	 * ユーザーを削除する
	 * 紐づく画像データも削除する
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post',
			'delete']);
		$user = $this->Users->get($id);

		// ユーザーを削除するときには紐づく画像も削除する
		FileUtil::deleteIconImageOnEdit($user, $this->Users);
		FileUtil::deleteDefaultFeaturedImageOnEdit($user, $this->Users);

		if ($this->Users->delete($user)) {
			$this->Flash->success(__('ユーザーを削除しました。'));
		} else {
			$this->Flash->error(__('ユーザーの削除に失敗しました。'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * 編集画面にてアイコン画像を削除するためのメソッド
	 *
	 * @param null $id
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	public function deleteIconImageOnEdit($id = null) {
		$this->request->allowMethod(['post',
				'delete']);
		$user = $this->Users->get($id);

		if (FileUtil::deleteIconImageOnEdit($user, $this->Users)) {
			$this->Flash->success(__('アイコン画像を削除しました。'));
		} else {
			$this->Flash->error(__('アイコン画像の削除に失敗しました。'));
		}

		$this->set(compact('user'));
		return $this->redirect($this->referer());
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
		$user = $this->Users->get($id);

		if (FileUtil::deleteDefaultFeaturedImageOnEdit($user, $this->Users)) {
			$this->Flash->success(__('デフォルトアイキャッチ画像を削除しました。'));
		} else {
			$this->Flash->error(__('デフォルトアイキャッチ画像の削除に失敗しました。'));
		}

		$this->set(compact('user'));
		return $this->redirect($this->referer());
	}
}
