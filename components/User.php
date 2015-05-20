<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 17.05.15
 * Time: 18:01
 * All rights are reserved
 */

namespace app\components;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use app\models\User as UserModel;
use Yii;

/**
 * Class User
 * @package app\components
 *
 * @inheritdoc
 *
 * @property IdentityInterface|\app\models\User $identity The identity object associated with the currently logged-in
 */
class User extends \yii\web\User {

	public function getHomePageUrl() {
		switch($this->identity->role_id) {
			case (UserModel::ROLE_STUDENT):
				return Url::to(['users/view', 'id'=>$this->identity->user_id]);
			case (UserModel::ROLE_ADMINISTRATOR):
			case (UserModel::ROLE_TEACHER):
				return Url::to(['/works']);
		}

		return;
	}
}