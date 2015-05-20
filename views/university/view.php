<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\University */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Университеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model->university_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model->university_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить университет?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div>&nbsp;</div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'created',
            //'updated',
            //'author_id',
            //'university_id',
            //'name',
            //'subdomain',
            [
                'attribute' => 'subdomain',
                'value' => Html::a($model->subdomain,'//' . $model->subdomain . "." . $_SERVER['HTTP_HOST'],['target'=>'_blank']),
                'format' => 'raw'
            ],
            'paid_till',
            [
                'attribute' => 'tarif',
                'value' => Html::tag('span',$model->tarifLabel,['class' => 'label label-' . $model->tarifLabelClass]),
                'format' => 'html',
            ],
            [
                'attribute' => 'status',
                'value' => $model->statusLabel,
                'format' => 'html',
            ],
            'type',
        ],
    ]) ?>

    <h4>Параметры подключения</h4>
        <?= DetailView::widget([
            'model' => $model,
            'template' => "<tr><td style='width:50px;'><strong>{label}</strong></td><td>{value}</td></tr>",
            'attributes' => [
                'db_host',
                'db_port',
                'db_user',
                'db_pass',
                'db_name',
            ]
        ]); ?>
</div>
