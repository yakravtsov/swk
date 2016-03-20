<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 17.05.15
 * Time: 18:01
 * All rights are reserved
 */
namespace app\components;

use yii\base\InvalidValueException;
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

	public $roleId;
	public $realRoleId;

	public function getHomePageUrl() {
		switch ($this->identity->role_id) {
			case (UserModel::ROLE_STUDENT):
				return Url::to(['users/view', 'id' => $this->identity->user_id]);
			case (UserModel::ROLE_ADMINISTRATOR):
				return Url::to(['/users']);
			case (UserModel::ROLE_AGENT):
				return Url::to(['/agent/requests', 'id' => $this->identity->user_id]);
			case (UserModel::ROLE_TEACHER):
				return Url::to(['/works']);
			default:
				return Url::to('/');
		}
	}

	/**
	 * Sets the user identity object.
	 *
	 * Note that this method does not deal with session or cookie. You should usually use [[switchIdentity()]]
	 * to change the identity of the current user.
	 *
	 * @param IdentityInterface|null $identity the identity object associated with the currently logged user.
	 *                                         If null, it means the current user will be a guest without any associated identity.
	 *
	 * @throws InvalidValueException if `$identity` object does not implement [[IdentityInterface]].
	 */
	public function setIdentity($identity) {
		if ($identity instanceof IdentityInterface) {
			if ($role = Yii::$app->session->get('user.role.switch')) {
				$this->realRoleId  = $identity->role_id;
				$identity->role_id = (int) $role;
			} //Save in the session the id of your admin user.
			parent::setIdentity($identity);
		} elseif ($identity === NULL) {
			parent::setIdentity($identity);
		} else {
			throw new InvalidValueException('The identity object must implement IdentityInterface.');
		}
	}

	public function isGod() {
		if ($this->isGuest) {
			return FALSE;
		}
		$role = $this->realRoleId ?: $this->identity->role_id;

			return $role == UserModel::ROLE_GOD;
	}

}