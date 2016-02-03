<?php
namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use \app\rbac\UserRoleRule;

class RbacController extends Controller
{
	public function actionInit()
	{
		$authManager = \Yii::$app->authManager;
		$authManager->removeAll();
		// Create roles
		$guest  = $authManager->createRole('guest');
		$student  = $authManager->createRole('student');
		$teacher = $authManager->createRole('teacher');
		$admin  = $authManager->createRole('admin');
		$god  = $authManager->createRole('god');

		// Create simple, based on action{$NAME} permissions
		$login  = $authManager->createPermission('login');
		$logout = $authManager->createPermission('logout');
		$error  = $authManager->createPermission('error');
		$signUp = $authManager->createPermission('sign-up');
		$index  = $authManager->createPermission('index');
		$view   = $authManager->createPermission('view');
		$update = $authManager->createPermission('update');
		$delete = $authManager->createPermission('delete');
		$structure = $authManager->createPermission('structure');

		// Add permissions in Yii::$app->authManager
		$authManager->add($login);
		$authManager->add($logout);
		$authManager->add($error);
		$authManager->add($signUp);
		$authManager->add($index);
		$authManager->add($view);
		$authManager->add($update);
		$authManager->add($delete);
		$authManager->add($structure);


		// Add rule, based on UserExt->group === $user->group
		$userRoleRule = new UserRoleRule();
		$authManager->add($userRoleRule);

		// Add rule "UserRoleRule" in roles
		$guest->ruleName  = $userRoleRule->name;
		$student->ruleName  = $userRoleRule->name;
		$teacher->ruleName = $userRoleRule->name;
		$admin->ruleName  = $userRoleRule->name;
		$god->ruleName  = $userRoleRule->name;

		// Add roles in Yii::$app->authManager
		$authManager->add($guest);
		$authManager->add($student);
		$authManager->add($teacher);
		$authManager->add($admin);
		$authManager->add($god);

		// Add permission-per-role in Yii::$app->authManager
		// Guest
		$authManager->addChild($guest, $login);
		$authManager->addChild($guest, $logout);
		$authManager->addChild($guest, $error);
		$authManager->addChild($guest, $signUp);
		$authManager->addChild($guest, $index);
		$authManager->addChild($guest, $view);

		// Student
		$authManager->addChild($student, $update);
		$authManager->addChild($student, $guest);

		// Teacher
		$authManager->addChild($teacher, $structure);
		$authManager->addChild($teacher, $student);

		// Admin
		$authManager->addChild($admin, $delete);
		$authManager->addChild($admin, $teacher);
		$authManager->addChild($admin, $student);

		// God

		$authManager->addChild($god, $structure);
		$authManager->addChild($god, $admin);
		$authManager->addChild($god, $teacher);
		$authManager->addChild($god, $student);
	}
}