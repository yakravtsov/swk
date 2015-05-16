<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Structure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="structure-form">

    <?php $form = ActiveForm::begin(); ?>

    <?/*= $form->field($model, 'created')->textInput() */?>

    <?/*= $form->field($model, 'updated')->textInput() */?>

    <?/*= $form->field($model, 'author_id')->textInput() */?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?/*= $form->field($model, 'type')->textInput() */?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-ok"></i> Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
