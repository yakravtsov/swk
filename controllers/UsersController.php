<?php

namespace app\controllers;

use app\models\Company;
use app\models\LoginForm;
use app\models\Structure;
use app\models\StudentWorks;
use app\models\search\StudentWorksSearch;
use app\models\University;
use Yii;
use app\models\User;
use app\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller {

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				//                'only' => ['logout', 'about'],
				'rules' => [
					[
						'actions' => ['view', 'for'],
						'allow'   => TRUE,
						'roles'   => ['?'],
					],
					[
						//                        'actions' => ['*'],
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
		if ($action->id == "index") {
			switch ($role_id) {
				case User::ROLE_ADMINISTRATOR:
					return TRUE;
					break;
				case User::ROLE_TEACHER:
					return $this->redirect(['/users/students', 'id' => Yii::$app->user->identity->user_id]);
					break;
				default:
					return $this->redirect('/');
			}
		}
		if ($action->id == "getpasswords") {
			switch ($role_id) {
				case User::ROLE_ADMINISTRATOR:
					return TRUE;
					break;
				default:
					return $this->redirect('/users');
			}
		}

		/*if ($role_id !== User::ROLE_ADMINISTRATOR || $role_id !== User::ROLE_TEACHER) {
			return $this->redirect('/');
		} else {
			if($action->id == "index" && $role_id !== User::ROLE_TEACHER){
				return $this->redirect('/users/students');
			}
		}*/

		return TRUE; // or false to not run the action
	}

	/**
	 * Lists all User models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new UserSearch();
		/*$dataProvider = new ActiveDataProvider([
			'query' => User::find()
		]);*/
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$authors      = ArrayHelper::map(User::find()->all(), 'id', 'phio');
		$mo           = new User;
		$statuses     = $mo->getStatusValues();
		$roles        = $mo->getRoleValues();
		$structures   = ArrayHelper::map(Structure::find()->all(), 'structure_id', 'name');

		return $this->render('index', [
									  'dataProvider' => $dataProvider,
									  'searchModel'  => $searchModel,
									  'authors'      => $authors,
									  'statuses'     => $statuses,
									  'roles'        => $roles,
									  'structures'   => $structures,
									  ]);
	}

	/**
	 * Displays a single User model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id) {
		$searchModel  = new StudentWorksSearch();
		$custom_query = StudentWorks::find()->where(['author_id' => $id]);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);
		$model        = new StudentWorks();
		$statuses     = $model->getStatusValues();
		$disciplines  = $model->getDisciplineValues();

		return $this->render('view', [
									 'model'        => $this->findModel($id),
									 'searchModel'  => $searchModel,
									 'dataProvider' => $dataProvider,
									 'statuses'     => $statuses,
									 'disciplines'  => $disciplines
									 ]);
	}

	/**
	 * Creates a new User model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model           = new User();
		$model->scenario = 'signup';
		if ($model->load(Yii::$app->request->post())) {
			$model->generateLoginHash($model->email);
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->user_id]);
			}
		} else {
			return $this->render('create', [
										   'model' => $model
										   ]);
		}
	}

	/**
	 * Updates an existing User model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$role_id         = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
		$current_user    = Yii::$app->user->identity->user_id;
		$model           = $this->findModel($id);
		$model->scenario = 'signup';
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			switch ($role_id) {
				case User::ROLE_TEACHER:
					return $this->redirect(['/users']);
					break;
				case User::ROLE_STUDENT:
					if ($current_user == $id) {
						return $this->render('update', [
													   'model'   => $model,
													   'role_id' => $role_id
													   ]);
					} else {
						return $this->redirect(['update', 'id' => $current_user]);
					}
					break;
				case User::ROLE_ADMINISTRATOR:
					return $this->render('update', [
												   'model'   => $model,
												   'role_id' => $role_id
												   ]);
			}
		}
	}

	/**
	 * Deletes an existing User model.
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
	 * Finds the User model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = User::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionStudents($id) {
		$searchModel  = new UserSearch();
		$structure_id = Yii::$app->user->identity->attributes['structure_id'];
		$custom_query = User::find()->where(['structure_id' => $structure_id])
							->andWhere(['role_id' => User::ROLE_STUDENT]);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);
		$model        = new User();

		//$statuses = $model->getStatusValues();
		//$disciplines = $model->getDisciplineValues();
		return $this->render('students', [
										 'searchModel'  => $searchModel,
										 'dataProvider' => $dataProvider,
										 'statuses'     => FALSE,
										 'disciplines'  => FALSE,
										 ]);
	}

	public function actionRecovery() {
		$form           = new LoginForm();
		$form->scenario = 'requestPasswordResetToken';
		if ($form->load(Yii::$app->request->post()) && $user = $form->recovery()) {
			Yii::$app->mailer->compose('/users/mail/recovery', ['contactForm' => $form])
							 ->setFrom(Yii::$app->params['noreplyEmail'])
							 ->setTo($form->email)
							 ->setSubject('Восстановление пароля')
							 ->send();
			Yii::$app->session->addFlash('recoverySended', 'Вам отправлено письмо. Для завершения восстановления пароля перейдите по ссылке, указанной в письме.');
			// send mail
			// success flash
		} else {
			return $this->render('recovery', [
											 'model' => $form
											 ]);
		}
	}

	public function actionImport() {
		if (Yii::$app->request->isPost) {
			$uploads  = "../import/";
			$filename = time() . ".csv";
			if (move_uploaded_file($_FILES['import_csv']['tmp_name'], $uploads . $filename)) {
				$success   = [];
				$withError = [];
				$users     = Yii::$app->import->processFile($uploads . $filename);
				foreach ($users as $user) {
					$user['university_id'] = Yii::$app->user->identity->university_id;
					$user['structure_id']  = Yii::$app->request->post('structure_id');
					$user['password']      = Yii::$app->security->generateRandomString(5);
					$model                 = new User();
					$model->scenario       = 'import';
					if ($model->load($user, '') && $model->save()) {
						$success[] = $user;
					} else {
						$withError[] = $model;
					}
				}
				$passwordFile = '';
				foreach ($success as $userModel) {
					$passwordFile .= $userModel['phio'] . ";" . $userModel['number'] . ";" . $userModel['password'] . ";\r\n";
					//echo $userModel['phio'];
				}
				$passwordFile = mb_convert_encoding($passwordFile, 'Windows-1251', 'utf8');
				file_put_contents('../import/passwords.csv', $passwordFile);
				Yii::$app->session->addFlash('successImported', "Успешно загружено $success пользователей");

				return $this->redirect(['/users']);
			} else {
				$data = Structure::find()->All();

				return $this->render('import_csv', ['data' => $data, 'error' => TRUE]);
			}
		} else {
			$data = ArrayHelper::map(Structure::find()->AsArray()->All(), 'structure_id', 'name');

			return $this->render('import_csv', ['data' => $data,]);
		}
	}


	public function actionGetpasswords() {
		Yii::$app->response->sendFile('../import/passwords.csv', 'Пароли студентов.csv');
	}
}
