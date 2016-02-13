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
		switch ($type) {
			case 1:
				?>
				<div class="header-title">Ваша заявка принята</div>
				<div class="header-subtitle">
					С вами свяжется менеджер и проведёт консультацию<br>по работе с демоверсией портфолио.
				</div>
				<?
				break;
			case 3:
				?>
				<div class="header-title">Ваш заказ принят</div>
				<div class="header-subtitle">
					С вами свяжется менеджер и расскажет о дальнейших действиях<br>по подключению вуза к
					электронному портфолио «Students Online»
				</div>
				<?
				break;
			case 6:
				?>
				<div class="header-title">Ваша заявка принята</div>
				<div class="header-subtitle">
					С вами свяжется менеджер и подробно ответит на ваши вопросы
				</div>
				<?
				break;
			default:
				//return $this->redirect('//demo.studentsonline.ru');
				break;
		}
		?>
	</div>
	<div class="container">
		<div class="ifthenelse">
			Если по какой-то причине этого не произошло, пожалуйста, свяжитесь с нами самостоятельно,<br>
			позвонив по телефону <strong><?= $agent->phone ?></strong> или написав на
			<strong><?= $agent->email ?></strong>
		</div>

		<?
		switch ($type) {
			case 1:
				?>
				<div>&nbsp;</div>
				<a class="button-green" href="//demo.studentsonline.ru">Открыть демоверсию</a>
				<?
				break;
			case 3:
				?>
				<a class="button-green" href="//studentsonline.ru">Вернуться на сайт</a>
				<?
				break;
			case 6:
				?>
				<a class="button-green" href="//studentsonline.ru">Вернуться на сайт</a>
				<?
				break;
			default:
				//return $this->redirect('//demo.studentsonline.ru');
				break;
		}
		?>
	</div>
</div>
