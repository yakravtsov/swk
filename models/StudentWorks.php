<?php

namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\validators\FileValidator;
use yii\web\UploadedFile;

/**
 * This is the model class for table "student_works".
 *
 * @property string $created
 * @property string $updated
 * @property integer $author_id
 * @property integer $work_id
 * @property string $filename
 * @property string $title
 * @property integer $type
 * @property integer $mark
 * @property string $comment
 * @property string $review
 * @property integer $discipline_id
 * @property integer $student_id
 * @property integer $status
 * @property integer $teacher_id
 * @property User $author
 *
 * @property User $student
 * @property File[] $files
 */
class StudentWorks extends ActiveRecord
{

    const TYPE_REFERAT = 1;
    const TYPE_COURSEWORK = 2;
    const TYPE_DRAFT = 4;
    const TYPE_LABORATORY = 8;
    const TYPE_REPORT = 8;
    const TYPE_CANDIDATE_WORK = 16;
    const TYPE_HOME_WORK = 32;
    const TYPE_DOCTOR_WORK = 64;
    const TYPE_PRESENTATION = 128;
    const TYPE_GROUP_WORK = 256;
    const TYPE_EXAMINATION = 512;
    const TYPE_OFFSET = 1024;
    const TYPE_TEST = 2048;
    const TYPE_CONTROL_WORK = 4096;
    const TYPE_CHECK = 8192;

    const STATUS_NEW = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_REJECTED = 4;

    const DISCIPLINE_STUDYING = 1;
    const DISCIPLINE_RESEARCH = 2;
    const DISCIPLINE_COMMUNITY = 4;
    const DISCIPLINE_CULTURAL = 8;

    public $filename;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AuthorBehavior::className(),
                'attribute' => 'author_id',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_works';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discipline_id', 'title'], 'required'],
            [['type', 'discipline_id', 'mark', 'student_id', 'status', 'teacher_id'], 'integer'],
            [['status'], 'default', 'value' => self::STATUS_NEW, 'when' => function ($model) {
                /** @var $model self */
                return $model->isNewRecord || Yii::$app->user->identity->role_id == User::ROLE_STUDENT;
            }],
            [['title'], 'trim'],
            [['comment', 'review', 'title'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created' => 'Дата загрузки',
            'updated' => 'Дата изменения',
            'author_id' => 'Автор',
            'work_id' => 'Идентификатор',
            'filename' => 'Прикреплённые файлы',
            'type' => 'Тип работы',
            'mark' => 'Оценка',
            'review' => 'Рецензия',
            'comment' => 'Текст записи',
            'discipline_id' => 'Деятельность',
            'student_id' => 'Выполнил',
            'teacher_id' => 'Проверил',
            'status' => 'Статус',
            'title' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(User::className(), ['user_id' => 'student_id']);
    }

    public function getWorkTypes()
    {
        return [
            self::TYPE_REFERAT => 'Реферат',
            self::TYPE_COURSEWORK => 'Курсовая',
            self::TYPE_DRAFT => 'Чертеж',
            self::TYPE_LABORATORY => 'Лабораторная',
            self::TYPE_REPORT => 'Доклад',
            self::TYPE_CANDIDATE_WORK => 'Кандидатская',
            self::TYPE_HOME_WORK => 'Домашняя',
            self::TYPE_DOCTOR_WORK => 'Докторская',
            self::TYPE_PRESENTATION => 'Презентация',
            self::TYPE_GROUP_WORK => 'Групповая',
            self::TYPE_EXAMINATION => 'Экзамен',
            self::TYPE_OFFSET => 'Зачёт',
            self::TYPE_TEST => 'Тест',
            self::TYPE_CONTROL_WORK => 'Контрольная',
            self::TYPE_CHECK => 'Проверочная',
        ];
    }

    public function getMarkLabel()
    {
        $keys = $this->getMarkValues();

        return array_key_exists($this->mark, $keys) ? "(" . $keys[$this->mark] . ")" : '';
    }

    public function getMarkValues()
    {
        $keys = [
            1 => 'Незачёт',
            2 => 'Неудовлетворительно',
            3 => 'Удововлетворительно',
            4 => 'Хорошо',
            5 => 'Отлично',
        ];

        return $keys;
    }

    public function getStatusLabel()
    {
        $keys = $this->getStatusValues();

        return array_key_exists($this->status, $keys) ? $keys[$this->status] : 'Неизвестный статус';
    }

    /**
     * @return array
     */
    public function getStatusValues()
    {
        $keys = [
            self::STATUS_NEW => 'На рассмотрении',
            self::STATUS_CONFIRMED => 'Подтверждено',
            self::STATUS_REJECTED => 'Отклонено',
        ];

        return $keys;
    }

    public function getStatusClass()
    {
        $statusClasses = [
            self::STATUS_NEW => 'info',
            self::STATUS_CONFIRMED => 'success',
            self::STATUS_REJECTED => 'danger',
        ];

        return array_key_exists($this->status, $statusClasses) ? $statusClasses[$this->status] : 'default';
    }

    public function getDisciplineLabel()
    {
        $keys = $this->getDisciplineValues();

        return array_key_exists($this->discipline_id, $keys) ? $keys[$this->discipline_id] : 'Неизвестный тип';
    }

    /**
     * @return array
     */
    public function getDisciplineValues()
    {
        $keys = [
            self::DISCIPLINE_STUDYING => 'Учебная',
            self::DISCIPLINE_RESEARCH => 'Научно-исследовательская',
            self::DISCIPLINE_COMMUNITY => 'Общественная',
            self::DISCIPLINE_CULTURAL => 'Культурно-творческая',
        ];

        return $keys;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['user_id' => 'author_id']);
    }

    public function getAuthorName()
    {
        return $this->author['phio'];
    }

    public function getAllauthors()
    {
        return $this->hasMany(User::className(), ['author_id' => 'author_id']) /*
		            ->viaTable('project_company', ['project_id' => 'project_id'])*/
            ;
    }

    public function setAuthor()
    {
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['work_id' => 'work_id']);
    }

    public function getAllFilesSize()
    {
        $summarySize = 0;
        foreach ($this->files as $file) {
            $summarySize += $file->size;
        }

        return $summarySize;
    }

    public function addFile(UploadedFile $file)
    {
        $freeMemory = 1024 * 1024 * 1024 - $this->getAllFilesSize();
        if ($freeMemory < $file->size) {
            $this->addError('filename', 'Слишком большой файл');

            return FALSE;
        } else {
            $model = new File;
            $model->processFile($file);
            $this->link('files', $model);
            $r = $model->save();
            Yii::$app->session->addFlash($model->path, $r);

            return $r;
        }
    }

    public function beforeDelete()
    {
        foreach ($this->files as $file) {
            $file->delete();
        }

        return parent::beforeDelete();
    }
}
