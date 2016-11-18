<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LandingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="landing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?/*= Html::a('Create Landing', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'request_id',
            'name',
            'email:email',
            'phone',
            //'form_id',
            [
                'attribute' => 'form_id',
                'label' => 'Форма',
                'value' => function($data){
                    return $data->getFormLabel($data->form_id);
                }
            ],
            /*[
                'attribute' => 'agent',
                'label' => 'Агент',
                'value'     => function ($data) {
                    return $data['agent']['fullname'];
                },
                'format'    => 'raw',
                //'visible'=> !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id!==\app\models\User::ROLE_STUDENT
            ],*/
            // 'params:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
