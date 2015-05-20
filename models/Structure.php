<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "structure".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $structure_id
 * @property string $name
 * @property integer $type
 * @property integer $university_id
 *
 * @property University $university
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
	public function behaviors() {
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'created',
				'updatedAtAttribute' => 'updated',
				'value'              => new Expression('NOW()'),
			],
			[
				'class'     => AuthorBehavior::className(),
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
//            [['type','university_id'], 'safe'],
            [['name'], 'required'],
            [['university_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Дата создания',
            'updated' => 'Дата редактирования',
            'author_id' => 'ID автора',
            'structure_id' => 'ID структуры',
            'name' => 'Название',
            'type' => 'Тип',
			'university_id' => 'University ID',
        ];
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUniversity()
	{
		return $this->hasOne(University::className(), ['university_id' => 'university_id']);
	}
}
