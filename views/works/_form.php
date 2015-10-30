<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\models\User;

use Zelenin\yii\widgets\Summernote\Summernote;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWorks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-works-form">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?= $form->field($model, 'title')->textInput() ?>

	<?= $form->field($model, 'comment')->widget(Summernote::className(), [
		'clientOptions' => [
			//...
		]
	])->label('Описание') ?>
	<?= $form->field($model, 'filename[]')->widget(FileInput::classname(), [
		'options'       => ['multiple' => TRUE],
		'pluginOptions' => [
			'previewFileType'          => 'any',
			'browseClass'              => 'btn btn-info',
			//																					'showCaption' => false,
			//																					'showRemove' => false,
			'showUpload'               => FALSE,
			'initialPreview'           => $initialPreview,
			'initialPreviewConfig' => $initialPreviewConfig,
			'showRemove'=>false,
			'overwriteInitial'         => FALSE,
			//'initialPreviewShowDelete' => TRUE
		]
	]);
	?>

	<? /*= $form->field($model, 'type')->dropDownList($model->getWorkTypes()) */ ?>

	<? /*= $form->field($model, 'mark')->widget(StarRating::classname(), [
		'pluginOptions' => [
			'min'                => 0,
			'max'                => 5,
			'step'               => 1,
			'clearCaption'       => 'Не выбрана',
			'size'               => 'sm',
			'starCaptions'       => [
				1 => 'Ужасно',
				2 => 'Неудовлетворительно',
				3 => 'Удовлетворительно',
				4 => 'Хорошо',
				5 => 'Отлично',
			],
			'starCaptionClasses' => [
				1 => 'text-danger',
				2 => 'text-danger',
				3 => 'text-info',
				4 => 'text-primary',
				5 => 'text-success',
			],
		]]);
	*/ ?>

	<?= $form->field($model, 'discipline_id')
	         ->dropDownList($model->getDisciplineValues(), ['ng-model' => 'test.order']) ?>

	<?
	$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
	if ($role_id !== User::ROLE_STUDENT) {
		echo $form->field($model, 'status')->dropDownList($model->getStatusValues(), ['ng-model' => 'test.order']);
	}
	?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Создать' : '<i class="glyphicon glyphicon-ok"></i> Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
