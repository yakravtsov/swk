<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Structure */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->structure_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->structure_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'created',
            'updated',
            'author_id',
            'structure_id',
            'name',
            'type',
        ],
    ]) ?>

</div>
