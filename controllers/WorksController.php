<?php

namespace app\controllers;

use app\components\University;
use app\models\File;
use Yii;
use app\models\StudentWorks;
use app\models\search\StudentWorksSearch;
use app\models\User;
use app\models\Structure;
use app\models\University as UniversityModel;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * StudentsController implements the CRUD actions for StudentWorks model.
 */
class WorksController extends Controller
{
	public function behaviors() {
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['post', 'delete'],
					'deletefile' => ['post', 'delete'],
				],
			],
		];
	}

	/**
	 * Lists all StudentWorks models.
	 * @return mixed
	 */

	public function beforeAction($action) {
		if (!parent::beforeAction($action)) {
			return FALSE;
		}

		$this->view->params['structure'] = Structure::find()->where(['structure_id'=>Yii::$app->user->identity->structure_id])->One();
		return TRUE;
	}


	public function actionIndex() {
		$role_id       = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->role_id;
		if(!Yii::$app->university->model){
			$current_university = 2;
		} else {
			$current_university = Yii::$app->university->model->university_id;
		}
		$searchModel = new StudentWorksSearch();

		switch ($role_id) {
			case User::ROLE_TEACHER:
				$structure_id   = yii::$app->user->identity->structure['structure_id'];
				$ownStudents    = User::find()->where(['structure_id' => $structure_id])->andWhere(['university_id'=>$current_university])
				                      ->andWhere(['role_id' => User::ROLE_STUDENT])->asArray()->All();
				$ownStudentsIds = ArrayHelper::map($ownStudents, 'user_id', 'phio');
				$custom_query   = StudentWorks::find()->where([StudentWorks::tableName().'.author_id' => array_keys($ownStudentsIds)]);
				break;

			case User::ROLE_STUDENT:
				$custom_query = StudentWorks::find()->where([StudentWorks::tableName().'.author_id' => Yii::$app->user->id]);

//				return $this->redirect(['studentworks', 'id' => Yii::$app->user->id]);
				break;

			case User::ROLE_GUEST:
				return $this->redirect(['/login']);
			default:
				$custom_query = StudentWorks::find();
		}

		//$custom_query->andWhere(['university_id'=>$current_university]);

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);

		$model    = new StudentWorks();
		$statuses = $model->getStatusValues();

		$disciplines = $model->getDisciplineValues();


		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
			'statuses'     => $statuses,
			'disciplines' => $disciplines
		]);
	}

	public function actionStudentworks($id,$discipline_id = false) {

		$searchModel = new StudentWorksSearch();

		if($discipline_id){
			//$custom_query = StudentWorks::find()->where(['author_id' => $id])->andWhere(['discipline_id'=>$discipline_id]);
			$custom_query = StudentWorks::find()->where(['discipline_id'=>$discipline_id])->andWhere([StudentWorks::tableName().'.author_id' => $id]);
		} else {
			//$custom_query = StudentWorks::find()->where(['author_id' => $id]);
			$custom_query = StudentWorks::find()->andWhere([StudentWorks::tableName().'.author_id' => $id]);
		}

		$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;

		if($role_id == User::ROLE_STUDENT){
			//$custom_query;
		}

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);

		$model       = new StudentWorks();
		$statuses    = $model->getStatusValues();
		$disciplines = $model->getDisciplineValues();

		$user = User::findOne($id);

		return $this->render('index_student', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
			'statuses'     => $statuses,
			'disciplines'  => $disciplines,
		    'user' => $user,
		    'discipline_id' => $discipline_id
		]);
	}

	/**
	 * Displays a single StudentWorks model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id) {

		$model = $this->findModel($id);
		$initialPreview = [];
		$initialPreviewConfig = [];

		foreach($model->files as $file){
			array_push($initialPreview,
				Html::a(Html::tag('i','',['class'=>'glyphicon glyphicon-file']) . ' ' . $file->real_name,
					Url::to(['/works/getfile', 'file'=>$file->file_id])
				)
			);
			array_push($initialPreviewConfig,['url' => '/works/deletefile','key'=>$file->file_id]);
		}

		return $this->render('view', [
			'model' => $model,
			'initialPreview' => $initialPreview,
			'initialPreviewConfig' => $initialPreviewConfig
		]);
	}

	/**
	 * Creates a new StudentWorks model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new StudentWorks();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$files = UploadedFile::getInstances($model, 'filename');
			if($model->save()) {
			foreach ($files as $file) {
				$model->addFile($file);
			}
				return $this->redirect(['studentworks', 'discipline_id' => $model->discipline_id, 'id' => Yii::$app->user->id]);
			} else {
				return $this->refresh();
			}
		} else {
			$initialPreview = [];
			$initialPreviewConfig = [];

			return $this->render('create', [
				'model' => $model,
				'initialPreview' => $initialPreview,
				'initialPreviewConfig' => $initialPreviewConfig
			]);
		}
	}

	public function actionPdf($id){
		$model = $this->findModel($id);
		$structure = Structure::find()->where(['structure_id'=>$model->author->structure_id])->One();
		$university = UniversityModel::find()->where(['university_id'=>$model->author->university_id])->One();
		return $this->render('pdf', [
				'model' => $model,
			'structure' => $structure,
			'university' => $university
		]);
	}

	/**
	 * Updates an existing StudentWorks model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$files = UploadedFile::getInstances($model, 'filename');
			foreach ($files as $file) {
				$model->addFile($file);
			}

			$model->save();

			return $this->redirect(['view', 'id' => $model->work_id]);
		} else {
			$initialPreview = [];
			$initialPreviewConfig = [];

			foreach($model->files as $file){
				array_push($initialPreview,
					Html::img(
						Url::to(['/works/getfile', 'file'=>$file->file_id]),
						['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']
					)
				);
				array_push($initialPreviewConfig,['url' => '/works/deletefile','key'=>$file->file_id]);
			}

			return $this->render('update', [
				'model' => $model,
			    'initialPreview' => $initialPreview,
			    'initialPreviewConfig' => $initialPreviewConfig
			]);
		}
	}

	public function actionSetstatus($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post())) {
			$model->save();

			return $this->redirect(['view', 'id' => $model->work_id]);
		} else {
			return $this->redirect(['view', 'id' => $model->work_id]);
		}
	}

	/**
	 * Deletes an existing StudentWorks model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the StudentWorks model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return StudentWorks the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = StudentWorks::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionGetfile($file){
		$file = File::findOne($file);
		$model = $file->work;
		$ext = pathinfo($file->path, PATHINFO_EXTENSION);
		$name = "{$model->getAuthorName()}_{$file->real_name}.{$ext}";
		Yii::$app->response->sendFile($file->path, $name);
	}

	public function actionDeletefile() {
		$file = File::findOne(Yii::$app->request->post('key'));
		$model = $file->work;
		$file->delete();
		return true;
	}
}