<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StudentWorksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;

$this->title                   = 'Записи студентов';
$this->params['breadcrumbs'][] = $this->title;
if($role_id==User::ROLE_STUDENT){
$access_url = Url::to(array_merge([Yii::$app->request->getPathInfo()], Yii::$app->request->getQueryParams(),['access_code'=>md5(Url::current().Yii::$app->user->identity->login_hash)]));
//echo "<div><a href='{$access_url}'>Ссылка доступа</a></div>";
}
?>
<div class="student-works-index">


	<h1><?= $user->phio; ?></h1>
	<h5><?= $user->roleLabel; ?>, <?= $user->structure['name']; ?></h5>
	<div>&nbsp;</div>
	<?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a href="/users/view/?id=<?=$user->user_id?>" class="btn btn-link navbar-btn"><i class="glyphicon glyphicon-user"></i> Общая информация</a>
			<div class="pull-right">
				<p class="navbar-text"><strong>Вид деятельности:</strong></p>
				<ul class="nav navbar-nav">

					<?
					foreach ($disciplines as $key => $d) {
						?>
						<li class="<?=$discipline_id == $key ? 'active' : '' ?>"><a href="/works/studentworks?id=<?=$user->user_id?>&discipline_id=<?=$key?>" class=""><?=$d?></a></li>
						<!--<a href="#" class="active btn btn-link navbar-btn"><?/*=$d*/?></a>-->
					<?
					}
					?>
				</ul>
			</div>
		</div>
	</nav>

	<? if ($role_id == User::ROLE_STUDENT) { ?>
		<p>
			<?= Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить запись', ['create'], ['class' => 'btn btn-success']) ?>
		</p>
	<? } ?>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		//'filterPosition'=> '',
		//'tableOptions' =>['class' => 'table table-default table-no-border'],

		'columns'      => [
			//['class' => 'yii\grid\SerialColumn'],
			//'updated',
			//'author_id',
			[
				'attribute' => 'title',
				//'label'     => 'Текст работы',
				'value'     => function ($data) {
					return Html::a($data['title'], ['view', 'id' => $data['work_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне']);
				},
				'format'    => 'raw'
			],

			/*[
				'attribute' => 'comment',
				'label'     => false,
				'value'     => function ($data) {
					return Html::a(Html::tag('h3',$data['title'],[]), ['view', 'id' => $data['work_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне'])
						. "" .
					Html::tag('span',Yii::$app->formatter->asDatetime($data['created'], "php:j M Y"),[])
					. " " .
					Html::tag('span', $data->statusLabel, ['class' => 'label label-' . $data->statusClass])
					. "" .
						Html::tag('p',$data['comment'],[]);
				},
				'format'    => 'raw'
			],*/
			[
				'attribute' => 'comment',
				'label'     => 'Текст работы',
				'value'     => function($data){
					return mb_substr($data['comment'],0,200,"UTF-8");
				},
				'format'    => 'html'
			],
			/*[
				'attribute' => 'author',
				'label'     => 'Автор',
				'value'     => function ($data) {
					return $data['author']['phio'];
				},
				'format'    => 'raw',
				//'visible'	=> !Yii::$app->user->identity->role_id == User::ROLE_STUDENT
			],*/
			//'work_id',
			//'filename',
			// 'type',
			// 'mark',
			 //'comment:ntext',
			// 'discipline_id',
			/*[
				'attribute' => 'discipline_id',
				'value'     => function ($data) {
					return $data->disciplineLabel;
				},
				//'contentOptions' => ['style'=>'text-align: center'],
				'format'    => 'html',
				//'filter' => $disciplines
			],*/
			// 'student_id',
			//'status',
			[
				'attribute' => 'status',
				'value'     => function ($data) {
					return Html::tag('span', $data->statusLabel, ['class' => 'label label-' . $data->statusClass]);
				},
				//'contentOptions' => ['style'=>'text-align: center'],
				'format'    => 'html',
				'filter'    => $statuses
			],
			//'created',
			[
				'attribute' => 'created',
				'value'     => function ($data) {
					return Yii::$app->formatter->asDatetime($data['created'], "php:d M Y");
				}
			],

			//['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
