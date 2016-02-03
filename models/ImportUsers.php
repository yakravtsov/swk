<?php
namespace app\models;

use Yii;

/**
 * This is the model class for collection "import_users".
 *
 * @property \MongoId|string $_id
 * @property mixed           $file_id
 * @property mixed           $university_id
 * @property mixed           $structure_id
 * @property mixed           $author_id
 * @property mixed           $phio
 * @property mixed           $number
 * @property mixed           $start_year
 * @property mixed           $import_status
 * @property mixed           $password_hash
 * @property mixed           $try
 * @property mixed           $created
 * @property mixed           $updated
 */
class ImportUsers extends \yii\mongodb\ActiveRecord {

	const STATUS_WAITING = 0;
	const STATUS_SUCCESS = 1;
	const STATUS_ERROR = 2;
	const MAX_TRIES = 5;

	/**
	 * @inheritdoc
	 */
	public static function collectionName() {
		return 'import_users';
	}

	/**
	 * @return ImportUsers[]
	 */
	public static function findReadyToProcess() {
		return self::find()->where(['import_status' => [self::STATUS_WAITING, self::STATUS_ERROR]])
//		           ->where(['<', 'try ', self::MAX_TRIES + 1])
		           ->all();
	}

	/**
	 * @inheritdoc
	 */
	public function attributes() {
		return [
			'_id',
			'file_id',
			'university_id',
			'structure_id',
			'author_id',
			'phio',
			'number',
			'start_year',
			'import_status',
			'try',
			'password_hash',
			//            'created',
			//            'updated',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['phio', 'number', 'start_year', 'try', 'author_id', 'file_id',/*, 'created', 'updated'*/], 'safe', 'on' => 'insert'],
			//			[['file_id'], 'exist', 'targetClass' => File::className(), 'targetAttribute' => 'file_id'],
			[['university_id'], 'exist', 'targetClass' => University::className(), 'targetAttribute' => 'university_id'],
			[['structure_id'], 'exist', 'targetClass' => Structure::className(), 'targetAttribute' => 'structure_id'],
			[['phio'], 'string', 'min' => 5, 'max' => 100, 'on' => 'insert'],
			['password_hash', 'default', 'value' => function ($model, $attribute) {
				return Yii::$app->security->generateRandomString(8);
			}, 'on'                                => 'insert'],
			[['try', 'import_status'], 'default', 'value' => self::STATUS_WAITING, 'on' => 'insert']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'_id'           => 'ID',
			'file_id'       => 'File ID',
			'phio'          => 'Phio',
			'number'        => 'Number',
			'start_year'    => 'Start Year',
			'import_status' => 'Import Status',
			'try'           => 'Try',
			'password' => 'pwd'

			//			            'created' => 'Created',
			//			            'updated' => 'Updated',
		];
	}

	public function isSuccess() {
		return $this->import_status == self::STATUS_SUCCESS;
	}
}
