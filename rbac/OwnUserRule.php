<?php
namespace app\rbac;

use app\models\Structure;
use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

class OwnUserRule extends Rule
{
	public $name = 'ownUser';

	public function execute($user, $item, $params)
	{
		$sId = ArrayHelper::getValue($params, 'userId');
		Yii::trace('executing structure access rule');
		return $sId ? Yii::$app->user->id == $sId : false;
	}
}