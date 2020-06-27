<?php
	/**
	 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
	 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
	 *
	 * Licensed under The MIT License
	 * For full copyright and license information, please see the LICENSE.txt
	 * Redistributions of files must retain the above copyright notice.
	 *
	 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
	 * @link      https://cakephp.org CakePHP(tm) Project
	 * @since     0.2.9
	 * @license   https://opensource.org/licenses/mit-license.php MIT License
	 */

	namespace App\Controller;

	use Cake\Controller\Controller;
	use Cake\Event\Event;

	/**
	 * Application Controller
	 *
	 * Add your application-wide methods in the class below, your controllers
	 * will inherit them.
	 *
	 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
	 */
	class AppController extends Controller {
		public $helpers = [
				'Paginator' => ['templates' => 'paginator-templates']
		];

		/**
		 * Initialization hook method.
		 *
		 * Use this method to add common initialization code like loading components.
		 *
		 * e.g. `$this->loadComponent('Security');`
		 *
		 * @return void
		 * @throws \Exception
		 */
		public function initialize() {
			parent::initialize();

			$this->loadComponent('RequestHandler', [
					'enableBeforeRedirect' => false,
			]);
			$this->loadComponent('Flash');

			$this->loadComponent('Auth', ['authorize' => ['Controller'],
					'authError' => 'ログインしてください。',
					'storage' => 'Session',
					'loginRedirect' => ['controller' => 'Posts',
							'action' => 'index'],
					'logoutRedirect' => ['controller' => 'Users',
							'action' => 'login'],
					'unauthorizedRedirect' => ['controller' => 'Users',
							'action' => 'login']]);

			/*
			 * Enable the following component for recommended CakePHP security settings.
			 * see https://book.cakephp.org/3.0/en/controllers/components/security.html
			 */
			//$this->loadComponent('Security');
		}

		/**
		 * 基本的な閲覧権限はなしとしておく。ページ毎に許可する方針
		 * @param $user
		 * @return bool
		 */
		public function isAuthorized($user) {
			error_log(print_r($user, true), "3", ROOT . "/logs/debug.log");

			/*// 管理者はすべての操作にアクセスできます
			if (isset($user['role']) && $user['role'] === 'admin') {
				return true;
			}*/

			// デフォルトは拒否
			return false;
		}

		/**
		 * すべてのアクションを拒否する。ページ毎に許可する方針
		 * @param Event $event
		 * @return \Cake\Http\Response|null|void
		 */
		public function beforeFilter(Event $event) {
			//			$this->Auth->allow(['index', 'view', 'display']);
			$this->Auth->deny();
		}
	}
