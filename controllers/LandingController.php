<?php

namespace app\controllers;

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
    public function behaviors()
    {
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
                        //                        'actions' => ['*'],
                        'allow' => TRUE,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Landing models.
     * @return mixed
     */
    public function actionIndex()
    {
        die();
        $searchModel = new LandingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Landing model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Landing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Landing();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->request_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionNew()
    {
        return $this->redirect(['/success','type'=>3]);
        $model = new Landing();
        $form_id = Yii::$app->request->post($model->formName())['form_id'];
        $scenario = 'form_' . $form_id;
        if(!array_key_exists($scenario, $model->scenarios())) {
//            $this->refresh();
        }

        if(in_array($form_id,[3,4,5])){
            $model->setScenario('form_3');
        }

        $model->setScenario($scenario);

        if ($r = $model->load(Yii::$app->request->post()) && $s = $model->save()) {
            switch ($model->scenario) {
                case "form_3":
                    return $this->redirect(['/success','type'=>$model->scenario]);
                    break;
                case "form_6":
                    return $this->redirect(['/success','type'=>$model->scenario]);
                    break;
                default:
                    return $this->redirect('//demo.studentsonline.ru');
                    break;
            }
        } else {
            return $this->redirect('http://studentsonline.ru');
        }
    }

    /**
     * Updates an existing Landing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Landing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Landing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Landing::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
