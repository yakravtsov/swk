<?php

namespace app\controllers;

use app\models\Agent;
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
        //die();

        $agents = Agent::find()->asArray()->all();


        $searchModel = new LandingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'agents' => $agents
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
        $model = new Landing();
        $form_id = Yii::$app->request->post($model->formName())['form_id'];
        $scenario = 'form_' . $form_id;
        if(!array_key_exists($scenario, $model->scenarios())) {
//            $this->refresh();
        }

        $model->setScenario($scenario);

        if(in_array($form_id,[3,4,5])){
            $model->setScenario('form_3');
        }

        if(in_array($form_id,[1,2])){
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

            $agent = $agent = Agent::find()->where(['agent_id' => $model->agent_id])->One();
            //die(var_dump(Yii::$app->request->baseUrl));
            return $this->redirect(['/success','type'=>preg_replace('/[^0-9.]+/', '', $model->scenario),'a'=>$agent->shortname]);
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
