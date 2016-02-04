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
		if(!$sId = ArrayHelper::getValue($params, 'structureId')) {
			return true;
		}
		Yii::trace('executing structure access rule');
		$structure = Structure::findOne($sId);
		return $structure ? Yii::$app->user->identity->university_id == $structure->university_id : false;
	}
}