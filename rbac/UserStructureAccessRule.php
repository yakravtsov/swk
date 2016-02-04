<?php
namespace app\rbac;

use app\models\Structure;
use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

class UserStructureAccessRule extends Rule
{
	public $name = 'userStructureAccess';

	public function execute($user, $item, $params)
	{
		Yii::trace('executing structure access rule');
		$structure_id = ArrayHelper::getValue($params, 'structure_id');
		$structure = Structure::findOne($structure_id);
		return $structure_id ? Yii::$app->user->identity->university_id == $structure->university_id : false;
	}
}