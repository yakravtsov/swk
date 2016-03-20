<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
$this->title = "Ошибка " . $exception->statusCode . ": " . $message;
?>
<div class="site-error">
    <h1 class=""><?= Html::encode($this->title) ?></h1>

    <p>
        Произошла ошибка во время выполнения вашего запроса.
    </p>
    <p>
        Пожалуйста, напишите на <a href="mailto:pochta@studentsonline.ru">pochta@studentsonline.ru</a>, если вы считаете, что это ошибка программы. Спасибо.
    </p>
    <a class="btn btn-primary" href="/"><i class="glyphicon glyphicon-home"></i> Перейти на главную</a>

</div>
