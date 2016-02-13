<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
//$this->params['breadcrumbs'][] = $this->title;
$university_exist = !is_null(Yii::$app->university->name);
if($university_exist){
    $subdomain = Yii::$app->university->model->subdomain;
    $name = Yii::$app->university->model->name;
} else {
    $subdomain = "";
    $name = "";
}

//$this->title = $name;
?>

<div class="site-login">
    <div class="row">

        <? if (Yii::$app->user->isGuest) {
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'action' => '/login'
                ]); ?>

                <div class="col-xs-4 col-xs-offset-1">
                    <?= $form->field($model, 'email')->textInput([/*'placeholder' => 'Номер зачётки, документа или email'*/])->label('Логин') ?>
                </div>

                <div class="col-xs-4">
                    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                </div>

                <div class="col-xs-2">

                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                        <h6><a href="/users/recovery"><i class="glyphicon glyphicon-lock"></i> Я забыл пароль</a></h6>
                    </div>

                </div>

                <?php ActiveForm::end();



        }
        ?>
    </div>


</div>
