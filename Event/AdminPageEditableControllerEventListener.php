<?php
/**
 * [ControllerEventListener] AdminPageEditable
 */
class AdminPageEditableControllerEventListener extends BcControllerEventListener {
/**
 * 登録イベント
 *
 */
	public $events = array(
		'Pages.beforeRender'
	);

	public function pagesBeforeRender(CakeEvent $event) {
		$Controller = $event->subject();

		/**
		 * 管理画面チェック
		 */
		if (!BcUtil::isAdminSystem() ||
			!Hash::get($Controller->request->params, 'controller') == 'pages' ||
			!in_array(Hash::get($Controller->request->params, 'action'), ['admin_add', 'admin_edit']))
		{
			return true;
		}

		/**
		 * 管理画面　対象ユーザチェック
		 */
		//対象ユーザグループ
		$target_user_groups	= Configure::read('AdminPageEditable.target_user_group');
		$user = $Controller->BcAuth->user();
		if (!$user || !in_array((int)Hash::get($user, 'user_group_id'), $target_user_groups)) {
			return true;
		}

		//一時的にユーザのグループ変更
		Configure::write('BcApp.adminGroupId', (int)Hash::get($user, 'user_group_id'));

	}

}
