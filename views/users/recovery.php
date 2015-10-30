<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="row">
    <div class="col-xs-12">
        <h1>Восстановление забытого пароля</h1>

        <p>
            Уважаемый пользователь, чтобы восстановить пароль, вам необходимо:
        </p>
        <ol>
            <li>Ввести в форму ниже email, указанный вами в системе «StudentsOnline», и нажать на кнопку «Получить
                ссылку»
            </li>
            <li>Проверьте почту. На указанный email будет отправленная ссылка, при переходе по которой вы сможете задать
                новый пароль
            </li>

        </ol>
    </div>
</div>
<div class="row">
    <?
    $form = ActiveForm::begin([
        'id' => 'login-form',
        //'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
    <div class="col-xs-3">
        <?= $form->field($model, 'email')->label('Введите email') ?>

    </div>

    <div class="col-xs-3">

        <div class="form-group">
            <label class="control-label">&nbsp;</label>
            <div>
            <?= Html::submitButton('<i class="glyphicon glyphicon-link"></i> Отправить ссылку', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>