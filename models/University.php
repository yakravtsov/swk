<?php
namespace app\models;

use app\components\AuthorBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "university".
 *
 * @property string    $created
 * @property string    $updated
 * @property integer   $author_id
 * @property integer   $university_id
 * @property string    $name
 * @property string    $db_host
 * @property integer   $db_port
 * @property string    $db_user
 * @property string    $db_pass
 * @property string    $db_name
 * @property string    $paid_till
 * @property integer   $tarif
 * @property integer   $status
 * @property string    $subdomain
 * @property integer   $type
 *
 * @property Structure[] $structures
 */
class University extends \yii\db\ActiveRecord {

	const TYPE_ADMINISTRATION = 1;
	const TYPE_UNIVERSITY = 2;

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;

	const TARIF_SIMPLE = 1;
	const TARIF_STANDART = 2;
	const TARIF_EXTENDED = 3;
	const TARIF_UNLIMITED = 4;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'university';
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
	public function rules() {
		return [
			[['name', /*'paid_till', */
			  'tarif', 'status', 'subdomain', 'type'], 'required'],
			['paid_till', 'safe'],
			['subdomain', 'unique'],
			[['db_port', 'tarif', 'status', 'type',/* 'paid_till'*/], 'integer'],
			[['name'], 'string', 'max' => 100],
			[['db_host', 'db_user', 'db_name'], 'string', 'max' => 255],
			[['db_pass'], 'string', 'max' => 30],
			[['subdomain'], 'string', 'max' => 10]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'created'       => 'Дата создания',
			'updated'       => 'Дата редактирования',
			'author_id'     => 'ID автора',
			'university_id' => 'ID университета',
			'name'          => 'Название',
			'db_host'       => 'dbhost',
			'db_port'       => 'dbport',
			'db_user'       => 'dbuser',
			'db_pass'       => 'dbpass',
			'db_name'       => 'dbname',
			'paid_till'     => 'Оплачен до',
			'tarif'         => 'Тариф',
			'status'        => 'Статус',
			'subdomain'     => 'Поддомен',
			'type'          => 'Тип',
		];
	}

	public static function getUniversities() {
	}

	public function getStatusLabel() {
		$keys = $this->getStatusValues();

		return array_key_exists($this->status, $keys) ? $keys[$this->status] : 'Неизвестный статус';
	}

	/**
	 * @return array
	 */
	public function getStatusValues() {
		$keys = [
			self::STATUS_ACTIVE   => 'Активен',
			self::STATUS_INACTIVE => 'Заблокирован',
		];

		return $keys;
	}

	/**
	 * @return array
	 */
	public function getTarifValues() {
		return [
			self::TARIF_SIMPLE    => 'Простой',
			self::TARIF_STANDART  => 'Стандартный',
			self::TARIF_EXTENDED  => 'Расширенный',
			self::TARIF_UNLIMITED => 'Безлимитный'
		];
	}

	public function getTarifLabel() {
		$keys = $this->getTarifValues();

		return array_key_exists($this->tarif, $keys) ? $keys[$this->tarif] : 'Неизвестный тариф';
	}

	public function getTarifLabelClass() {
		$labels = [
			self::TARIF_SIMPLE    => 'info',
			self::TARIF_STANDART  => 'primary',
			self::TARIF_EXTENDED  => 'success',
			self::TARIF_UNLIMITED => 'warning'
		];

		return array_key_exists($this->tarif, $labels) ? $labels[$this->tarif] : '';
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert) {
		$this->paid_till = Yii::$app->formatter->asDate($this->paid_till, 'yyyy-MM-dd');

		return parent::beforeSave($insert);
	}

	public function afterFind() {
		parent::afterFind();
		$this->paid_till = Yii::$app->formatter->asDate($this->paid_till, 'php:d M Y');
	}

	/**
	 * @param $subdomain
	 *
	 * @return null|$this
	 */
	public static function findBySubdomain($subdomain) {

		return self::findOne(['subdomain' => $subdomain]);
	}

	public function getStructures() {
		return $this->hasMany(Structure::className(), ['university_id' => 'university_id']);
	}
}
