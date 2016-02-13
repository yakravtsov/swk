<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "landing".
 *
 * @property integer $request_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $form_id
 * @property integer $agent_id
 * @property string $params
 */
class Landing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'landing';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required', 'message' => 'Будьте добры, укажите номер телефона'],
            [['name'], 'required', 'message' => 'Пожалуйста, введите название вашего вуза'],
            [['email'], 'required', 'message' => 'Не сочтите за труд, укажите email'],
            [['phone'], 'string', 'length' => [5], 'tooShort' => 'Номер телефона слишком короткий'],
            [['form_id'], 'integer'],
            [['email'], 'email', 'message' => 'Извольте ввести настоящий email'],
            [['phone', 'email', 'name'], 'trim'],
            [['form_id'], 'required'],
            [['agent_id'], 'required'],
            [['params'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['agent_id'], 'integer'],
            //[['phone'], 'string', 'max' => 50]
        ];
    }

    public function scenarios() {
        return [
            'form_1' => ['name', 'form_id', 'agent_id', 'email', 'phone'],
            'form_2' => ['name', 'form_id', 'agent_id', 'email', 'phone'],
            'form_3' => ['name', 'form_id', 'agent_id', 'email', 'phone'],
            'form_4' => ['name', 'form_id', 'agent_id', 'email', 'phone'],
            'form_5' => ['name', 'form_id', 'agent_id', '!email', 'phone'],
            'form_6' => ['form_id', 'agent_id', 'phone'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'request_id' => 'Request ID',
            'name' => 'Название вуза',
            'email' => 'Email',
            'phone' => 'Телефон',
            'form_id' => 'Form ID',
            'params' => 'Params',
            'agent_id' => 'ID агента',
            'agent' => 'Агент',
        ];
    }

    public function getFormLabel($role = null)
    {
        $keys = $this->getFormValues();
        $roleId = $role ?: $this->role_id;
        return array_key_exists($roleId, $keys) ? $keys[$roleId] : 'Неизвестная роль';
    }

    /**
     * @return array
     */
    public function getFormValues()
    {
        $form_values = [
            1 => '«Попробуйте демоверсию» на первом экране',
            2 => '«Попробуйте демоверсию» на сером фоне',
            3 => 'Тариф «Минимальный»',
            4 => 'Тариф «Стандарт»',
            5 => 'Тариф «Расширенный»',
            6 => '«Заказать консультацию»'
        ];
        return $form_values;
    }

    public function getAgent() {
        return $this->hasOne(Agent::className(), ['agent_id' => 'agent_id']);
    }
/*
    public function getAuthorName() {
        return $this->author['phio'];
    }

    public function getAllauthors() {
        return $this->hasMany(User::className(), ['author_id' => 'author_id']);
    }*/

    public function setAgent() {
        return true;
    }
}
