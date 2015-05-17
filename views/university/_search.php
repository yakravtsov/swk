<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\UniversitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'updated') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'university_id') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'db_host') ?>

    <?php // echo $form->field($model, 'db_port') ?>

    <?php // echo $form->field($model, 'db_user') ?>

    <?php // echo $form->field($model, 'db_pass') ?>

    <?php // echo $form->field($model, 'db_name') ?>

    <?php // echo $form->field($model, 'paid_till') ?>

    <?php // echo $form->field($model, 'tarif') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'subdomain') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
