<?php
namespace app\controllers;

use app\models\Company;
use app\models\Import;
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
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				//                'only' => ['logout', 'about'],
				'rules' => [
					[
						'actions' => ['view', 'for', 'recovery'],
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
				case User::ROLE_GOD:
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
		$current_role       = Yii::$app->user->identity->role_id;
		$current_university = Yii::$app->university->model->university_id;

		/*$current_university = Yii::$app->user->identity->university_id;

		echo Yii::$app->university->model->university_id;*/

		$searchModel = new UserSearch();
		/*$dataProvider = new ActiveDataProvider([
			'query' => User::find()
		]);*/
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query = User::find()
		                                                                                   ->where(['university_id' => $current_university]));


		$authors    = ArrayHelper::map(User::find()->all(), 'id', 'phio');
		$mo         = new User;
		$statuses   = $mo->getStatusValues();
		$roles      = $mo->getRoleValues();
		$structures = ArrayHelper::map(Structure::find()->all(), 'structure_id', 'name');

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
		$current_university = Yii::$app->university->model->university_id;
		$current_role       = Yii::$app->user->identity->role_id;
		$model              = new User();
		$model->scenario    = 'signup';
		$structures         = ArrayHelper::map(Structure::find()->AsArray()->All(), 'structure_id', 'name');
		if ($current_role == User::ROLE_GOD) {
			$structures = ArrayHelper::map(Structure::find()->AsArray()->All(), 'structure_id', 'name');
		} else {
			$structures = ArrayHelper::map(Structure::find()->where(['university_id' => $current_university])->AsArray()
			                                        ->All(), 'structure_id', 'name');
		}
		$universities = ArrayHelper::map(University::find()->AsArray()->All(), 'university_id', 'name');
		if ($model->load(Yii::$app->request->post())) {
			$model->generateLoginHash($model->email);

			if (Yii::$app->user->identity->role_id !== User::ROLE_GOD) {
				$model->university_id = $current_university;
			}
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->user_id]);
			} else {
				return $this->render('create', [
					'model'        => $model,
					'structures'   => $structures,
					'universities' => $universities
				]);
			}
		} else {
			return $this->render('create', [
				'model'        => $model,
				'structures'   => $structures,
				'universities' => $universities
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
		$role_id            = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
		$current_university = Yii::$app->university->model->university_id;
		$current_role       = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
		$current_user       = Yii::$app->user->identity->user_id;
		$model              = $this->findModel($id);
		$model->scenario    = 'update';
		$structures         = ArrayHelper::map(Structure::find()->where(['university_id' => $current_university])
		                                                ->AsArray()->All(), 'structure_id', 'name');
		$universities       = ArrayHelper::map(University::find()->AsArray()->All(), 'university_id', 'name');
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
							'model'        => $model,
							'role_id'      => $role_id,
							'universities' => $universities
						]);
					} else {
						return $this->redirect(['update', 'id' => $current_user]);
					}
					break;
				case User::ROLE_ADMINISTRATOR:
				case User::ROLE_GOD:
					return $this->render('update', [
						'model'        => $model,
						'role_id'      => $role_id,
						'structures'   => $structures,
						'universities' => $universities
					]);
			}
		}
	}

	public function actionSharing($id,$shared) {
		$role_id            = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
		$current_university = Yii::$app->university->model->university_id;
		$current_role       = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
		$current_user       = Yii::$app->user->identity->user_id;
		$model              = $this->findModel($id);
		$model->scenario    = 'sharing';
		if($model->role_id == User::ROLE_STUDENT){
		$model->shared = $shared;
		$model->save();
		}
		return $this->redirect(['view', 'id' => $model->id]);
		/*if ($model->load(Yii::$app->request->post()) && $model->save()) {
			die(var_dump($model->shared));
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->redirect(['view', 'id' => $model->id]);
		}*/
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

	public function actionStudents() {
		$searchModel    = new UserSearch();
		$structure_id   = Yii::$app->user->identity->attributes['structure_id'];
		$custom_query   = User::find()->where(['structure_id' => $structure_id])
		                      ->andWhere(['role_id' => User::ROLE_STUDENT]);
		$dataProvider   = $searchModel->search(Yii::$app->request->queryParams, $custom_query);
		$user_structure = Structure::find()->where(['structure_id' => Yii::$app->user->identity->structure_id])->one();
		$model          = new User();
		//$statuses = $model->getStatusValues();
		//$disciplines = $model->getDisciplineValues();
		return $this->render('students', [
			'searchModel'    => $searchModel,
			'dataProvider'   => $dataProvider,
			'statuses'       => FALSE,
			'disciplines'    => FALSE,
			'user_structure' => $user_structure
		]);
	}

	public function actionEmail() {
		$r = Yii::$app->mailer->compose('/users/mail/email')
		                      ->setFrom(Yii::$app->params['noreplyEmail'])
		                      ->setTo('yakravtsov@gmail.com')
		                      ->setSubject('Восстановление пароля')
		                      ->send();

		die(var_dump($r));
	}

	public function actionRecovery() {
		$form           = new LoginForm();
		$form->scenario = 'requestPasswordResetToken';
		if ($form->load(Yii::$app->request->post()) && $user = $form->recovery()) {
			$r = Yii::$app->mailer->compose('/users/mail/recovery', ['contactForm' => $form])
			                      ->setFrom(Yii::$app->params['noreplyEmail'])
			                      ->setTo($form->email)
			                      ->setSubject('Восстановление пароля')
			                      ->send();
			Yii::$app->session->addFlash('recoverySended', 'Вам отправлено письмо. Для завершения восстановления пароля перейдите по ссылке, указанной в письме.');
			// send mail
			// success flash
			die(var_dump($r));
		} else {
			return $this->render('recovery', [
				'model' => $form
			]);
		}
	}

	public function actionImport() {
		$model = new Import();
		if (Yii::$app->request->isPost) {
			$load        = $model->load(Yii::$app->request->post());
			$model->hash = Yii::$app->security->generateRandomString(6);
			$model->file = UploadedFile::getInstanceByName('file');
			if (!Yii::$app->user->isGod()) {
				$model->university_id = Yii::$app->user->identity->university_id;
			}
			if ($load && $model->upload() && $model->save()) {
				die('ok!');
				//				return $this->redirect(['/users/getpasswords', 'id' => $filename]);
			} else {
				die(var_dump($model->errors) . '<br/>' . var_dump($model->attributes) . '<br/>' . var_dump($r) . '<br/>' . var_dump(Yii::$app->request->post()) . '<br/>' . var_dump($_FILES) . '<br/>' . mb_strtolower($model->file->extension, 'utf-8'));
				$data = Structure::find()->All();

				return $this->render('import_csv', ['data' => $data, 'error' => TRUE]);
			}
		} else {
			$structureData  = ArrayHelper::map(Structure::find()->AsArray()->All(), 'structure_id', 'name');
			$universityData = ArrayHelper::map(University::find()->AsArray()->All(), 'university_id', 'name');

			return $this->render('import_csv', [
				'structureData'  => $structureData,
				'universityData' => $universityData,
				'model'          => $model
			]);
		}
	}


	public function actionGetpasswords($filename) {
		Yii::$app->response->sendFile("../import/passwords_" . $filename, 'Пароли студентов.csv');
	}

	public function actionSwitch($id) {
		$initialId = Yii::$app->user->getId(); //here is the current ID, so you can go back after that.
		if ($id <> $initialId) {
			$user     = User::findOne($id);
			$duration = 0;
			Yii::$app->user->switchIdentity($user, $duration); //Change the current user.
			Yii::$app->session->set('user.idbeforeswitch', $initialId); //Save in the session the id of your admin user.
		}

		return $this->redirect(Yii::$app->user->getHomePageUrl()); //redirect to any page you like.
	}

	public function actionStructures() {
		if ($parents = Yii::$app->request->post('depdrop_parents')) {
			if ($id = $parents[0]) {
				$university                 = University::findOne($id);
				$structures                 = $university->structures;
				Yii::$app->response->format = Response::FORMAT_JSON;
				$out                        = [];
				foreach ($structures as $structure) {
					$out[] = ['id' => $structure->structure_id, 'name' => $structure->name];
				}

				return ['output' => $out];
			}
		}
	}
}
