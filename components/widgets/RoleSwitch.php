<?php
namespace app\components\widgets;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 25.10.2015
 * Time: 20:30
 * All rights are reserved
 */
class RoleSwitch extends \yii\base\Widget {

	public static function getDropdown() {
		$isGod = !Yii::$app->user->isGuest && Yii::$app->user->isGod();
		if(!$isGod) {
			return ['label'=>'','visible'=>false];
		}
		$label   = Yii::$app->user->getIdentity()->getRoleLabel();
		$other   = Yii::$app->user->identity->getOtherRoles();
		$visible = $isGod;
		$items   = [];
		$items[] = [
			'label' => Yii::$app->user->getIdentity()->getRoleLabel(),
		    'disabled'=>true
		];
		foreach ($other as $role=>$label) {
			$items[] = [
				'label' => Yii::$app->user->getIdentity()->getRoleLabel($role),
				'url' => Url::to(['/users/role', 'roleId' => $role])
			];
		}

		return [
			'label' => $label,
			'items' => $items,
			'visible'=> $visible
		];
	}

}