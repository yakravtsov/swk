<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 20.10.2015
 * Time: 23:23
 * All rights are reserved
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */
/* @var $model5 app\models\Landing */

?>
<div class="success">
	<div class="header-titles">
		<?
		if ($type == 3) { ?>
			<div class="header-title">Ваш заказ принят</div>
			<div class="header-subtitle">
				С вами свяжется менеджер и расскажет о дальнейших действиях<br>по подключению ВУЗа к
				электронному портфолио «Students Online»
			</div>
		<? } else { ?>
			<div class="header-title">Ваша заявка принята</div>
			<div class="header-subtitle">
				С вами свяжется менеджер и подробно ответит на ваши вопросы
			</div>
		<? } ?>
	</div>
	<div class="container">
		<div class="ifthenelse">
			Если по какой-то причине этого не произошло, пожалуйста, свяжитесь с нами самостоятельно,<br>
			позвонив по телефону <strong>8 911 164-78-64</strong> или написав на
			<strong>pochta@onlineconsulting.pro</strong>
		</div>
	</div>
</div>
