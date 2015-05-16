<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\User */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-user']) . " " . Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            [
                'attribute' => 'email',
                'value'     => function ($data) {
                    return $data->email;
                },
                'format'    => 'text',
            ],
            /*[
                'attribute' => 'company_id',
                'value'     => function ($data) {
                        return $data->company->name;
                    },
                'format'    => 'text',
                'filter'    => $searchModel->getCompanies()
            ],*/
            /*[
                'attribute' => 'structure',
                'value'     => function ($data) {
                    return $data->structure['name'];
                },
                //'filter' => $roles

            ],*/

            /*[
                'attribute' => 'structure',
                'value' => 'structure.name'
            ],*/
            //'created',
            //'updated',
            /*[
               'attribute' => 'author_id',
                'value'=>function($data) {
                        return $data->getAuthor()['phio'];
                    },
                'filter' => $authors
            ],*/
            //'parent_id',
            // 'last_login',
            'number',
            // 'password_reset_token',
            // 'password_hash',
            // 'auth_key',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
