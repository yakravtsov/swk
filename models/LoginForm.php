<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{

    public $email;
    public $password;
    public $rememberMe = TRUE;
    /** @var User */
    private $_user = FALSE;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function scenarios()
    {
        return [
            //'mail'                    => ['email', '!password'],
            'default' => ['email', 'password'],
            'resetPassword' => ['password'],
            'requestPasswordResetToken' => ['email'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === FALSE) {
            $this->_user = User::findByEmail($this->email);
            if (!$this->_user) {
                $this->_user = User::findByRecordBookId($this->email);
            }
            if($this->_user && $this->_user->role_id <> User::ROLE_GOD) {
                if(Yii::$app->university->model->university_id <> $this->_user->university_id) {
                    $this->_user = false;
                }
            }
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return FALSE;
        }
    }

    public function loginViaHash($email)
    {
        $this->email = $email;

        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

	public function recovery() {
		if ($user = $this->getUser()) {

			if(! empty($user->email)) {
				$user->generatePasswordResetToken();
				$user->save();

				return $user;
			}
		}

		return false;
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'номер зачётки или email',
            'password' => 'Пароль',
        ];
    }
}
