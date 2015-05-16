<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWorks */

$this->title = 'Редактирование записи: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Записи студентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->author->phio, 'url' => ['studentworks', 'id' => $model->author_id]];
$this->params['breadcrumbs'][] = ['label' => mb_substr($model->title,0,30, "UTF-8") . "…", 'url' => ['view', 'id' => $model->work_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="student-works-update">

    <h1>Редактирование записи</h1>
    <!--<h3><?/*= Html::encode(mb_substr($model->comment,0,50, "UTF-8")) */?>…</h3>-->

    <?= $this->render('_form', [
        'model' => $model,
        'initialPreview' => $initialPreview,
        'initialPreviewConfig' => $initialPreviewConfig
    ]) ?>

</div>
