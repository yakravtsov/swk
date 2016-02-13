<?php

use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Structure */

$this->title = 'Редактирование: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->structure_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="structure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'universities' => $universities
    ]) ?>

</div>
