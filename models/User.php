<?php
namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\base\Security;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $user_id
 * @property integer $role_id
 * @property integer $parent_id
 * @property string $email
 * @property string $phio
 * @property integer $company_id
 * @property string $last_login
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $status
 * @property string $login_hash
 * @property integer $structure_id
 * @property integer $university_id
 * @property integer $shared
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    const ROLE_GUEST = 0;
    const ROLE_TEACHER = 2;
    const ROLE_STUDENT = 4;
    const ROLE_ADMINISTRATOR = 8;
    const ROLE_GOD = 16;

    const ROLE_AGENT = 32;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $_password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     *
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param $email
     *
     * @return null|static
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByRecordBookId($id)
    {
        return static::findOne(['number' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     *
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return NULL;
        }
        $conditions = array_merge(self::getDefaultConditions(), [
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);

        return static::findOne($conditions);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AuthorBehavior::className(),
                'attribute' => 'author_id',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['user_id', 'default', 'value' => NULL, 'on' => 'signup'],
            ['shared', 'safe', 'on' => 'sharing'],
            [['author_id'], 'safe', 'on' => 'import'],
            [['university'], 'safe', 'on' => 'signup'],
            //[['email'], 'required', 'on' => 'signup'],
            [['parent_id'], 'integer', 'on' => 'signup'],
            [['email', 'phio'], 'string', 'max' => 255, 'on' => 'signup'],
            [['email'], 'email', 'on' => 'signup'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'unique', 'message' => 'Этот адрес уже занят.', 'on' => 'signup'],
            ['email', 'exist', 'message' => 'Пользователь с таким email не найден.', 'on' => 'requestPasswordResetToken'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            ['role_id', 'default', 'value' => self::ROLE_TEACHER, 'on' => 'signup'],
            ['role_id', 'default', 'value' => self::ROLE_STUDENT, 'on' => 'import'],
            //			['password', 'default', 'value' => $this->generatePassword(), 'on' => 'import'],
            [['number', 'university_id'], 'uniqueStudent', 'on' => 'import'],
            /*[['university_id'], 'default', 'value'=>Yii::$app->user->identity->structure->university_id, 'when'=>function() {
//					Yii::$app->user->identity->role_id == self::ROLE_ADMINISTRATOR
                    return false;
                }],*/
            ['role_id', 'in', 'range' => [self::ROLE_TEACHER, self:: ROLE_STUDENT, self::ROLE_ADMINISTRATOR, self::ROLE_AGENT], 'on' => 'signup'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function scenarios()
    {
        return [
            'signup' => ['user_id', 'email', 'password', '!status', '!role', 'role_id', 'structure_id', 'phio', 'number', 'about', 'university_id'],
            'import' => ['user_id', 'number', 'status', 'role_id', 'phio', 'password', 'structure_id', 'university_id', 'start_year', 'author_id'],
            'update' => ['user_id', 'email', 'password', '!status', '!role', 'role_id', 'structure_id', 'phio', 'number', 'about', 'university_id'],
            'sharing' => ['shared'],
            'default' => [],
            //			'resetPassword' => ['password'],
            'requestPasswordResetToken' => ['email'],
        ];
    }

    public function getRoleLabel($role = null)
    {
        $keys = $this->getRoleValues();
        $roleId = $role ?: $this->role_id;
        return array_key_exists($roleId, $keys) ? $keys[$roleId] : 'Неизвестная роль';
    }

    /**
     * @return array
     */
    public function getRoleValues()
    {
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == self::ROLE_GOD){
            $role_values = [
                self::ROLE_GUEST => 'Гость',
                self::ROLE_TEACHER => 'Преподаватель',
                self::ROLE_STUDENT => 'Студент',
                self::ROLE_ADMINISTRATOR => "Администратор",
                self::ROLE_GOD => "ROLE_GOD",
                self::ROLE_AGENT => "Агент"
            ];
        } else {
            $role_values = [
                self::ROLE_TEACHER => 'Преподаватель',
                self::ROLE_STUDENT => 'Студент',
                self::ROLE_ADMINISTRATOR => "Администратор",
            ];
        }
        return $role_values;
    }

    public function getOtherRoles()
    {
        $all = $this->getRoleValues();
        unset($all[Yii::$app->user->identity->role_id]);

        return $all;
    }

    public function getStatusLabel()
    {
        $keys = $this->getStatusValues();

        return array_key_exists($this->status, $keys) ? $keys[$this->status] : 'Неизвестный статус';
    }

    /**
     * @return array
     */
    public function getStatusValues()
    {
        $keys = [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_INACTIVE => 'Заблокирован',
        ];

        return $keys;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Создан',
            'updated' => 'Редактирован',
            'author_id' => 'Автор',
            'user_id' => 'ID',
            'role_id' => 'Роль',
            'parent_id' => 'Parent ID',
            'email' => 'Email',
            'phio' => 'Ф. И. О.',
            'company_id' => 'Организация',
            'password' => 'Пароль',
            'last_login' => 'Последний вход',
            'status' => 'Статус',
            'login_hash' => 'Хэш входа',
            'structure_id' => 'ID структуры',
            'number' => '№ зачётки, документа',
            'structure' => 'Институт',
            'about' => 'О студенте',
            'start_year' => 'Год поступления',
            'university_id' => 'ID университета',
            'university' => 'Университет',
            'shared' => 'Доступ по ссылке'
        ];
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     *
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Validates the given auth key.
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     *
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     * The space of such keys should be big enough to defeat potential identity attacks.
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return '';
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if ($this->scenario !== 'update') {
            $this->_password = $password;
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        } else {
            if ($password !== '') {
                $this->_password = $password;
                $this->password_hash = Yii::$app->security->generatePasswordHash($password);
            }
            //die(var_dump($this->password));
        }
    }

    public function getPassword()
    {
        return $this->scenario == 'import' ? $this->_password : FALSE;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString(20) . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = NULL;
    }

    public function generateLoginHash($email)
    {
        $this->login_hash = hash('ripemd160', date('mdYhis', time()) . $email);
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasMany(self::className(), ['user_id' => 'author_id'])->AsArray()->One();
    }

    public function getAuthorName()
    {
        return $this->getAuthor();
    }

    /**
     * @return ActiveQuery
     */
    public function getStructure()
    {
        return $this->hasOne(Structure::className(), ['structure_id' => 'structure_id']);
    }

    public function setStructure($structure_id)
    {
        return TRUE;
    }

    public function getUniversity()
    {
        return $this->hasOne(University::className(), ['university_id' => 'university_id']);
    }

    public function setUniversity($university_id)
    {
        return TRUE;
    }

    public function uniqueStudent($attribute, $params)
    {
        if ($a = self::findOne(['number' => $this->number, 'university_id' => $this->university_id])) {
            $this->addError('number', 'Уже существует!');
        }
    }

    protected function getDefaultConditions()
    {
        $conditions = [
            'status' => self::STATUS_ACTIVE,
        ];
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role_id != self::ROLE_GOD) {
            $conditions['university_id'] == Yii::$app->university->model->structure_id;
        }

        return $conditions;
    }

}
