<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class LandController extends Controller {

	public function actionIndex() {
		$this->layout = '../layouts/land';

		return $this->render('index');
	}
}
