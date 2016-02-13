<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use kartik\date\DatePicker;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Университеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-index">


    <h1><i class="glyphicon glyphicon-education"></i> <?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'created',
            //'updated',
            //'author_id',
            //'university_id',
            //'name',
            [
                'attribute' => 'name',
                'value' => function ($data) {
                    return Html::a($data->name, ['view', 'id' => $data->university_id]);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'subdomain',
                'value' => function ($data) {
                    return Html::a($data->subdomain, '//' . $data->subdomain . ".studentsonline.ru",['target'=>'_blank']);
                },
                'format' => 'html'
            ],
            // 'db_host',
            // 'db_port',
            // 'db_user',
            // 'db_pass',
            // 'db_name',
            //'tarif',
            [
                'attribute' => 'tarif',
                'value' => function ($data) {
                    return Html::tag('span', $data->tarifLabel, ['class' => 'label label-' . $data->tarifLabelClass]);
                },
                'format' => 'html',
                'filter' => $tarifs
            ],
            [
                'attribute' => 'paid_till',
                //'value' => 'paid_till',
                'options' => [
                    'style' => 'width: 140px;'
                ],
                'filter' => DatePicker::widget([
                    'name' => 'UniversitySearch[paid_till]',
                    'attribute' => 'paid_till',
                    'value' => $searchModel->paid_till,
                    'template' => '{input}{addon}',
                    'language' => 'ru',
                    'clientOptions' => [
                        'autoclose' => true,
                        'clearBtn' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]),
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return Html::tag('span', $data->statusLabel);
                },
                'format' => 'html',
                'filter' => $statuses
            ],
            // 'type',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
