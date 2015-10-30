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
	public $model;

	public function init() {
		$serverName = explode('.', Yii::$app->request->getServerName());
		if (count($serverName) == 3) {
			if (strlen($serverName[0]) > 3) {
				$this->name = trim(strtolower($serverName[0]));
				$this->model = \app\models\University::findBySubdomain($this->name);
			} else {
				//					Yii::$app->response->redirect('/');
			}
		}
		parent::init();
	}
}