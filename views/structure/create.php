<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Structure */

$this->title = 'Добавить институт';
$this->params['breadcrumbs'][] = ['label' => 'Институты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
