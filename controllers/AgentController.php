<?php

namespace app\controllers;

use app\components\User;
use Yii;
use app\models\Landing;
use app\models\search\LandingSearch;
use app\models\Agent;
use app\models\User as UserModel;
use app\models\search\AgentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\CustomAccessRule;

/**
 * AgentController implements the CRUD actions for Agent model.
 */
class AgentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['*'],
                        'allow' => TRUE,
                        'roles' => ['*'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    //die(var_dump(Yii::$app->user->identity->role_id));
                    die(var_dump($rule));
                    //$this->redirect('/');
                }
            ],*/
        ];
    }

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return FALSE;
        }
        $role_id = Yii::$app->user->isGuest ? UserModel::ROLE_GUEST : Yii::$app->user->identity->role_id;


        switch($role_id){
            case UserModel::ROLE_GOD:

                break;
            case UserModel::ROLE_AGENT:
                if($action->id !== "requests"){
                    return $this->redirect(['agent/requests','id'=>Yii::$app->user->identity->user_id]);
                } else {
                    break;
                }
            default:
                return $this->redirect(['/']);


        }

        return TRUE; // or false to not run the action
    }

    /**
     * Lists all Agent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agent model.
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
     * Creates a new Agent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->agent_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Agent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->agent_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Agent model.
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
     * Finds the Agent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionRequests($id){
        if(Yii::$app->user->identity->role_id == UserModel::ROLE_GOD || Yii::$app->user->identity->user_id == $id){
            $agent = Agent::find()->where(['user_id'=>$id])->one();

            $custom_query = Landing::find()->where(['agent_id'=>$agent->agent_id]);
            $searchModel  = new LandingSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$custom_query);

            return $this->render('requests', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
                'agent'       => $agent
            ]);
        } else {
            return $this->redirect(['agent/requests','id'=>Yii::$app->user->identity->user_id]);
        }


    }
}
