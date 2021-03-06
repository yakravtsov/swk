<?php
namespace app\controllers;

use app\components\CustomAccessRule;
use Yii;
use app\models\Structure;
use app\models\University;
use app\models\search\Structure as StructureSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;
use app\models\User as UserModel;
use app\models\search\UserSearch;
use yii\helpers\ArrayHelper;

/**
 * StructureController implements the CRUD actions for Structure model.
 */
class StructureController extends Controller {

	public function behaviors() {
		return [
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
			'access' => [
				'class'        => AccessControl::className(),
				'ruleConfig'   => [
					'class' => CustomAccessRule::className()
				],
				'rules'        => [
					[
						'allow' => TRUE,
						'roles' => ['structure', ['ownStructure', ['structureId'=>Yii::$app->request->getQueryParam('id')]]],
					],
				],
				'denyCallback' => function ($rule, $action) {
					$this->redirect('/');
				}
			],
		];
	}

	/**
	 * Lists all Structure models.
	 * @return mixed
	 */
	public function actionIndex() {
		$query = Structure::find();
		$query->where(['university_id' => Yii::$app->user->can('structure')
			? Yii::$app->university->model->university_id
			: Yii::$app->user->identity->university_id
		              ]);
		$searchModel  = new StructureSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Structure model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id) {
		$searchModel = new UserSearch();
		/*$dataProvider = new ActiveDataProvider([
			'query' => User::find()
		]);*/
		$custom_query = UserModel::find()->where(['structure_id' => $id]);
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);
		$authors      = ArrayHelper::map(UserModel::find()->all(), 'id', 'phio');
		$mo           = new UserModel;
		$statuses     = $mo->getStatusValues();
		$roles        = $mo->getRoleValues();

		return $this->render('view', [
			'model'        => $this->findModel($id),
			'dataProvider' => $dataProvider,
			'searchModel'  => $searchModel,
			'authors'      => $authors,
			'statuses'     => $statuses,
			'roles'        => $roles
		]);
	}

	/**
	 * Creates a new Structure model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Structure();
		if ($model->load(Yii::$app->request->post())) {
			if (Yii::$app->user->can('structure') && empty($model->university_id)) {
				$model->university_id = Yii::$app->university->model->university_id;
			} else {
				$model->university_id = Yii::$app->user->identity->university_id;
			}
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->structure_id]);
			}
		}

		return $this->render('create', [
			'model'        => $model,
			'universities' => ArrayHelper::map(University::find()->AsArray()->All(), 'university_id', 'name')
		]);
	}

	/**
	 * Updates an existing Structure model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model        = $this->findModel($id);
		$universities = ArrayHelper::map(University::find()->AsArray()->All(), 'university_id', 'name');
		if ($model->load(Yii::$app->request->post())) {
			if (!Yii::$app->user->can('structure')) {
				$model->university_id = Yii::$app->university->model->university_id;
			}
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->structure_id]);
			}
		}

		return $this->render('update', [
			'model'        => $model,
			'universities' => $universities
		]);
	}

	/**
	 * Deletes an existing Structure model.
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
	 * Finds the Structure model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Structure the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Structure::findOne($id)) !== NULL) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
