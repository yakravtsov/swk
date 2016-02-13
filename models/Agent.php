<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agent".
 *
 * @property integer $agent_id
 * @property string $shortname
 * @property string $fullname
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $info
 */
class Agent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info'], 'string'],
            [['shortname'], 'string', 'max' => 50],
            [['fullname'], 'string', 'max' => 255],
            [['phone', 'email'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'agent_id' => 'Agent ID',
            'shortname' => 'Shortname',
            'fullname' => 'Fullname',
            'phone' => 'Phone',
            'email' => 'Email',
            'address' => 'Address',
            'info' => 'Info',
        ];
    }
}
