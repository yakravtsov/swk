<?php
namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "import".
 *
 * @property string              $created
 * @property string              $updated
 * @property integer             $author_id
 * @property integer             $file_id
 * @property string|UploadedFile $file
 * @property integer             $university_id
 * @property string              $hash
 * @property integer             $structure_id
 * @property integer             $status
 * @property integer             $try
 * @property string             $csv
 *
 * @property Structure           $structure
 * @property University          $university
 * @property ImportUsers[]          $users
 */
class Import extends \yii\db\ActiveRecord {

	const STATUS_WAITING = 0;
	const STATUS_IN_PROCESS = 1;
	const STATUS_ERROR = 2;
	const STATUS_HAS_ERROR = 3;
	const STATUS_SUCCESS = 4;
	const STATUS_CSV_IN_PROCESS = 4;
	const STATUS_OUTPUT_ERROR = 6;
	const STATUS_IMPORTED = 7;

	/**
	 * @return Import[]|array
	 */
	public static function findReadyToPrepare() {
		return self::find()->where(['status' => [self::STATUS_WAITING, self::STATUS_ERROR, self::STATUS_HAS_ERROR]])
				->all();
	}

	/**
	 * @return Import[]|array
	 */
	public static function findReadyToCsv() {
		return self::find()->where(['status' => [self::STATUS_SUCCESS, self::STATUS_OUTPUT_ERROR]])
		           ->all();
	}

	public function behaviors() {
		return [
			[
				'class'              => BlameableBehavior::className(),
				'createdByAttribute' => 'author_id',
				'updatedByAttribute' => FALSE,
			],
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'created',
				'updatedAtAttribute' => 'updated',
				'value'              => new Expression('NOW()'),
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'import';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['university_id', 'structure_id'], 'required'],
			[['university_id', 'structure_id', 'status', 'try'], 'integer'],
			[['file'], 'file', 'skipOnEmpty' => FALSE, 'extensions' => 'csv', 'checkExtensionByMimeType' => FALSE, 'on'=>'insert'], //todo use mimetypes, not only extension of file
		];
	}

	public function upload() {
		if ($this->validate()) {
			$this->file->saveAs('../uploads/' . $this->file->baseName . '.' . $this->file->extension);

			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'created'       => 'Created',
			'updated'       => 'Updated',
			'author_id'     => 'Author ID',
			'file_id'       => 'File ID',
			'file'          => 'File',
			'university_id' => 'University ID',
			'structure_id'  => 'Structure ID',
			'status'        => 'Status',
			'try'           => 'Try',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getStructure() {
		return $this->hasOne(Structure::className(), ['structure_id' => 'structure_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUsers() {
		return $this->hasMany(ImportUsers::className(), ['file_id' => 'file_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUniversity() {
		return $this->hasOne(University::className(), ['university_id' => 'university_id']);
	}

	/**
	 * @inheritdoc
	 * @return ImportQuery the active query used by this AR class.
	 */
	public static function find() {
		return new ImportQuery(get_called_class());
	}

	public function getPath() {
		return __DIR__.'/../uploads/'.$this->file;
	}

}
