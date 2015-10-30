<?php
namespace app\panels;

use yii\debug\Panel;
use Yii;
use yii\helpers\VarDumper;

class UniversityPanel extends Panel {

	protected $_info;

	public function init() {
		parent::init();
	}


	/**
	 * @inheritdoc
	 */
	public function getName() {
		return 'University';
	}

	/**
	 * @inheritdoc
	 */
	public function getSummary() {
		$url   = $this->getUrl();

		return "<div class=\"yii-debug-toolbar-block\"><a href=\"$url\">University</a></div>";
	}

	/**
	 * @inheritdoc
	 */
	public function getDetail() {
		return /*VarDumper::dumpAsString(Yii::$app->user->identity, 10, true) .*/
			VarDumper::dumpAsString(Yii::$app->request->hostInfo, 10, true).
			VarDumper::dumpAsString(Yii::$app->user->identity, 10, true)
		.VarDumper::dumpAsString(Yii::$app->university, 10, true);
	}

	/**
	 * @inheritdoc
	 */
	public function save() {
		return $this->_info;
	}
}