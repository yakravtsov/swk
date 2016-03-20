<?php
namespace app\commands;

use app\models\User;
use app\rbac\UserStructureAccessRule;
use Yii;
use yii\console\Controller;
use \app\rbac\UserRoleRule;

class RbacController extends Controller {

	public function actionInit() {
		$authManager = \Yii::$app->authManager;
		$authManager->removeAll();

		// Add rule, based on UserExt->group === $user->group
		$userRoleRule = new UserRoleRule();
		$authManager->add($userRoleRule);

		$userStructureRule = new UserStructureAccessRule();
		$authManager->add($userStructureRule);
		// Create roles
		$guest   = $authManager->createRole('guest');
		$student = $authManager->createRole('student');
		$teacher = $authManager->createRole('teacher');
		$admin   = $authManager->createRole('admin');
		$god     = $authManager->createRole('god');
		$agent     = $authManager->createRole('agent');
		// Create simple, based on action{$NAME} permissions
		$login        = $authManager->createPermission('login');
		$logout       = $authManager->createPermission('logout');
		$error        = $authManager->createPermission('error');
		$signUp       = $authManager->createPermission('sign-up');
		$index        = $authManager->createPermission('index');
		$view         = $authManager->createPermission('view');
		$update       = $authManager->createPermission('update');
		$delete       = $authManager->createPermission('delete');
		$ownStructure = $authManager->createPermission('ownStructure');
		$structure    = $authManager->createPermission('structure');
		$university   = $authManager->createPermission('university');
		$indexUsers   = $authManager->createPermission('indexUsers');
		$teacherStudents   = $authManager->createPermission('teacherStudents');
		$downloadImportResult   = $authManager->createPermission('downloadImportResult');
		$crudUsers   = $authManager->createPermission('crudUsers');

		$ownStructure->ruleName = $userStructureRule->name;
		$indexUsers->ruleName = $userStructureRule->name;

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
		$authManager->add($ownStructure);
		$authManager->add($university);
		$authManager->add($indexUsers);
		$authManager->add($teacherStudents);
		$authManager->add($downloadImportResult);
		$authManager->add($crudUsers);

		// Add rule "UserRoleRule" in roles
		$guest->ruleName   = $userRoleRule->name;
		$student->ruleName = $userRoleRule->name;
		$teacher->ruleName = $userRoleRule->name;
		$admin->ruleName   = $userRoleRule->name;
		$god->ruleName     = $userRoleRule->name;
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
		$authManager->addChild($teacher, $student);
		$authManager->addChild($admin, $indexUsers);
		$authManager->addChild($admin, $teacherStudents);
		// Admin
		$authManager->addChild($admin, $delete);
		$authManager->addChild($admin, $ownStructure);
		$authManager->addChild($admin, $downloadImportResult);
		$authManager->addChild($admin, $crudUsers);
		$authManager->addChild($admin, $teacher);
		$authManager->addChild($admin, $student);
		// God
		$authManager->addChild($god, $structure);
		$authManager->addChild($god, $university);
		$authManager->addChild($god, $admin);
		$authManager->addChild($god, $teacher);
		$authManager->addChild($god, $student);
	}
}