<?php
use app\components\widgets\RoleSwitch;
use app\models\User;
use yii\bootstrap\Button;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\ButtonGroup;

/* @var $this \yii\web\View */
/* @var $content string */

$university_exist = Yii::$app->university->model ? TRUE : FALSE;

$university_id = $university_exist ? Yii::$app->university->model->university_id : 3;

$user_id = !Yii::$app->user->isGuest ? Yii::$app->user->identity->user_id : 0;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<!--<title><? /*= Html::encode(Yii::$app->name) */ ?></title>-->
	<title><?= empty($this->title) ? Html::encode(Yii::$app->name) : Html::encode($this->title); ?></title>
	<?php $this->head() ?>

	<?
	$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () {
    $("[data-toggle='tooltip']").tooltip();
});;
/* To initialize BS3 popovers set this below */
$(function () {
    $("[data-toggle='popover']").popover();
});
SCRIPT;
	// Register tooltip/popover initialization javascript
	$this->registerJs($js);
	?>

	<? if ($university_exist) {
		?>
		<meta name='yandex-verification' content='<?= Yii::$app->university->model->yandex_verification; ?>'/>
	<? } ?>

	<meta name="google-site-verification" content="jgTPaCWlqYaXjkpxWZ2d2j-w0RjvSuMmINI2N4V-pTY"/>
	<? if ($university_exist) {
		?>
		<link rel="shortcut icon" type="image/x-icon" href="/i/favicon.png"><?
	} else {
		?>
		<link rel="shortcut icon" type="image/x-icon" href="/i/favicon_inside.png"><?
	}
	?>

</head>
<body>

<?php $this->beginBody() ?>

<div class="wrap">
	<?php
	NavBar::begin([
		//'brandLabel' => 'Studentsonline.ru',
		'brandLabel' => Html::img('http://studentsonline.ru/landing/i/logo.png', ['style' => 'margin-top:-10px;height:200%;', 'alt' => Yii::$app->name]),
		'brandUrl'   => '/',
		'options'    => [
			'class' => 'navbar-default navbar-inverse navbar-top',
		],
		/*'brandOptions' => array(
			'target' => '_blank',
			'title' => 'Откроется в новом окне'
		),*/

	]);


	echo Nav::widget([
		'options'      => ['class' => 'navbar-nav navbar-right'],
		'encodeLabels' => FALSE,
		'items'        => [
			//['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' Общая информация', 'url' => ['/users/view/?id=' . $user_id], 'visible'=> !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id==\app\models\User::ROLE_STUDENT],
			['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-th-list']) . ' Деятельность', 'url' => ['/works/index'], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id != \app\models\User::ROLE_STUDENT && Yii::$app->user->identity->role_id != \app\models\User::ROLE_GUEST && Yii::$app->user->identity->role_id != \app\models\User::ROLE_AGENT],
			//['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-th-list']) . ' Моя деятельность', 'url' => ['/works/studentworks','id'=>Yii::$app->user->identity->user_id], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == \app\models\User::ROLE_STUDENT],
			['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-user']) . ' Пользователи', 'url' => ['/users/index'], 'visible' => !Yii::$app->user->isGuest && (Yii::$app->user->identity->role_id == \app\models\User::ROLE_ADMINISTRATOR || Yii::$app->user->identity->role_id == \app\models\User::ROLE_GOD)],
			['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-user']) . ' Студенты', 'url' => ['/users/students'], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == \app\models\User::ROLE_TEACHER],
			['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-tower']) . ' Подразделения', 'url' => ['/structure/index'], 'visible' => !Yii::$app->user->isGuest && (Yii::$app->user->identity->role_id == \app\models\User::ROLE_ADMINISTRATOR || Yii::$app->user->identity->role_id == \app\models\User::ROLE_GOD)],
			['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-education']) . ' Университеты', 'url' => ['/university/index'], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == \app\models\User::ROLE_GOD],
			//['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' ' . Yii::$app->user->identity->phio, 'url' => ['/university'], 'visible'=> !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id==\app\models\User::ROLE_STUDENT],
			Yii::$app->user->isGuest ?
				['label' => ''] :
				['label'   => Html::tag('i', '', ['class' => 'glyphicon glyphicon-home']) . "&nbsp;&nbsp;" . Yii::$app->user->identity->phio,
				 /*['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-home']) . " " . Html::tag('strong',Yii::$app->user->identity->phio,[]) . " " . Html::tag('sup',Yii::$app->user->identity->RoleLabel,[]),*/
				 'url'     => ['/users/view', 'id' => Yii::$app->user->identity->user_id],
				 'options' => [
					 'data-toggle'    => 'tooltip',
					 'data-placement' => 'bottom',
					 'data-html'      => "true",
					 'data-title'     => '<strong>Страница пользователя</strong><br>Нажмите для перехода'
				 ],
				 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id != \app\models\User::ROLE_AGENT
				 /*'linkOptions' => ['data-method' => 'post']*/
				],
			RoleSwitch::getDropdown(),
			Yii::$app->user->isGuest ?
				['label' => 'Войти', 'url' => ['/site/login'], 'visible' => 2 == 1] :
				['label'       => Html::tag('i', '', ['class' => 'glyphicon glyphicon-log-out']) . ' Выйти',
				 'url'         => ['/site/logout'],
				 'linkOptions' => ['data-method' => 'post']
				],
			['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-question-sign']) . ' Инструкция', 'url' => ['/site/manual'], 'visible' => empty(Yii::$app->user->identity) || (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == \app\models\User::ROLE_STUDENT)],
			/*['label'       => Html::tag('i', '', ['class' => 'glyphicon glyphicon-question-sign']),
			 'url'         => '#',
			 'options'     => [
				 'data-toggle'    => 'tooltip',
				 'data-placement' => 'bottom',
				 'data-title'   =>
					 'Нажмите, чтобы увидеть подсказки'
			 ],
			 'linkOptions' => [
				 'class' => 'navbar-top-help',

			 ],
			 'visible'     => !Yii::$app->user->isGuest],*/
		],
	]);

	NavBar::end();
	?>

	<div class="container">
<?if($university_exist && $university_id !== 7) {?>
		<div class="alert alert-warning text-center" role="alert">
			<!--<div class="pull-right">
				<a href="" class="btn btn-success">
					<i class="glyphicon glyphicon-edit"></i>
					Подключить тариф
				</a>
			</div>-->
			Вы используете демоверсию электронного портфолио <strong>StudentsOnline.ru</strong>. До окончания пробного периода осталось 10 <?/*= 27 - date('d'); */?>
			дней.

			<!--Нажмите на кнопку справа, чтобы подключить подходящий для вашего вуза тариф.-->
			<div class="clearfix"></div>
		</div>
<?} ?>

		<? /* echo ButtonGroup::widget([
								'options'=>[
									//'style'=>'margin-top: -23px; margin-bottom: 15px;'
								],
					'buttons'=>[
						Html::a('Добавить работу', ['/works/create'], ['class'=>'btn btn-success']),
						Html::a('Добавить студента', ['/users/create'], ['class'=>'btn btn-success']),
				]
			]);*/ ?>


		<!--<h4 class="text-left"><? /*=Html::tag('i','',['class'=>'glyphicon glyphicon-education']) .  " " .Yii::$app->university->model->name;*/ ?></h4>-->
		<?
		$no_hgroup = ["/site/index", "/site/login"];
		if (!in_array(Url::current(), $no_hgroup) && $university_exist) { ?>
			<hgroup
				class="text-left <?= !empty($this->params['viewUniversity']) && $this->params['viewUniversity'] ? "" : "hidden-print"; ?>">
				<?
				echo Html::tag('h4', Yii::$app->university->model->name, ['style' => 'margin:0 auto;']);
				/**/ ?><!--<br>--><? /*
				if ($structure_exist) {
					echo Html::tag('span',$this->params['structure']['name'],[]);
				}
				*/ ?>
			</hgroup>
			<div>&nbsp;</div>
		<? } ?>

		<div class="hidden-print">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
		</div>
		<div class="layout-content">
			<?= $content ?>
		</div>
	</div>
</div>

<footer class="footer hidden-print">
	<div class="container">
		<!--<p class="pull-left"><a href="//studentsonline.ru" target="_blank" data-toggle="tooltip" data-placement="top" title="Возможности сервиса, внешний вид, тарифы и прочее"><i class="glyphicon glyphicon-link"></i> Узнать больше о <strong>StudentsOnline.ru</strong></a></p>-->
		<p class="pull-right text-muted">
			<small>
				<a class="text-muted" href="//studentsonline.ru" target="_blank" data-toggle="tooltip"
				   data-placement="top"
				   title="Возможности сервиса, внешний вид, тарифы и прочее"><i
						class="glyphicon glyphicon-info-sign"></i>
					Узнать больше о StudentsOnline</a>
				&nbsp;
				<i class="glyphicon glyphicon-copyright-mark"></i> <a class="text-muted" href="//onlineconsulting.pro"
				                                                      target="_blank"
				                                                      data-toggle="tooltip" data-placement="top"
				                                                      title="Сайт компании-разработчика сервиса StudentsOnline.ru">Онлайн
					Консалтинг</a>, <?= date('Y') ?>.
			</small>
		</p>

		<div class="clearfix"></div>
		<!--<p class="pull-right"><? /*= Yii::powered() */ ?></p>-->
	</div>
</footer>

<script type="text/javascript">
	$(document).ready(function () {
		$('body').on('click', '.popover .close', function () {
			if ($('.tooltip').length == 1) {
				$('.navbar-top-help').closest('li').removeClass('active');
				$('.navbar-top-help').blur();
			}
			$(this).closest('.tooltip').tooltip('toggle');
		});

		/*$('[data-toggle=popover]').on('mouseover mouseout',function(e){
		 $(this).popover('toggle');
		 })*/

		$('.navbar-top-help').on('click', function () {
			var tooltip = $('.wrap [data-toggle=tooltip]');
			var $this = $(this);
			var li = $this.closest('li');
			if (li.hasClass('active')) {
				li.data('title', 'asfd');
				li.removeClass('active');
				tooltip.removeClass('help-active');
				tooltip.tooltip('hide');
				$this.blur();
			} else {
				//li.find('small').html($this.glyphicon_close + ' Убрать подсказки');
				li.addClass('active');
				tooltip.addClass('help-active');
				//tooltip.tooltip('show');
			}
			return false;
		});

		$('.wrap [data-toggle=tooltip]').on('show.bs.tooltip', function (e) {
			if (!$('.navbar-top-help').closest('li').hasClass('active') && $(this).prop('id') !== "shared_link" && !$(this).hasClass('need-tooltip')) {
				e.preventDefault();
			}
		})
	});
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
