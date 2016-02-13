<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StudentWorksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;

$this->params['breadcrumbs'][] = ['label' => $user->phio, 'url' => ['users/view','id'=>$user->id]];
if(empty($discipline_id)){
	$this->params['breadcrumbs'][] = 'Все записи';
} else {
	$this->params['breadcrumbs'][] = ['label'=>'Все записи','url' => ['works/studentworks','id'=>$user->id]];
	$this->params['breadcrumbs'][] = $disciplines[$discipline_id] . " деятельность";
}
$this->title = empty($discipline_id) ? 'Вся деятельность' : $disciplines[$discipline_id] . ' деятельность';
?>
<div class="student-works-index">


	<h1><!--<i class="glyphicon glyphicon-th-list"></i> --><?=$this->title?></h1>
	<!--<h1>
		<i class="glyphicon glyphicon-th-list"></i>
		<?/*= Html::a($user->phio, ['/users/view', 'id' => $user->user_id], [
			'data-toggle'    => 'tooltip',
			'data-placement' => 'right',
			'data-html'      => "true",
			'data-title'     => '<strong>Страница пользователя</strong><br>Нажмите для перехода'
		]); */?>: записи
	</h1>-->
	<!--<h1>
		<?/*= Html::a($user->phio, ['/users/view', 'id' => $user->user_id], [
			'data-toggle'    => 'tooltip',
			'data-placement' => 'right',
			'data-html'      => "true",
			'data-title'     => '<strong>Страница пользователя</strong><br>Нажмите для перехода'
		]); */?>
	</h1>-->
	<h4 class="text-left"><?= $user->roleLabel . " " .
		Html::a($user->phio, ['/users/view', 'id' => $user->user_id], [
			'data-toggle'    => 'tooltip',
			'data-placement' => 'right',
			'data-html'      => "true",
			'data-title'     => '<strong>Страница пользователя</strong><br>Нажмите для перехода'
		]); ?></h4>

	<? if ($role_id == User::ROLE_STUDENT) { ?>
		<p>
			<?= Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить запись', ['create'], [
				'class'          => 'btn btn-success',
				'data-toggle'    => 'tooltip',
				'data-placement' => 'right',
				'data-html' => 'true',
				'data-title'     =>
					"<strong>Добавление записи</strong><br>Нажмите для внесения информации о новой записи"
					//"<strong>Форма добавления записи</strong><br>Название, описание, файлы, вид деятельности и прочее"
			]) ?>
		</p>
	<? } ?>
	<div>&nbsp;</div>
	<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

	<nav class="navbar navbar-default navbar-discipline" data-toggle="tooltip" data-placement="top" data-html="true"
	data-title="<strong>Виды деятельности</strong><br>Нажмите на название для вывода необходимых записей">
		<div class="container-fluid">
			<p class="navbar-text"><strong>Деятельность</strong></p>
			<ul class="nav navbar-nav">
				<li class="<?= empty($discipline_id) ? 'active' : ''; ?>"><a
						href="/works/studentworks?id=<?= $user->user_id ?>" class="">Вся</a></li>

				<?
				foreach ($disciplines as $key => $d) {
					?>
					<li class="<?= $discipline_id == $key ? 'active' : '' ?>"><a
							href="/works/studentworks?id=<?= $user->user_id ?>&discipline_id=<?= $key ?>"
							class=""><?= $d ?></a></li>
					<!--<a href="#" class="active btn btn-link navbar-btn"><?/*=$d*/ ?></a>-->
				<?
				}
				?>
			</ul>
		</div>
	</nav>

	<?= GridView::widget([
		'dataProvider'     => $dataProvider,
		'filterModel'      => $searchModel,
		'filterRowOptions' => [
			'data-toggle'    => 'tooltip',
			'data-placement' => 'top',
			'data-html'      => 'true',
			'data-title'     =>
				"<strong>Строка поиска записей</strong>\r\nВведите в поле искомый текст\r\nи нажмите «Enter»"
		],
		'headerRowOptions' => [
			'data-toggle'    => 'tooltip',
			'data-placement' => 'top',
			'data-html'      => 'true',
			'data-title'     =>
				"<strong>Строка сортировки записей</strong>\r\nНажмите на название ячейки\r\nдля сортировки"
		],
		//'filterPosition'=> '',
		//'tableOptions' =>['class' => 'table table-default table-no-border'],

		/*'rowOptions' => function($model,$key,$index,$grid){
			if($index == 0){
				return [
					'data-toggle'    => 'tooltip',
					'data-placement' => 'top',
					'data-html'      => 'true',
					'data-title'     =>
						"<strong>Строка сортировки записей</strong>\r\nНажмите на название ячейки\r\nдля сортировки"
				];
			}
		},*/

		'columns'          => [
			//['class' => 'yii\grid\SerialColumn'],
			//'updated',
			//'author_id',
			[
				'attribute' => 'title',
				//'label'     => 'Текст работы',
				'value'     => function ($data,$key,$index) {
						$options = [
							'data-toggle'    => 'tooltip',
							'data-placement' => 'right',
							'data-html'      => 'true',
							'data-title'     =>
								"<strong>Полный вариант записи</strong><br>Нажмите для просмотра"
						];
					return Html::a($data['title'], ['view', 'id' => $data['work_id']], $options);
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
				'label'     => 'Описание',
				'value'     => function ($data) {
					return mb_substr($data['comment'], 0, 200, "UTF-8");
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
