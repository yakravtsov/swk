<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

use Zelenin\yii\widgets\Summernote\Summernote;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'about')->textarea()->widget(Summernote::className(), [
        'clientOptions' => [
            //...
        ]
    ]) ?>

    <?/*= $form->field($model, 'structure_id')->dropDownList($model->getStatusValues()) */?>

    <?/*= $form->field($model, 'status')->dropDownList($model->getStatusValues()) */?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Добавить пользователя' : Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
