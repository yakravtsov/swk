<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Structure */

$this->title = 'Добавить подразделение';
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'universities' => $universities
    ]) ?>

</div>
