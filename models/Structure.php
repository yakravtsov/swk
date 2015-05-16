<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "structure".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $structure_id
 * @property string $name
 * @property integer $type
 */
class Structure extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'structure';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['author_id', 'name', 'type'], 'required'],
            [['author_id', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'structure_id' => 'Structure ID',
            'name' => 'Name',
            'type' => 'Type',
        ];
    }
}
