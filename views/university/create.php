<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\University */

$this->title = 'Добавить университет';
$this->params['breadcrumbs'][] = ['label' => 'Университеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
