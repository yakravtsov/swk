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


		switch($role_id){
			case User::ROLE_GOD:
				//return $this->redirect(['agent/index']);
				continue;
			case User::ROLE_AGENT:
				return $this->redirect(['agent/requests','id'=>Yii::$app->user->identity->user_id]);
			default:
				return $this->redirect(['/']);


		}


		return TRUE; // or false to not run the action
	}

	/**
	 * Lists all Landing models.
	 * @return mixed
	 */
	public function actionIndex() {
		//die();

		$agents = Agent::find()->asArray()->all();


		$searchModel  = new LandingSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
			'agents'       => $agents
		]);
	}

	/**
	 * Displays a single Landing model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Landing model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Landing();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->request_id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	public function actionNew() {
		$model    = new Landing();
		$form_id  = Yii::$app->request->post($model->formName())['form_id'];
		$scenario = 'form_' . $form_id;
		if (!array_key_exists($scenario, $model->scenarios())) {
//            $this->refresh();
		}

		$model->setScenario($scenario);

		if (in_array($form_id, [3, 4, 5])) {
			$model->setScenario('form_3');
		}

		if (in_array($form_id, [1, 2])) {
			$model->setScenario('form_1');
		}

		/*die(var_dump($_POST));*/


		/**
		 * Отправка уведомлений
		 */
		/*$r = Yii::$app->mailer->compose('/users/mail/recovery', ['contactForm' => $form])
			->setFrom(Yii::$app->params['noreplyEmail'])
			->setTo($form->email)
			->setSubject('Восстановление пароля')
			->send();
		Yii::$app->session->addFlash('recoverySended', 'Вам отправлено письмо. Для завершения восстановления пароля перейдите по ссылке, указанной в письме.');
		// send mail
		// success flash
		die(var_dump($r));*/

		if ($r = $model->load(Yii::$app->request->post()) && $s = $model->save()) {

			$agent = Agent::find()->where(['agent_id' => $model->agent_id])->One();





			//die(var_dump(Yii::$app->request->baseUrl));
			return $this->redirect(['/success', 'type' => preg_replace('/[^0-9.]+/', '', $model->scenario), 'a' => $agent->shortname]);
		} else {
			return $this->redirect('http://studentsonline.ru');
		}
	}

	/**
	 * Updates an existing Landing model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->request_id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Landing model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Landing model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Landing the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Landing::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionEmail2($id) {
		$model = $this->findModel($id);
		$agent = Agent::find()->where(['agent_id'=>$model->agent_id])->One();
			return $this->renderPartial('/landing/mail/message', ['model' => $model,'agent'=>$agent]);
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
		                      $r->compose('/landing/mail/message', ['model' => $model,'agent'=>$agent])
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

	public function actionAgent($id) {
		//$model = $this->findModel($id);

		$agent = Agent::find()->where(['agent_id'=>$id])->one();

		//$custom_query = Landing::find()->where([''])
		$searchModel  = new LandingSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams/*,$custom_query*/);

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
			'agent'       => $agent
		]);
	}
}
