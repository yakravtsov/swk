<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWorks */

$this->title                   = 'Редактирование записи: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Записи студентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->author->phio, 'url' => ['studentworks', 'id' => $model->author_id]];
$this->params['breadcrumbs'][] = ['label' => mb_substr($model->title, 0, 30, "UTF-8") . "…", 'url' => ['view', 'id' => $model->work_id]];
$this->params['breadcrumbs'][] = 'Редактирование';

Yii::$app->response->formatters['pdf']['methods']['setHTMLHeader'] = '<h6 class="text-muted text-center"><em>Оригинал: <a class="text-muted" href="http://' . $university->subdomain . '.studentsonline.ru/works/?id=' . $model->work_id . '">' . $university->subdomain . '.studentsonline.ru/works/?id=' . $model->work_id . '</a></em></h6>';
Yii::$app->response->formatters['pdf']['methods']['setHTMLFooter'] = '<h6 class="text-muted text-center"><em>Электронное портфолио обучающегося <a class="text-muted" href="http://studentsonline.ru"><strong>StudentsOnline.ru</strong></a></em></h6>';

/*Yii::$app->response->formatters['pdf']['methods']['setHTMLFooter'] =
	'<h6 class="text-muted text-right pull-right">
		<em>
		Электронное портфолио обучающегося <a class="text-muted" href="http://studentsonline.ru"><strong>StudentsOnline.ru</strong></a>
		</em>
		</h6>
<h6 class="text-muted text-left pull-left">
		<em>Оригинал: <a class="text-muted" href="http://' . $university->subdomain . '.studentsonline.ru/works/?id=' . $model->work_id . '">' . $university->subdomain . '.studentsonline.ru/works/?id=' . $model->work_id . '</a></em>
		</h6>
		<div class="clearfix"></div>';*/

$teacherIsEmpty = empty($teacher);

//$this->params['viewUniversity'] = false;
?>
<div class="student-works-pdf">

	<?
	//var_dump($university->name);
	?>
	<h5 class="text-center"><?= $university->name; ?></h5>
	<h5 class="text-center"><?= $structure->name; ?></h5>
	<br>
	<h5 class="text-center">Демонстрационная кафедра</h5>

	<div>&nbsp;</div>
	<h4 class="text-center"><?= $model->getDisciplineLabel(); ?> деятельность</h4>

	<h3 class="text-center"><?= $model->title; ?></h3>
	<!--<h4 class="text-center"><? /*= $model->author->roleLabel; */ ?> <? /*= $model->author->phio; */ ?></h4>-->
	<div>&nbsp;</div>

	<div class="pull-right text-right">
		<p>
			<strong>Студент:</strong> <?= $model->author->phio; ?>
		</p>

		<p>
			<strong>Статус:</strong> <?= Html::tag('span', $model->statusLabel, ['class' => 'text-' . $model->statusClass]); ?>
			<? if (!$teacherIsEmpty) { ?>
				<br>
				<strong>Проверил:</strong> <?= $teacher->phio; ?>
				<br>
				<strong>Дата:</strong> <?= date('d.m.y'); ?>
				<br>
				<? !empty($model->mark) ? Html::tag('strong', 'Оценка:', []) . " " . $model->mark . " " . $model->markLabel : ''; ?>
			<? } ?>
		</p>

	</div>
	<div class="clearfix"></div>
	<div>&nbsp;</div>
	<?= $model->comment; ?>
	<div>&nbsp;</div>

	<?
	if (!empty($model->files)) {
		echo Html::tag('strong', 'Прикреплённые файлы' . "<br>", []);
		foreach ($model->files as $file) {
			echo Html::a($file->real_name, ['/works/getfile', 'file' => $file->file_id], []);
		}
	}
	?>

	<div>&nbsp;</div>
	<? if (!$teacherIsEmpty) {
		echo Html::tag('strong', "Рецензия преподавателя", []);
		?>

		<? echo Html::tag('div', $model->review, []); ?>
	<? } ?>

</div>
