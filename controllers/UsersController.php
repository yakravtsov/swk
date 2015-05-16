<?php

namespace app\controllers;

use app\models\Company;
use app\models\StudentWorks;
use app\models\search\StudentWorksSearch;
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
class UsersController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout', 'about'],

                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
//                        'actions' => ['*'],
                        'allow' => true,
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

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;


        if($action->id == "index"){
            switch($role_id){
                case User::ROLE_ADMINISTRATOR:
                    return true;
                break;

                case User::ROLE_TEACHER:
                    return $this->redirect(['/users/students','id'=>Yii::$app->user->identity->user_id]);
                        break;
                default:
                    return $this->redirect('/');
            }
        }


        /*if ($role_id !== User::ROLE_ADMINISTRATOR || $role_id !== User::ROLE_TEACHER) {
            return $this->redirect('/');
        } else {
            if($action->id == "index" && $role_id !== User::ROLE_TEACHER){
                return $this->redirect('/users/students');
            }
        }*/

        return true; // or false to not run the action
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();


        /*$dataProvider = new ActiveDataProvider([
            'query' => User::find()
        ]);*/
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $authors = ArrayHelper::map(User::find()->all(), 'id', 'phio');
        $mo = new User;
        $statuses = $mo->getStatusValues();
        $roles = $mo->getRoleValues();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'authors' => $authors,
            'statuses' => $statuses,
            'roles' => $roles
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new StudentWorksSearch();

        $custom_query = StudentWorks::find()->where(['author_id' => $id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);

        $model       = new StudentWorks();
        $statuses    = $model->getStatusValues();
        $disciplines = $model->getDisciplineValues();


        return $this->render('view', [
            'model' => $this->findModel($id),
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

    public function actionCreate()
    {
        $model = new User();
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
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
        $current_user = Yii::$app->user->identity->user_id;

        $model = $this->findModel($id);
        $model->scenario = 'signup';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            switch ($role_id) {
                case User::ROLE_TEACHER:
                    return $this->redirect(['/users']);
                    break;

                case User::ROLE_STUDENT:
                    if($current_user == $id){
                        return $this->render('update', [
                            'model' => $model,
                            'role_id' => $role_id
                        ]);
                    } else {
                        return $this->redirect(['update', 'id' => $current_user]);
                    }
                    break;
                case User::ROLE_ADMINISTRATOR:
                    return $this->render('update', [
                        'model' => $model,
                        'role_id' => $role_id
                    ]);

            }


        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStudents($id)
    {

        $searchModel = new UserSearch();

        $structure_id = Yii::$app->user->identity->attributes['structure_id'];

        $custom_query = User::find()->where(['structure_id' => $structure_id])->andWhere(['role_id'=>User::ROLE_STUDENT]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $custom_query);

        $model = new User();
        //$statuses = $model->getStatusValues();
        //$disciplines = $model->getDisciplineValues();

        return $this->render('students', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statuses' => false,
            'disciplines' => false,
        ]);
    }
}
