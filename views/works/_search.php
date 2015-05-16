<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\StudentWorksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-works-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?/*= $form->field($model, 'created') */?><!--

    --><?/*= $form->field($model, 'updated') */?>

    <?/*= $form->field($model, 'author_id') */?>

    <?/*= $form->field($model, 'work_id') */?>

    <?/*= $form->field($model, 'filename') */?>

    <?= $form->field($model, 'title') ?>

    <?php /* echo $form->field($model, 'type')->dropDownList($model->getDisciplineValues(), ['ng-model' => 'test.order']); */?>

    <?php // echo $form->field($model, 'mark') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'discipline_id') ?>

    <?php // echo $form->field($model, 'student_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton( Html::tag('i','',['class'=>'glyphicon glyphicon-search']) . ' Найти', ['class' => 'btn btn-primary']) ?>
        <?/*= Html::resetButton('Сбросить фильтр', ['class' => 'btn btn-default']) */?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
