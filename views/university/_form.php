<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\University */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-form">

    <?php $form = ActiveForm::begin(); ?>

    <?/*= $form->field($model, 'created')->textInput() */?>

    <?/*= $form->field($model, 'updated')->textInput() */?>

    <?/*= $form->field($model, 'author_id')->textInput() */?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'subdomain')->textInput(['maxlength' => 10]) ?>
    <?= $form->field($model, 'paid_till')->textInput() ?>

    <?= $form->field($model, 'tarif')->dropDownList($model->getTarifValues()) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusValues()) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <div>&nbsp;</div>
    <!--<h4>Параметры подключения</h4>-->

    <div class="panel panel-info">
        <div class="panel-heading">Параметры подключения</div>
        <div class="panel-body">
            <?= $form->field($model, 'db_host')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'db_port')->textInput() ?>

            <?= $form->field($model, 'db_user')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'db_pass')->textInput(['maxlength' => 30]) ?>

            <?= $form->field($model, 'db_name')->textInput(['maxlength' => 255]) ?>
        </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Добавить университет' : Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
