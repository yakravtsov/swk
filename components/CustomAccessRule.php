<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 04.02.2016
 * Time: 3:53
 * All rights are reserved
 */
namespace app\components;
use yii\filters\AccessRule;

class CustomAccessRule extends AccessRule {

	protected function matchRole($user) {
		if (empty($this->roles)) {
			return true;
		}
		foreach ($this->roles as $role) {
			if ($role === '?') {
				if ($user->getIsGuest()) {
					return true;
				}
			} elseif ($role === '@') {
				if (!$user->getIsGuest()) {
					return true;
				}
			} elseif(is_array($role)) {
				list($role, $params) = $role;
				$user->can($role, $params);
			} elseif ($user->can($role)) {
				return true;
			}
		}

		return false;
	}

}