<?php

/**
 * [ModelEventListener] AdminPageEditable
 */
class AdminPageEditableModelEventListener extends BcModelEventListener {

	/**
	 * 登録イベント
	 *
	 * @var array
	 */
	public $events = array(
		'Page.beforeValidate',
	);

	/**
	 * Construct
	 *
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * pageBeforeValidate
	 *
	 * @param CakeEvent $event
	 */
	public function pageBeforeValidate(CakeEvent $event) {
		$params = Router::getParams();

		/**
		 * 管理画面チェック
		 */
		if (!BcUtil::isAdminSystem() ||
			!Hash::get($params, 'controller') == 'pages' ||
			!in_array(Hash::get($params, 'action'), ['admin_add', 'admin_edit']))
		{
			return true;
		}

		/**
		 * 管理画面　対象ユーザチェック
		 */
		//対象ユーザグループ
		$target_user_groups	= Configure::read('AdminPageEditable.target_user_group');
		$user = BcUtil::loginUser('admin');
		if (!$user || !in_array((int)Hash::get($user, 'user_group_id'), $target_user_groups)) {
			return true;
		}

		//一時的にユーザのグループ変更
		Configure::write('BcApp.adminGroupId', (int)Hash::get($user, 'user_group_id'));
		Configure::write('BcApp.allowedPhpOtherThanAdmins', true);

		return true;
	}
}
