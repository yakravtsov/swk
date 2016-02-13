<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AgentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = "Заявки с сайта";
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div>&nbsp;</div>
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
            // 'params:ntext',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<!--

    --><?/*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'agent_id',
            //'shortname',
            //'fullname',
            //'phone',
            //'email:email',
            // 'address',
            // 'info:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */?>
</div>
