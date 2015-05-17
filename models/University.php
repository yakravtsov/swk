<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "university".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $university_id
 * @property string $name
 * @property string $db_host
 * @property integer $db_port
 * @property string $db_user
 * @property string $db_pass
 * @property string $db_name
 * @property string $paid_till
 * @property integer $tarif
 * @property integer $status
 * @property string $subdomain
 */
class University extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'university';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated', 'paid_till'], 'safe'],
            [['author_id', 'name', 'paid_till', 'tarif', 'status', 'subdomain'], 'required'],
            [['author_id', 'db_port', 'tarif', 'status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['db_host', 'db_user', 'db_name'], 'string', 'max' => 255],
            [['db_pass'], 'string', 'max' => 30],
            [['subdomain'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Created',
            'updated' => 'Updated',
            'author_id' => 'Author ID',
            'university_id' => 'University ID',
            'name' => 'Name',
            'db_host' => 'Db Host',
            'db_port' => 'Db Port',
            'db_user' => 'Db User',
            'db_pass' => 'Db Pass',
            'db_name' => 'Db Name',
            'paid_till' => 'Paid Till',
            'tarif' => 'Tarif',
            'status' => 'Status',
            'subdomain' => 'Subdomain',
        ];
    }
}
