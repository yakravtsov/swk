<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use kartik\select2\Select2;

$current_role = Yii::$app->user->identity->role_id;

/* @var $this yii\web\View */
/* @var $model app\models\Structure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="structure-form">

    <?php $form = ActiveForm::begin(); ?>

    <?/*= $form->field($model, 'created')->textInput() */?>

    <?/*= $form->field($model, 'updated')->textInput() */?>

    <?/*= $form->field($model, 'author_id')->textInput() */?>

    <?
    if($current_role == User::ROLE_GOD) {
        echo $form->field($model, 'university_id')->textInput()->widget(Select2::className(),[
            'name' => 'university_id',
            'data' => $universities,
        ])->label('Университет');
    }
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?/*= $form->field($model, 'type')->textInput() */?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-ok"></i> Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
