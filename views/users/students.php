<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\User */

$this->title = 'Студенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?=Html::encode($this->title) ?></h1>
    <h4 class="text-left"><?=$user_structure->name;?></h4>

    <!--<p>
        <?/*= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить студента', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'phio',
                'value'     => function ($data) {
                    return Html::a($data->phio, ['view?id=' . $data->id]);
                },
                'format'    => 'raw',
            ],
            'number',
            'start_year',
            [
                'attribute' => 'email',
                'value'     => function ($data) {
                    return $data->email;
                },
                'format'    => 'text',
            ],
            // 'password_reset_token',
            // 'password_hash',
            // 'auth_key',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
