<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 20.10.2015
 * Time: 23:23
 * All rights are reserved
 */
use app\components\widgets\LandActiveForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$controller = Yii::$app->controller;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */
/* @var $model5 app\models\Landing */
/* @var $form yii\widgets\ActiveForm */

?>
<nav class="navbar navbar-relative">
	<div class="container">
		<a href="#home" class="navbar-home">&nbsp;</a>
		<a href="#capabilities">Возможности</a>
		<a href="#screenshots">Внешний вид</a>
		<a href="#demoversion">Демоверсия</a>
		<a href="#packages">Тарифы</a>
		<a href="#help">Бесплатная консультация</a>
		<a href="/presentation" class="download_presentation" target="_blank">Скачать презентацию</a>
	</div>
</nav>

<nav class="navbar navbar-fixed">
	<div class="container">
		<a href="#home" class="navbar-home">&nbsp;</a>
		<a href="#capabilities">Возможности</a>
		<a href="#screenshots">Внешний вид</a>
		<a href="#demoversion">Демоверсия</a>
		<a href="#packages">Тарифы</a>
		<a href="#help">Бесплатная консультация</a>
		<a href="/presentation" class="download_presentation" target="_blank">Скачать презентацию</a>
	</div>
</nav>

<div class="header-titles">
	<div class="header-title">Электронное портфолио обучающегося</div>
	<div class="header-subtitle">Готовое решение для ВУЗов согласно ФГОС 3+</div>
</div>

<div class="splash" id="demo">
	<div class="container">
		<div class="ill left">
			<img class="ill-hover" src="/landing/i/splash/ill_hover.png" alt="Смотреть внешний вид портфолио"/>
			<img class="ill-monitor" src="/landing/i/splash/ill.png" alt="Электронное портфолио обучающегося"/>
		</div>
		<div class="form right">
			<div class="form-title">Попробуйте демоверсию</div>
			<div class="form-subtitle">Заполните форму ниже и получите доступ<br>к демоверсии электронного портфолио
			</div>

			<?php $form = LandActiveForm::begin([
				'id'                     => $model->scenario,
				'action'                 => '/landing/new',
				'enableClientValidation' => TRUE,
				'validateOnBlur'         => TRUE,
			]); ?>

			<?= $form->field($model, 'name')
			         ->textInput(['class' => 'input-name', 'placeholder' => 'Введите название вуза,'])
			         ->label(FALSE) ?>

			<?= $form->field($model, 'email')
			         ->textInput(['class' => 'input-email', 'placeholder' => 'а также email'])->label(FALSE) ?>

			<?= $form->field($model, 'phone')
			         ->textInput(['class' => 'input-phone', 'placeholder' => 'и телефон для связи'])
			         ->label(FALSE) ?>

			<?= Html::activeHiddenInput($model, 'form_id', ['value' => 1]); ?>

			<?= Html::activeHiddenInput($model, 'agent_id', ['value' => $agent->agent_id]); ?>

			<?= Html::submitButton('Попробовать', ['class' => 'button-yellow']) ?>

			<?php LandActiveForm::end(); ?>

		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="clarification">
	<div class="container">
		<p>
			В соответствии с письмом Минобрнауки «<a
				href="http://xn--80abucjiibhv9a.xn--p1ai/%D0%B4%D0%BE%D0%BA%D1%83%D0%BC%D0%B5%D0%BD%D1%82%D1%8B/4548/%D1%84%D0%B0%D0%B9%D0%BB/3471/AK-2612-05.pdf"
				target="_blank" data-tooltip="Нажмите, чтобы прочитать письмо на сайте Минобрнауки">О
				федеральных государственных образовательных стандартах</a>» новыми
			федеральными государственными образовательными стандартами высшего образования (ФГОС ВО) общесистемные
			требования к реализации программы бакалавриата, специалитета и магистратуры предусматривают
			<em>«формирование
				электронного портфолио обучающегося, в том числе сохранение работ обучающегося, рецензий и оценок на эти
				работы
				со стороны любых участников образовательного процесса»</em>.
		</p>
	</div>
</div>

<div class="capabilities" id="capabilities">

	<div class="title">Возможности электронного портфолио <strong>Students Online</strong></div>

	<div class="container">
		<div class="several several-3">
			<div class="each">
				<img src="/landing/i/capabilities/1.png" alt=""/>
				<span>Хранение работ<br>и достижений обучающихся</span>
			</div>
			<div class="each">
				<img src="/landing/i/capabilities/2.png" alt=""/>
				<span>Оценка и рецензирование<br>работ преподавателями</span>
			</div>
			<div class="each">
				<img src="/landing/i/capabilities/3.png" alt=""/>
				<span>Удобный поиск с фильтрацией<br>по всем записям</span>
			</div>

			<div class="clear"></div>

			<div class="each">
				<img src="/landing/i/capabilities/4.png" alt=""/>
				<span>Выдача архива работ<br>по окончании обучения</span>
			</div>
			<div class="each">
				<img src="/landing/i/capabilities/5.png" alt=""/>
				<span>Просмотр портфолио через<br>Интернет для работодателей</span>
			</div>
			<div class="each">
				<img src="/landing/i/capabilities/6.png" alt=""/>
				<span>Привязка обучающихся<br>к организационной структуре</span>
			</div>
		</div>
	</div>
</div>

<div class="screenshots" id="screenshots">
	<div class="title">Внешний вид электронного портфолио</div>
	<div class="container">
		<div class="several several-4">
			<a class="each" rel="details" href="/landing/i/screenshots/big/1.jpg"
			   data-fancybox-title="Главная страница. На данной странице указан ВУЗ, расположены форма входа для пользователей, а также ссылки на восстановление пароля и инструкцию по работе с электронным портфолио.">
				<img src="/landing/i/screenshots/1.jpg" alt=""/>
				<span>Главная страница</span>
			</a>
			<a class="each" rel="details" href="/landing/i/screenshots/big/2.jpg"
			   data-fancybox-title="Кабинет студента: список работ.">
				<img src="/landing/i/screenshots/2.jpg" alt=""/>
				<span>Студент:<br>список работ</span>
			</a>
			<a class="each" rel="details" href="/landing/i/screenshots/big/3.jpg" data-fancybox-title="">
				<img src="/landing/i/screenshots/3.jpg" alt=""/>
				<span>Студент:<br>запись о работе</span>
			</a>
			<a class="each" rel="details" href="/landing/i/screenshots/big/4.jpg" data-fancybox-title="">
				<img src="/landing/i/screenshots/4.jpg" alt=""/>
				<span>Студент:<br>создание записи</span>
			</a>

			<a class="each" rel="details" href="/landing/i/screenshots/big/5.jpg" data-fancybox-title="">
				<img src="/landing/i/screenshots/5.jpg" alt=""/>
				<span>Преподаватель:<br>список работ</span>
			</a>
			<a class="each" rel="details" href="/landing/i/screenshots/big/6.jpg" data-fancybox-title="">
				<img src="/landing/i/screenshots/6.jpg" alt=""/>
				<span>Преподаватель:<br>рецензирование работы</span>
			</a>

			<a class="each" rel="details" href="/landing/i/screenshots/big/7.jpg" data-fancybox-title="">
				<img src="/landing/i/screenshots/7.jpg" alt=""/>
				<span>Администратор:<br>список пользователей</span>
			</a>

			<a class="each" rel="details" href="/landing/i/screenshots/big/8.jpg" data-fancybox-title="">
				<img src="/landing/i/screenshots/8.jpg" alt=""/>
				<span>Администратор:<br>список кафедр</span>
			</a>

		</div>
	</div>
</div>

<div class="demoversion" id="demoversion">
	<div class="title">Попробуйте демоверсию <strong>Students Online</strong></div>
	<div class="subtitle">Заполните форму ниже и получите доступ к демоверсии электронного портфолио</div>

	<div class="container">

		<div class="form">

			<?php $form = LandActiveForm::begin([
				'id'                     => $model2->scenario,
				'action'                 => '/landing/new',
				'enableClientValidation' => TRUE,
				'validateOnBlur'         => TRUE,
				'fieldConfig'            => [
					'errorOptions' => ['encode' => FALSE],
				],
			]); ?>

			<?= $form->field($model2, 'name')
			         ->textInput(['class' => 'input-name', 'placeholder' => 'Введите название вуза,'])
			         ->label(FALSE) ?>

			<?= $form->field($model2, 'email')
			         ->textInput(['class' => 'input-email', 'placeholder' => 'а также email'])->label(FALSE) ?>

			<?= $form->field($model2, 'phone')
			         ->textInput(['class' => 'input-phone', 'placeholder' => 'и телефон для связи'])
			         ->label(FALSE) ?>

			<?= Html::activeHiddenInput($model2, 'form_id', ['value' => 2]); ?>

			<?= Html::activeHiddenInput($model2, 'agent_id', ['value' => $agent->agent_id]); ?>

			<?= Html::submitButton('Попробовать', ['class' => 'button-yellow']) ?>

			<?php LandActiveForm::end(); ?>

		</div>

	</div>
</div>

<div class="advantages" id="advantages">

	<div class="title">Преимущества электронного портфолио</div>

	<div class="container">
		<div class="text">
			<ul>
				<li>Срок подключения — до 7 рабочих дней</li>
				<li>Портфолио просто организовано и не требует дополнительного обучения студентов</li>
				<li>Доступно 24 часа в сутки с любого компьютера, подключенного к сети Интернет</li>
				<li>Обладает системой технической поддержки и сопровождения пользователей</li>
				<li>Постоянно развивается в соответствии с пожеланиями клиентов и требованиями законодательства</li>
				<li>Хранение данных в российском дата-центре</li>
			</ul>
		</div>
	</div>
</div>

<div class="packages" id="packages">
	<div class="title">Тарифы, виды и стоимость услуг</div>
	<div class="container">
		<table>
			<thead>
			<tr>
				<th></th>
				<th>Минимальный</th>
				<th>Стандарт</th>
				<th>Расширенный</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					<strong>Подключение</strong>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Брендирование портфолио</strong>
					<br>
					<em>Размещение логотипа, названия, контактной информации</em>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Создание организационной структуры</strong>
					<br>
					<em>Загрузка институтов, факультетов<br>и кафедр</em>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Загрузка пользователей</strong>
					<br>
					<em>Массовое добавление обучающихся, преподавателей и администраторов</em>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Обучение персонала</strong>
					<br>
					<em>Выезд консультанта для обучения пользованию портфолио</em>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Техническая поддержка</strong>
					<br>
					<em>Круглосуточная поддержка пользователей по вопросам работы портфолио</em>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Резервное копирование данных</strong>
					<br>
					<em>Ежедневное дублирование размещённой информации на запасном сервере</em>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Обновления портфолио</strong>
					<br>
					<em>Доступ ко всем новым функциям<br>и усовершенствованиям</em>
				</td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
				<td><img src="/landing/i/packages/check.png" alt="Да" /></td>
			</tr>
			<tr>
				<td>
					<strong>Период</strong>
					<br>
					<em>Минимальный срок аренды</em>
				</td>
				<td>1 год</td>
				<td>1 год</td>
				<td>1 год</td>
			</tr>
			<tr class="tr-space">
				<td>
					<strong>Объём памяти</strong>
					<br>
					<em>Количество терабайт, зарезервированных для хранения работ обучающихся</em>
				</td>
				<td>1 Тб</td>
				<td>2 Тб</td>
				<td>3 Тб</td>
			</tr>
			<tr class="tr-qty">
				<td>
					<strong>Количество обучающихся</strong>
					<br>
					<em>Максимальное количество, доступное<br>для загрузки в портфолио</em>
				</td>
				<td>до 2 000</td>
				<td>до 10 000</td>
				<td>от 10 000</td>
			</tr>
			<tr>
				<td>
					<strong>Продление аренды</strong>
					<br>
					<em>Стоимость каджого последующего года использования</em>
				</td>
				<td>30 000 рублей</td>
				<td>50 000 рублей</td>
				<td>Согласно договору</td>
			</tr>
			<tr class="price">
				<td>Стоимость</td>
				<td>30 000 рублей</td>
				<td>50 000 рублей</td>
				<td>Индивидуальная</td>
			</tr>
			</tbody>
			<tfoot>
			<tr class="tr-order">
				<td></td>
				<td><a class="button-yellow" href="#order" data-form_id="3">Заказать</a></td>
				<td><a class="button-yellow" href="#order" data-form_id="4">Заказать</a></td>
				<td><a class="button-yellow" href="#order" data-form_id="5">Заказать</a></td>
			</tr>
			</tfoot>
		</table>
		<!--<img src="/landing/i/shadows/3.png" alt=""/>-->
	</div>
</div>

<div class="why">
	<div class="title">Почему лучше воспользоваться готовым решением <strong>Students Online</strong>?</div>
	<div class="container">
		<div class="cto">
			<img class="cto-photo" src="/landing/i/why/cto.jpg" alt="Даниил Кравцов, технический директор «Онлайн Консалтинг»"/>
			<span class="cto-name">Даниил Кравцов</span>
			<span class="cto-position">Технический директор «Онлайн Консалтинг»</span>
		</div>
		<div class="why-text">
			<p>
				<strong>Первая и самая главная причина:</strong> портфолио успешно прошло проверку на соответствие
				требованиям ФГОС 3+ во время аккредитации учебных заведений, использующих «Students Online».
				</p>
			<p>
				<strong>Вторая причина:</strong> портфолио разработано в тесном сотрудничестве с преподавателями ВУЗов, что позволило сделать
				«Students Online» максимально удобным и понятным в использовании.
			</p>
				<p>
					<strong>Следующая причина:</strong> на основе опроса
				наших клиентов выяснилось, что решение задачи информационным отделом вуза затягивается до бесконечности,
				ввиду отсутствия опыта разработки сложных программных решений. К отсутствию компетенции добавляются
				временные и финансовые расходы на покупку, настройку и обслуживание оборудования, а также обеспечение
				бесперебойного доступа к портфолио.
					</p>
			<p>
					<strong>И последнее:</strong> на данный момент портфолио «Students Online» не имеет
				аналогов на рынке информационных систем подобного рода.
			</p>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="help" id="help">
	<div class="title">У вас остались вопросы? Закажите бесплатную консультацию!</div>
	<div class="subtitle">Оставьте номер телефона, в течение 3 минут вам перезвонит менеджер.</div>

	<div class="container">
		<div class="form">
			<?php $form = LandActiveForm::begin([
				'id'                     => $model6->scenario,
				'action'                 => '/landing/new',
				'enableClientValidation' => TRUE,
				'validateOnBlur'         => TRUE,
				'fieldConfig'            => [
					'errorOptions' => ['encode' => FALSE],
				],
			]); ?>

			<?= $form->field($model6, 'phone')
			         ->textInput(['class' => 'input-phone', 'placeholder' => 'Введите номер телефона'])
			         ->label(FALSE) ?>

			<?= Html::activeHiddenInput($model6, 'form_id', ['value' => 6]); ?>

			<?= Html::activeHiddenInput($model6, 'agent_id', ['value' => $agent->agent_id]); ?>

			<div class="form-group">
				<?= Html::submitButton('Заказать консультацию', ['class' => 'button-green']) ?>
			</div>
			<div class="clear"></div>
			<?php LandActiveForm::end(); ?>
		</div>
	</div>
</div>

<div class="order" id="order">
	<div class="form">
		<div class="form-title">Вы выбрали тариф «<span class="order-name"></span>»: <span class="order-qty"></span>
			студентов, <span class="order-space"></span> терабайт памяти
		</div>
		<div class="form-subtitle">
			Заполните форму ниже, вам перезвонит менеджер и расскажет о дальнейших действиях<br>по подключению вуза к
			электронному портфолио «Students Online».
		</div>

		<?php $form = LandActiveForm::begin([
			'id'                     => $model3->scenario,
			'action'                 => '/landing/new',
			'enableClientValidation' => TRUE,
			'validateOnBlur'         => TRUE,
			'fieldConfig'            => [
				'errorOptions' => ['encode' => FALSE],
			],
		]); ?>

		<?= $form->field($model3, 'name')
		         ->textInput(['class' => 'input-name', 'placeholder' => 'Введите название вуза,'])
		         ->label(FALSE) ?>

		<?= $form->field($model3, 'email')
		         ->textInput(['class' => 'input-email', 'placeholder' => 'а также email'])->label(FALSE) ?>

		<?= $form->field($model3, 'phone')
		         ->textInput(['class' => 'input-phone', 'placeholder' => 'и телефон для связи'])
		         ->label(FALSE) ?>

		<?= Html::activeHiddenInput($model3, 'form_id', ['value' => 3, 'class' => 'order-form_id']); ?>

		<?= Html::activeHiddenInput($model3, 'agent_id', ['value' => $agent->agent_id]); ?>

		<?= Html::submitButton('Оформить заказ', ['class' => 'button-yellow']) ?>

		<?php LandActiveForm::end(); ?>
	</div>
</div>













