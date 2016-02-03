<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\grid\GridView;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
$current_university = Yii::$app->university->model;

$this->title                   = $model->phio;
if ($role_id == User::ROLE_ADMINISTRATOR || $role_id == User::ROLE_GOD) {
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
	<h1>
		<?= Html::tag('span',$model->phio/*,['/users/view','id'=>$model->user_id],[''=>'']*/); ?>
	</h1>
	<h4 class="text-left"><?=$model->roleLabel . ", " . mb_strtolower($model->structure['name'], 'utf8');?></h4>
<!--	<h5 class="text-left"><?/*=Html::tag('i','',['class'=>'glyphicon glyphicon-education']) .  " " .Yii::$app->university->model->name;*/?></h5>
	<h5 class="text-left"><?/*=Html::tag('i','',['class'=>'glyphicon glyphicon-tower']) .  " " . $model->structure['name'];*/?></h4>-->
	<!--<h5><?/*= $model->roleLabel; */?>, <?/*= $model->structure['name']; */?></h5>-->

	<? if ($role_id == User::ROLE_ADMINISTRATOR || $role_id == User::ROLE_STUDENT || $role_id == User::ROLE_GOD) { ?>
		<p>
			<?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update',
			                                                                                               'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
			<?
			if ($role_id !== User::ROLE_STUDENT) {
				echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete',
				                                                                                         'id' => $model->user_id], [
					'class' => 'btn btn-danger',
					'data'  => [
						'confirm' => 'Вы уверены, что хотите удалить студента?',
						'method'  => 'post',
					],
				]);
			}?>
			<?
			if($model->role_id == User::ROLE_STUDENT) {
				if (!$model->shared) {
					echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-link']) . ' Открыть доступ по ссылке', ['sharing',
					                                                                                                         'id' => $model->user_id, 'shared' => 1], [
						'class' => 'btn btn-link',
						'data'  => [
							'confirm' => 'Вы уверены, что хотите открыть доступ к портфолио?',
							'method'  => 'post',
						],
					]);
				} else {
					echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-link']) . ' Закрыть доступ', ['sharing',
					                                                                                               'id' => $model->user_id, 'shared' => 0], [
						'class' => 'btn btn-link',
						'data'  => [
							//'confirm' => 'Вы уверены, что хотите закрыть доступ к портфолио?',
							'method' => 'post',
						],
					]);

					echo Html::tag('input', '',
						[
							'id'             => 'shared_link',
							'value'          => "http://" . $current_university->subdomain . ".studentsonline.ru/users/view?id=" . Yii::$app->user->identity->user_id,
							'class'          => 'form-control',
							'style'          => 'display: inline-block; width: 365px;',
							'data-toggle'    => 'tooltip',
							'data-placement' => 'top',
							'title'          => 'Скопируйте публичную ссылку на ваше портфолио'
						]);

					?>
					<script type="text/javascript">
						$(document).ready(function () {
							$("input#shared_link:text").on('focus', function () {
								$(this).select();
							});
						});
					</script>
				<?
				}
			}
			?>
		</p>

	<? } ?>

	<? if ($role_id == User::ROLE_ADMINISTRATOR || $role_id == User::ROLE_GOD) { ?>
		<?
		echo DetailView::widget([
			'model'      => $model,
			'attributes' => [
				'email:email',
				[
					'attribute' => 'author.phio',
					'label'     => 'Автор',
					'value'     => Html::a($model->getAuthor()['phio'], ['view',
					                                                     'id' => $model->getAuthor()['user_id']], ['target' => '_blank',
					                                                                                               'title'  => 'Откроется в новом окне']),
					'format'    => 'raw'
				],
				[
					'attribute' => 'status',
					'value'     => $model->getStatusLabel()
				],
				[
					'attribute' => 'created',
					'value'     => Yii::$app->formatter->asDatetime($model->created, "php:d M Y, H:i:s")
				],
				[
					'attribute' => 'updated',
					'value'     => Yii::$app->formatter->asDatetime($model->updated, "php:d M Y, H:i:s")
				],
				//'last_login',
				//'password_reset_token',
				//'password_hash',
				//'login_hash',
				//'auth_key',
			],
		]);
	} ?>

	<? if ($role_id == User::ROLE_STUDENT && Yii::$app->user->identity->email == '') { ?>

		<?
		Modal::begin([
			'header' => '<h2>Для вашей учётной записи не указан email</h2>',
			'id'     => 'emailModal',
			'size'   => 'modal-lg'
			//'toggleButton' => ['label' => 'click me'],
		]);


		?>
		<p class="alert alert-warning">
			Введите свой email в поле ниже и нажмите «Сохранить».<br/>
			Без email вы не сможете прикреплять файлы к своим записям, а также восстанавливать забытый
			пароль.
		</p>



	<?php $form = ActiveForm::begin(['action' => ['/users/update?id=' . Yii::$app->user->identity->id],
	                                 'layout' => 'horizontal',
	]); ?>


	<? /*= $form->field($model, 'email')->textInput()->label(false); */ ?>

		<div class="row">
			<?= $form->field($model, 'email', [
				'horizontalCssClasses' => [
					'wrapper' => 'col-sm-8',
					//'offset' => 'col-sm-6'
				],
				'inputTemplate'        => '<div class="col-sm-6">{input}</div>' .
					Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить', ['class' => 'btn btn-success',])
				,
			])->label(FALSE) ?>
		</div>

		<!--<div class="form-group">

		</div>-->

	<?php ActiveForm::end(); ?>


	<?

	Modal::end();
	?>

		<script type="text/javascript">
			$(document).ready(function () {
				jQuery('#emailModal').modal('show');
			});
		</script>

	<? } ?>

	<?
	if ($model->role_id == User::ROLE_STUDENT) {
		?>
		<div>&nbsp;</div>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!--<a href="#" class="btn btn-link navbar-btn"><i class="glyphicon glyphicon-user"></i> Общая
					информация</a>-->
					<p class="navbar-text"><strong>Деятельность:</strong></p>
					<ul class="nav navbar-nav">

						<?
						foreach ($disciplines as $key => $d) {
							?>
							<li class="">
								<a href="/works/studentworks?id=<?= $model->user_id ?>&discipline_id=<?= $key ?>"
								   class="">
									<?= $d ?>
								</a>
							</li>
						<?
						}
						?>
					</ul>
			</div>
		</nav>

		<div>&nbsp;</div>



		<div class="panel panel-default">
			<div class="panel-body">
				<?= $model->about ?>
			</div>
		</div>


	<? } ?>


</div>
