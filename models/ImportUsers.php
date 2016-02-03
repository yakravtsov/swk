<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "import_users".
 *
 * @property \MongoId|string $_id
 * @property mixed $file_id
 * @property mixed $phio
 * @property mixed $nubmer
 * @property mixed $start_year
 * @property mixed $import_status
 * @property mixed $try
 * @property mixed $created
 * @property mixed $updated
 */
class ImportUsers extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'import_users';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'file_id',
            'university_id',
            'structure_id',
            'phio',
            'nubmer',
            'start_year',
            'import_status',
            'try',
//            'created',
//            'updated',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'phio', 'nubmer', 'start_year', 'import_status', 'try'/*, 'created', 'updated'*/], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'file_id' => 'File ID',
            'phio' => 'Phio',
            'nubmer' => 'Nubmer',
            'start_year' => 'Start Year',
            'import_status' => 'Import Status',
            'try' => 'Try',
//            'created' => 'Created',
//            'updated' => 'Updated',
        ];
    }
}
