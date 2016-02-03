<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data app\models\User */
$role_id                       = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
$this->title                   = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

	<h1><?= Html::tag('i', '', ['class' => 'glyphicon glyphicon-user']) . " " . Html::encode($this->title) ?></h1>

	<? if ($role_id == User::ROLE_ADMINISTRATOR || $role_id == User::ROLE_GOD) { ?>
		<p>
			<?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . ' Добавить', ['create'], ['class' => 'btn btn-success']) ?>
			<?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-import']) . ' Импортировать', ['import'], ['class' => 'btn btn-info', 'disabled' => $role_id == User::ROLE_ADMINISTRATOR ? 'disabled' : false])  ?>
		</p>
	<? } ?>

	<?=
	GridView::widget([
		                 'dataProvider' => $dataProvider,
		                 'filterModel'  => $searchModel,
		                 'columns'      => [
			                 ['class' => 'yii\grid\SerialColumn'],
			                 [
				                 'attribute' => 'phio',
				                 'value'     => function ($data) {
					                 return Html::a($data->phio, ['view?id=' . $data->id]);
				                 },
				                 'format'    => 'raw',
			                 ],
			                 'number',
			                 [
				                 'attribute' => 'structure',
				                 'value'     => 'structure.name',
			                 ],
			                 /*[
								 'attribute' => 'company_id',
								 'value'     => function ($data) {
										 return $data->company->name;
									 },
								 'format'    => 'text',
								 'filter'    => $searchModel->getCompanies()
							 ],*/
							 'start_year',
			                 /*[
								 'attribute' => 'structure',
								 'value'     => function ($data) {
									 return $data->structure['name'];
								 },
								 //'filter' => $roles

							 ],*/
			                 //'created',
			                 //'updated',
			                 /*[
								'attribute' => 'author_id',
								 'value'=>function($data) {
										 return $data->getAuthor()['phio'];
									 },
								 'filter' => $authors
							 ],*/
			                 //'parent_id',
			                 // 'last_login',
			                 //'start_year',
			                 [
				                 'attribute' => 'email',
				                 'value'     => function ($data) {
					                 return $data->email;
				                 },
				                 'format'    => 'text',
			                 ],
			                 [
				                 'attribute' => 'role_id',
				                 'value'     => function ($data) {
					                 return $data->getRoleLabel();
				                 },
				                 'filter'    => $roles
			                 ],
			                 [
				                 'attribute' => 'status',
				                 'value'     => function ($data) {
					                 return $data->getStatusLabel();
					                 //return $data = 1 ? Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . " " . $data->getStatusLabel() : Html::tag('i', '', ['class' => 'glyphicon glyphicon-remove']) . " " . $data->getStatusLabel();
				                 },
				                 //'contentOptions' => ['style'=>'text-align: center'],
				                 'format'    => 'html',
				                 'filter'    => $statuses
			                 ],
			                 [
				                 'class'    => 'yii\grid\ActionColumn',
				                 'buttons'  => [
					                 'switch' => function ($url, $model, $key) use ($role_id) {
						                 if ($role_id == User::ROLE_GOD) {
							                 return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
								                 'title'     => \Yii::t('yii', 'Switch'),
								                 'data-pjax' => '0',
							                 ]);
						                 }
					                 }
				                 ],
				                 'template' => '{view} {update} {delete} {switch}'
			                 ],
		                 ],
	                 ]); ?>

</div>
