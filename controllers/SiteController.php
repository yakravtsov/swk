<?php
namespace app\controllers;

use app\models\User;
use Yii;
use yii\base\Object;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => ['logout',],
				/*'denyCallback' => function ($rule, $action) {
					throw new \Exception('You are not allowed to access this page');
				},*/
				'rules' => [
					[
						'actions' => ['logout',],
						'allow'   => TRUE,
						'roles'   => ['@'],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	public function actions() {
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : NULL,
			],
		];
	}

	public function actionIndex() {
		$model = new LoginForm();

		return $this->render('about', [
			'model' => $model,
		]);
	}

	public function actionLogin() {
		$university_exist = !empty(Yii::$app->university->name);
		if (!\Yii::$app->user->isGuest) {
			return $this->redirect(Yii::$app->user->getHomePageUrl());
		}
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->redirect(Yii::$app->user->getHomePageUrl());
		} else {
			return $this->render($university_exist ? 'about' : 'studentsonline', [
				'model' => $model,
			]);
		}
	}

	public function actionLogin_as($user) {
		if(Yii::$app->university->model->subdomain == "demo"){
			$users = [
				'student'       => 'demo_student',
				'professor' => 'demo_professor',
				'administrator'  => 'demo_administrator',
			];

			if (!\Yii::$app->user->isGuest) {
				return $this->redirect(Yii::$app->user->getHomePageUrl());
			}

			$model = new LoginForm();
			$model->email = $users[$user];
			$model->password = 'demo';
			if (Yii::$app->request->isPost && $model->login()) {
				//die(var_dump($model->login()));
				return $this->redirect(Yii::$app->user->getHomePageUrl());
			} else {
				return $this->render('about', [
					'model' => $model,
				]);
			}
		} else {
			return $this->redirect(Yii::$app->user->getHomePageUrl());
		}
	}

	public function actionLogout() {
		$originalId = Yii::$app->session->get('user.idbeforeswitch');
		if ($originalId) {
			$user     = User::findOne($originalId);
			$duration = 0;
			Yii::$app->user->switchIdentity($user, $duration);
			Yii::$app->session->remove('user.idbeforeswitch');

			return $this->redirect(Yii::$app->user->getHomePageUrl());
		} else {
			Yii::$app->user->logout();

			return $this->goHome();
		}
	}

	public function actionContact() {
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		} else {
			return $this->render('contact', [
				'model' => $model,
			]);
		}
	}

	public function actionAbout() {
		$model = new LoginForm();

		return $this->render('about', [
			'model' => $model,
		]);
	}

	public function actionManual() {
		return $this->render('manual', [
			//'model' => $model,
		]);
	}

	public function actionGetmanual() {
		Yii::$app->response->sendFile(Yii::$app->basePath . '/misc/manual.pdf', 'manual.pdf');
		/*$file_url = 'http://www.myremoteserver.com/file.exe';
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
		readfile($file_url); // do the double-download-dance (dirty but worky)*/
	}
}
