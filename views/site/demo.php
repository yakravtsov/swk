<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
//$this->title = 'About';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div>&nbsp;</div>
<div class="demo-buttons text-center">
    <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-log-in']) . ' Войти как студент', ['/login_as',
        'user' => 'student'], [
        'class' => 'btn btn-success',
        'data' => [
            'method' => 'post',
        ],
    ]);
    ?>
    &nbsp;
    <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-log-in']) . ' Войти как преподаватель', ['/login_as',
        'user' => 'professor'], [
        'class' => 'btn btn-success',
        'data' => [
            'method' => 'post',
        ],
    ]);
    ?>
    &nbsp;
    <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-log-in']) . ' Войти как администратор', ['/login_as',
        'user' => 'administrator'], [
        'class' => 'btn btn-success',
        'data' => [
            'method' => 'post',
        ],
    ]);
    ?>
</div>

<!--<div class="row">
    <div class="col-xs-2">
        <h6>
        Студент<br>
        student<br>
        demo
        </h6>
    </div>
    <div class="col-xs-2">
        Преподаватель<br>
        professor<br>
        demo
    </div>
    <div class="col-xs-2">
            Администратор<br>
            administrator<br>
            demo
    </div>
</div>-->
<!--<div class="row">
    <div class="col-xs-6 ">
        <table class="table table-condensed">
            <thead>
            <tr class="info">
                <th><h6>Данные для входа в портфолио</h6></th>
                <th><h6>Логин</h6></th>
                <th><h6>Пароль</h6></th>
            </tr>
            </thead>
            <tr>
                <td><h6>Администратор</h6></td>
                <td><h6>administrator</h6></td>
                <td><h6>demo</h6></td>
            </tr>
            <tr>
                <td><h6>Преподаватель</h6></td>
                <td><h6>professor</h6></td>
                <td><h6>demo</h6></td>
            </tr>
            <tr>
                <td><h6>Студент</h6></td>
                <td><h6>student</h6></td>
                <td><h6>demo</h6></td>
            </tr>
        </table>
    </div>
</div>-->