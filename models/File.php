<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file".
 *
 * @property integer $file_id
 * @property string $real_name
 * @property string $path
 * @property integer $size
 * @property integer $work_id
 *
 * @property StudentWorks $work
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'work_id'], 'required'],
			[['real_name'], 'trim'],
            [['real_name', 'path'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'real_name' => 'Real Name',
            'path' => 'Path',
            'size' => 'Size',
            'work_id' => 'Work ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWork()
    {
        return $this->hasOne(StudentWorks::className(), ['work_id' => 'work_id']);
    }

	private function getFilePath(UploadedFile $file) {
		$md5_file            = md5_file($file->tempName);
		$md5 = md5(Yii::$app->user->identity->email . Yii::$app->user->identity->created);
		$route          = substr($md5, 0, 3) . '/' . substr($md5, 3, 3) . '/';
		$dir            = Yii::$app->getBasePath() . '/data/' . $route;
		if (!is_dir($dir)) {
			mkdir($dir, 0755, TRUE);
			if (is_dir($dir)) {
				Yii::info("image service create directory $dir");
			} else {
				Yii::warning("image service create directory fail $dir");
			}
		}
		$filePath = $dir . substr($md5_file, 6) . '.' . $file->getExtension();

		return $filePath;
	}

	public function afterDelete() {
		@unlink($this->path);

		parent::afterDelete();
	}

	public function processFile(UploadedFile $file) {
		$filePath = $this->getFilePath($file);
		if(!$file->hasError && $file->saveAs($filePath)){
			$this->path = $filePath;
			$this->size = $file->size;
			$this->real_name = $file->name;
		} else {
			$this->addError('file', "Не удалось запись на диск файл {$this->file_id}");
		}
	}
}
