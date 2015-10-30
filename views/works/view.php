<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\User;
use app\models\StudentWorks;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWorks */

$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;

$this->title = $model->title;
if ($role_id == User::ROLE_GUEST) {
	$this->params['breadcrumbs'][] = ['label' => 'Записи студентов'];
} else {
	if ($role_id == User::ROLE_STUDENT) {
		$this->params['breadcrumbs'][] = ['label' => 'Записи студентов'];
	} else {
		$this->params['breadcrumbs'][] = ['label' => 'Записи студентов', 'url' => ['index']];
	}
}
$this->params['breadcrumbs'][] = ['label' => $model->author->phio,
                                  //'url'   => ['studentworks', 'id' => $model->author_id]];
'url'   => ['users/view', 'id' => $model->author_id]];
$this->params['breadcrumbs'][] = 'Просмотр записи';
if ($role_id == User::ROLE_STUDENT) {

	$access_url = Url::to(array_merge([Yii::$app->request->getPathInfo()], Yii::$app->request->getQueryParams(), ['access_code' => md5(Url::current() . Yii::$app->user->identity->login_hash)]));
	//echo "<div><a href='{$access_url}'>Ссылка доступа</a></div>";
}
?>
<div class="student-works-view">

	<h1><?= $model->title ?></h1>

	<p>
		<?

		if (Yii::$app->user->id == $model->author_id || $role_id == User::ROLE_ADMINISTRATOR) {

			echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model->work_id], ['class' => 'btn btn-primary'])
				. " " .
				Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model->work_id], ['class' => 'btn btn-danger',
				                                                                                                                         'data'  => ['confirm' => 'Вы уверены, что хотите удалить этот тест?',
				                                                                                                                                     'method'  => 'post',]]);

		}

		?>
	</p>


	<?
	$all_files = '';
	foreach($initialPreview as $file){
		$all_files .= $file . "<br>";
	}
	?>


	<div>&nbsp;</div>

	<?
	if ($role_id == User::ROLE_TEACHER) {
		$form = ActiveForm::begin(['action'      => ['setstatus?id=' . $model->work_id],
		                           'layout'      => 'horizontal',
		                           'fieldConfig' =>
			                           ['template'             => "{label}\n{beginWrapper}\n{input}\n" . Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Изменить статус', ['class' => 'btn btn-primary btn-sm']) . "\n{hint}\n{error}\n{endWrapper}",
			                            'horizontalCssClasses' => [
				                            'label'   => 'col-sm-1',
				                            'offset'  => 'col-sm-offset-0',
				                            'wrapper' => 'col-sm-4',
				                            'error'   => '',
				                            'hint'    => '',],],]); ?>
		<?= $form->field($model, 'status')->dropDownList($model->getStatusValues(), ['class' => 'input-sm'])
		         ->label(FALSE); ?>


		<? ActiveForm::end();
	} ?>

	<?= DetailView::widget([
		'model'      => $model,
		'attributes' =>
			[
				//'created',
				//'updated',
				[
					'attribute' => 'author_id',
					'value'     => Html::a($model->author->phio, ['studentworks', 'id' => $model->author_id]),
					'format'    => 'html',
				],
				//'filename',
				['attribute' => 'discipline_id',
				 'value'     => $model->disciplineLabel,
				 'format'    => 'html',],
				//'student_id',
				['attribute' => 'status',
				 'value'     => Html::tag('span', $model->statusLabel, ['class' => 'label label-' . $model->statusClass]),
				 'format'    => 'html',
				],
			    [
				    'label' => 'Прикреплённые файлы',
			        'value' => $all_files,
			        'format' => 'raw'
				]
			],
	]); ?>

	<div>&nbsp;</div>

	<div class="panel panel-default">
		<div class="panel-body">

			<?= $model->comment ?>
		</div>
	</div>

</div>
