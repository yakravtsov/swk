<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
//$this->params['breadcrumbs'][] = $this->title;
if (Yii::$app->university->model) {
	$subdomain = Yii::$app->university->model->subdomain;
	$name      = Yii::$app->university->model->name;
} else {
	$subdomain = "";
	$name      = "";
}

//$this->title = $name;
?>

<div class="site-index">

	<div class="university-logo text-center">
		<img src="/i/university_logos/<?= $subdomain ?>.jpg" alt="<?= $name ?>"/>
	</div>

	<h3 class="text-center"><?= $name ?></h3>
	<h1 class="text-center" style="margin-top:10px; font-size: 4em;">Электронное портфолио студента</h1>

	<div class="row">

		<? if (Yii::$app->user->isGuest) {
			//echo "<div>&nbsp;</div>";
			if ($subdomain == "demo") {
				echo Yii::$app->controller->renderPartial('demo');
			} else {
				$form = ActiveForm::begin([
					'id'     => 'login-form',
					'action' => '/login'
				]); ?>

				<div class="col-xs-4 col-xs-offset-1">
					<?= $form->field($model, 'email')
					         ->textInput(['placeholder' => 'Номер зачётки, документа или email'])->label('Логин') ?>
				</div>

				<div class="col-xs-4">
					<?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
				</div>

				<div class="col-xs-2">

					<div class="form-group">
						<label class="control-label">&nbsp;</label>
						<?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>

					</div>

				</div>
				<div>&nbsp;</div>
				<?php ActiveForm::end();
			}


		} else {
			?>

		<?
		}
		?>
		<div class="col-xs-4 col-xs-offset-5">
			<div class="text-left login-form-links">
					<? if ($subdomain !== "demo" && Yii::$app->user->isGuest) { ?>
						<small><a href="/users/recovery"><i class="glyphicon glyphicon-lock"></i> Я забыл пароль</a></small>
					<? } ?>
			</div>
		</div>
	</div>
	<div class="row">

		<div class="col-xs-10 col-xs-offset-1">

			<h4>Уважаемый студент!</h4>

			<p>
				Портфолио — это документ, который красочно представляет ваши успехи, достижения и

				результаты, достигнутые в учебной, научной, исследовательской, творческой, общественной

				деятельности за время обучения в вузе, а также современное средство оценки ваших достижений.

				Портфолио позволит вам:
			</p>
			<ul>


				<li>продемонстрировать будущему работодателю вашу активную жизненную позицию,

					умение мыслить, творить и действовать самостоятельно, решать нетрадиционные задачи;
				</li>

				<li>участвовать в конкурсах на получение специальных и повышенных академических

					стипендий;
				</li>

				<li>принимать участие в наиболее значимых внеучебных мероприятиях университета;</li>

				<li>подавать заявки на получение исследовательских и учебных грантов;</li>

				<li>заниматься научной и общественной деятельностью.</li>

			</ul>
			<p>
				Пожалуйста, подойдите к формированию этого документа творчески и ответственно.
			</p>

		</div>

	</div>


</div>
