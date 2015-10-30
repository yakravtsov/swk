<?php

use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Редактирование:' . ' ' . $model->phio;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['/users']];
$this->params['breadcrumbs'][] = ['label' => $model->phio, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?
    if($role_id == User::ROLE_STUDENT) {
        echo $this->render('_form_student', [
            'model' => $model,
        ]);
    } else {
        echo $this->render('_form', [
            'model' => $model,
            'structures' => $structures
        ]);
    }
?>

</div>
