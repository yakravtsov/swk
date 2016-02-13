<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Structure */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подразделения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-index">

    <h1><?=Html::tag('i','',['class'=>'glyphicon glyphicon-tower'])?> Подразделения</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Html::tag('i','',['class'=>'glyphicon glyphicon-plus']) . ' Добавить подразделение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'value' => function($data){
                    return Html::a($data->name,'/structure/view?id=' . $data->structure_id,['class'=>'vasya']);
                },
                'format' => 'html'
            ],

            //'created',
            //'updated',
            //'author_id',
            //'structure_id',
            //'name',
            // 'type',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
