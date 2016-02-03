<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Landing;

class LandController extends Controller {

	/**
	 * @return string
	 */
	public function actionIndex() {
		$this->layout = '../layouts/land';

		Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false;

		$model = new Landing();
		$model->setScenario('form_1');

		$model2 = new Landing();
		$model2->setScenario('form_2');

		$model3 = new Landing();
		$model3->setScenario('form_3');

		$model6 = new Landing();
		$model6->setScenario('form_6');


		return $this->render('index', [
			'model' => $model,
			'model2' => $model2,
			'model3' => $model3,
			'model6' => $model6,
		]);
	}

	public function actionSuccess($type) {
		$this->layout = '../layouts/land';

		return $this->render('success', [
			'type' => $type
		]);
	}

	public function actionPresentation() {
		Yii::$app->response->sendFile("../web/misc/Elektronnoye_portfolio_-_StudentsOnline.ru.pdf", 'Электронное портфолио — StudentsOnline.ru.pdf');
	}
}
