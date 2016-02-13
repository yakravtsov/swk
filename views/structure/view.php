<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Structure */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?

            echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model->structure_id], ['class' => 'btn btn-primary'])
                . " " .
                Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model->structure_id], ['class' => 'btn btn-danger',
                    'data'  => ['confirm' => 'Вы уверены, что хотите удалить это подразделение?',
                        'method'  => 'post',]]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'created',
            //'updated',
            //'author_id',
            //'structure_id',
            //'name',
            //'type',
        ],
    ]) ?>

    <h3>Студенты подразделения «<?= Html::encode($this->title) ?>»</h3>

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
            [
                'attribute' => 'role_id',
                'value'     => function ($data) {
                    return $data->getRoleLabel();
                },
                'filter' => $roles

            ],
            /*[
                'attribute' => 'structure',
                'value'     => function ($data) {
                    return $data->structure['name'];
                },
                //'filter' => $roles

            ],*/

            [
                'attribute' => 'structure',
                'value' => 'structure.name'
            ],
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
            [
                'attribute' => 'status',
                'value'     => function ($data) {
                    return $data->getStatusLabel();
                    //return $data = 1 ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . " " . $data->getStatusLabel() : Html::tag('i', '', ['class' => 'glyphicon glyphicon-remove']) . " " . $data->getStatusLabel();
                },
                //'contentOptions' => ['style'=>'text-align: center'],
                'format'    => 'html',
                'filter' => $statuses
            ],
            'number',
            // 'password_reset_token',
            // 'password_hash',
            // 'auth_key',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
