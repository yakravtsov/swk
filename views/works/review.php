<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\User;
use app\models\StudentWorks;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWorks */

$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
$roles = [User::ROLE_TEACHER,User::ROLE_ADMINISTRATOR,User::ROLE_GOD];
$podhodit = in_array($role_id,$roles);
$teacherIsEmpty = empty($teacher);

?>
<div class="student-works-review">
                <? $form = ActiveForm::begin(['action' => ['setstatus?id=' . $model->work_id]]); ?>
                <?= $form->field($model, 'mark')->textInput() ?>
                <?= $form->field($model, 'review')->textarea(['rows' => '10']) ?>
                <?= $form->field($model, 'teacher_id')->hiddenInput(['value' => $podhodit ? Yii::$app->user->identity->user_id : false])->label(false); ?>
                <?= $form->field($model, 'status')->dropDownList($model->getStatusValues(), []) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-ok"></i> Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                <? ActiveForm::end(); ?>

</div>
