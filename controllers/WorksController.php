<?php

namespace app\controllers;

use Yii;
use app\models\StudentWorks;
use app\models\search\StudentWorksSearch;
use app\models\User;
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

	private $filename;

	/**
	 * Lists all StudentWorks models.
	 * @return mixed
	 */


	public function actionIndex() {
		$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
		$searchModel = new StudentWorksSearch();

		switch ($role_id) {
			case User::ROLE_TEACHER:
				$structure_id   = yii::$app->user->identity->structure['structure_id'];
				$ownStudents    = User::find()->where(['structure_id' => $structure_id])
				                      ->andWhere(['role_id' => User::ROLE_STUDENT])->asArray()->All();
				$ownStudentsIds = ArrayHelper::map($ownStudents, 'user_id', 'phio');
				$custom_query   = StudentWorks::find()->where(['author_id' => array_keys($ownStudentsIds)]);
				break;

			case User::ROLE_STUDENT:
				$custom_query = StudentWorks::find()->where(['author_id' => Yii::$app->user->id]);

//				return $this->redirect(['studentworks', 'id' => Yii::$app->user->id]);
				break;

			case User::ROLE_GUEST:
				return $this->redirect(['/login']);
				break;

			default:
				$custom_query = FALSE;
		}

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);

		$model    = new StudentWorks();
		$statuses = $model->getStatusValues();


		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
			'statuses'     => $statuses
		]);
	}

	public function actionStudentworks($id,$discipline_id = false) {

		$searchModel = new StudentWorksSearch();

		if($discipline_id){
			$custom_query = StudentWorks::find()->where(['author_id' => $id])->andWhere(['discipline_id'=>$discipline_id]);
		} else {
			$custom_query = StudentWorks::find()->where(['author_id' => $id]);
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

		if(is_array($model->filename)){
			foreach($model->filename as $key => $file){
				array_push($initialPreview,
					Html::a(Html::tag('i','',['class'=>'glyphicon glyphicon-file']) . ' ' . $model->title . '_' . ($key+1),
						Url::to(['/works/getfile', 'file'=>$key+1, 'work_id'=>$model->work_id]),
						//['class'=>'file-preview-image']
						[]
					)
				);
				array_push($initialPreviewConfig,['url' => '/works/deletefile','key'=>$key+1, 'extra'=>['work_id'=>$model->work_id]]);
			}
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



			foreach ($files as $file) {
				$file->saveAs($model->getFilePath($file));
			}

			$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
			if ($role_id == User::ROLE_STUDENT) {
				$model->status = StudentWorks::STATUS_NEW;
			}

			$model->save();

			return $this->redirect(['view', 'id' => $model->work_id]);
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
				$file->saveAs($model->getFilePath($file));
			}

			$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
			if ($role_id == User::ROLE_STUDENT) {
				$model->status = StudentWorks::STATUS_NEW;
			}

			$model->save();

			return $this->redirect(['view', 'id' => $model->work_id]);
		} else {
			$initialPreview = [];
			$initialPreviewConfig = [];

			if(is_array($model->filename)){
				foreach($model->filename as $key => $file){
					array_push($initialPreview,
						Html::img(
							Url::to(['/works/getfile', 'file'=>$key+1, 'work_id'=>$model->work_id]),
							['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']
						)
					);
					array_push($initialPreviewConfig,['url' => '/works/deletefile','key'=>$key+1, 'extra'=>['work_id'=>$model->work_id]]);
				}
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
			die('test');

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

	public function actionGetfile($file, $work_id){
		$model = $this->findModel($work_id);

		/*echo $folder;
		echo "<br>";
		echo $file . "<br><br>";*/

		$filePath = $model->filename[$file-1];
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'."{$model->getAuthorName()}_{$model->title}_$file.". pathinfo($filePath, PATHINFO_EXTENSION) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		readfile($filePath);
		exit;
	}

	public function actionDeletefile() {
		$model = $this->findModel(Yii::$app->request->post('work_id'));
		$model->deleteFile(Yii::$app->request->post('key'));
		$model->save();

		return true;
	}
}