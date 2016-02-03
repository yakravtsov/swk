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
            [['name'], 'required', 'message' => 'Пожалуйста, введите название вашего ВУЗа'],
            [['email'], 'required', 'message' => 'Не сочтите за труд, укажите email'],
            [['phone'], 'string', 'length' => [5], 'tooShort' => 'Номер телефона слишком короткий'],
            [['form_id',], 'integer'],
            [['email'], 'email', 'message' => 'Извольте ввести настоящий email'],
            [['form_id'], 'required'],
            [['params'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            //[['phone'], 'string', 'max' => 50]
        ];
    }

    public function scenarios() {
        return [
            'form_1' => ['name', 'form_id', 'email', 'phone'],
            'form_2' => ['name', 'form_id', 'email', 'phone'],
            'form_3' => ['name', 'form_id', 'email', 'phone'],
            'form_4' => ['name', 'form_id', 'email', 'phone'],
            'form_5' => ['!name', 'form_id', '!email', 'phone'],
            'form_6' => ['name', 'form_id', 'email', 'phone'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'request_id' => 'Request ID',
            'name' => 'Название ВУЗа',
            'email' => 'Email',
            'phone' => 'Телефон',
            'form_id' => 'Form ID',
            'params' => 'Params',
        ];
    }
}
