<?php
/**
 * [Config] AdminPageEditable
 */
/**
 * システムナビ
 */
$config['AdminPageEditable'] = [
	//対象固定ページを管理者権限で編集可能にする
	'target_user_group' => [
		2, 3, //サイト運営、CMS運営: UserGroup.id
	],
];

/**
 * パートナー専用ログ
 */
define('LOG_ADMINPAGEEDITABLE', 'log_adminpageeditable');
CakeLog::config('log_adminpageeditable', [
	'engine' => 'FileLog',
	'types' => ['log_adminpageeditable'],
	'file' => 'log_adminpageeditable',
]);
