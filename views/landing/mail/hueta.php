<?php

namespace app\controllers;

use app\models\Agent;
use app\models\User;
use Yii;
use app\models\Landing;
use app\models\search\LandingSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LandingController implements the CRUD actions for Landing model.
 */
class LandingController extends Controller
{
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				//                'only' => ['logout', 'about'],
				'rules' => [
					[
						'actions' => ['new'],
						'allow'   => TRUE,
						'roles'   => ['?'],
					],
					[
						//'actions' => ['*'],
						'allow' => TRUE,
						'roles' => ['@'],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	public function beforeAction($action) {
		if (!parent::beforeAction($action)) {
			return FALSE;
		}
		$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;


		switch ($role_id) {
			case User::ROLE_GOD:
				//return $this->redirect(['agent/index']);
				continue;
			case User::ROLE_AGENT:
				return $this->redirect(['agent/requests', 'id' => Yii::$app->user->identity->user_id]);
			default:
				return $this->redirect(['/']);


		}


		return TRUE; // or false to not run the action
	}

	public function actionEmail2($id) {
		$model = $this->findModel($id);
		$agent = Agent::find()->where(['agent_id' => $model->agent_id])->One();

		return $this->renderPartial('/landing/mail/message', ['model' => $model, 'agent' => $agent]);
		/*$r = Yii::$app->mailer->setTransport([
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.yandex.ru',
				'port' => '465',
				'username' => 'robot@studentsonline.ru',
				'password' => '0kujCZt5',
				'encryption' => 'ssl',
			]);*/
		$r = Yii::$app->mailer;
		$r->setTransport(Yii::$app->params['emailRobotTransport']);
		$r->compose('/landing/mail/message', ['model' => $model, 'agent' => $agent])
		  ->setFrom(Yii::$app->params['emailRobot'])
		  ->setTo('pochta@studentsonline.ru')
		  ->setSubject('Новая заявка')
		  ->send();
		//var_dump($r);
		//Yii::$app->session->addFlash('recoverySended', 'Вам отправлено письмо. Для завершения восстановления пароля перейдите по ссылке, указанной в письме.');
	}

	public function actionEmail3() {
		return $this->renderPartial('/landing/mail/artem', []);
		$r = Yii::$app->mailer;
		//$r->setTransport(Yii::$app->params['pochta']);
		$r->compose('/landing/mail/artem', [])
		  ->setFrom(Yii::$app->params['pochta'])
		  ->setTo('yakravtsov@gmail.com')
		  ->setSubject('Данные для доступа в портфолио СИФК')
		  ->send();
	}

	public function actionEmail4() {
		return $this->renderPartial('/landing/mail/sarsys', []);
		$r = Yii::$app->mailer;
		//$r->setTransport(Yii::$app->params['pochta']);
		$r->compose('/landing/mail/sarsys', [])
		  ->setFrom(Yii::$app->params['pochta'])
		  ->setTo('yakravtsov@gmail.com')
		  ->setSubject('Предложение о сотрудничестве')
		  ->send();
	}
}