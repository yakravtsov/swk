<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentWorks */

$this->title = 'Создание новой записи';
$this->params['breadcrumbs'][] = ['label' => 'Записи студента', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-works-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'initialPreview' => $initialPreview,
        'initialPreviewConfig' => $initialPreviewConfig
    ]) ?>

</div>
