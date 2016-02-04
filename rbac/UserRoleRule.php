<?php
namespace app\rbac;

use app\models\User;
use Yii;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
	public $name = 'userRole';

	public function execute($user, $item, $params)
	{
		if (!\Yii::$app->user->isGuest) {
			$role = Yii::$app->session->get('user.currentRole') ?: \Yii::$app->user->identity->role_id;
			Yii::info('Current role_id: ' . $role);
			Yii::info('Current item name: ' . $item->name);
			if ($item->name === 'admin') {
				Yii::info('admin accssee');
				return $role == User::ROLE_ADMINISTRATOR;
			} elseif ($item->name === 'student') {
				return $role == User::ROLE_STUDENT;
			} elseif ($item->name === 'teacher') {
				return $role == User::ROLE_TEACHER;
			} elseif ($item->name === 'god') {
				return $role == User::ROLE_GOD;
			}
		}
		return false;
	}
}