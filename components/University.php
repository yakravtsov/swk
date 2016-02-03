<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 08.06.15
 * Time: 23:15
 * All rights are reserved
 */
namespace app\components;

use app\models\Structure;
use yii\base\Component;
use Yii;

class University extends Component {

	public $name;
	/** @var  \app\models\University */
	public $model;

	public function init() {
		$serverName = explode('.', Yii::$app->request->getServerName());
		$resName = [];
		foreach($serverName as $item) {
			if($item!='local') {
				$resName[] = $item;
			}
		}
		$serverName = $resName;
		if (count($serverName) == 3) {
			if (strlen($serverName[0]) > 2) {
				$this->name  = trim(strtolower($serverName[0]));
				$this->model = \app\models\University::findBySubdomain($this->name);
				if (!$this->model || $this->checkAccess()) {
					Yii::$app->response->redirect('http://' .    $serverName[1]. '.' . $serverName[2]);
				}
			}
		}
		parent::init();
	}

	public function checkAccess() {
		$paidTill = strtotime($this->model->paid_till);
		$current = time();
		Yii::info("paid: {$paidTill},     current: $current");
		return $paidTill>$current;
	}
}