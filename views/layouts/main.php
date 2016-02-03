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

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
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
    <link rel="shortcut icon" type="image/x-icon" href="/i/favicon.png">
</head>
<body>

<?php $this->beginBody() ?>


<?

$user_id = !Yii::$app->user->isGuest ? Yii::$app->user->identity->user_id : 0;
?>

    <div class="wrap">
        <?php
            NavBar::begin([
                //'brandLabel' => 'Studentsonline.ru',
                'brandLabel' => Html::img('http://studentsonline.ru/landing/i/logo.png', ['style'=>'margin-top:-10px;height:200%;','alt'=>Yii::$app->name]),
                'brandUrl' => '/',
                'options' => [
                    'class' => 'navbar-default navbar-inverse',
                ],
                /*'brandOptions' => array(
                    'target' => '_blank',
                    'title' => 'Откроется в новом окне'
                ),*/

            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    //['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' Общая информация', 'url' => ['/users/view/?id=' . $user_id], 'visible'=> !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id==\app\models\User::ROLE_STUDENT],
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-th-list']) . ' Записи', 'url' => ['/works/index'], 'visible'=>!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id!=\app\models\User::ROLE_STUDENT && Yii::$app->user->identity->role_id!=\app\models\User::ROLE_GUEST],
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' Пользователи', 'url' => ['/users/index'], 'visible'=>!Yii::$app->user->isGuest && (Yii::$app->user->identity->role_id==\app\models\User::ROLE_ADMINISTRATOR || Yii::$app->user->identity->role_id==\app\models\User::ROLE_GOD)],
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' Студенты', 'url' => ['/users/students'], 'visible'=>!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id ==\app\models\User::ROLE_TEACHER],
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-tower']) . ' Институты', 'url' => ['/structure/index'], 'visible'=>!Yii::$app->user->isGuest && (Yii::$app->user->identity->role_id==\app\models\User::ROLE_ADMINISTRATOR || Yii::$app->user->identity->role_id==\app\models\User::ROLE_GOD)],
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-education']) . ' Университеты', 'url' => ['/university/index'], 'visible'=> !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id==\app\models\User::ROLE_GOD],
                    //['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' ' . Yii::$app->user->identity->phio, 'url' => ['/university'], 'visible'=> !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id==\app\models\User::ROLE_STUDENT],
                    Yii::$app->user->isGuest ?
                        ['label' => ''] :
                        ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-home']) . ' ' . Yii::$app->user->identity->phio,
                         'url' => ['/users/view','id'=>Yii::$app->user->identity->user_id],
                         /*'linkOptions' => ['data-method' => 'post']*/
                        ],
                    RoleSwitch::getDropdown(),
                    Yii::$app->user->isGuest ?
                        ['label' => 'Войти', 'url' => ['/site/login']] :
                        ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-log-out']) . ' Выйти',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']
						],

                ],
            ]);

		NavBar::end();
        ?>

        <div class="container">

			<?/* echo ButtonGroup::widget([
								'options'=>[
									//'style'=>'margin-top: -23px; margin-bottom: 15px;'
								],
					'buttons'=>[
						Html::a('Добавить работу', ['/works/create'], ['class'=>'btn btn-success']),
						Html::a('Добавить студента', ['/users/create'], ['class'=>'btn btn-success']),
				]
			]);*/?>


            <!--<h4 class="text-left"><?/*=Html::tag('i','',['class'=>'glyphicon glyphicon-education']) .  " " .Yii::$app->university->model->name;*/?></h4>-->
            <!--<div class="row">
                <div class="col-xs-8">
                    <img class="pull-left" style="height:50px; padding-right: 10px;" src="/i/university_logos/<?/*=Yii::$app->university->model->subdomain*/?>.png" alt="" />
                    <h4 class="text-left" style="margin-top:6px;"><?/*=Yii::$app->university->model->name;*/?></h4>
                    <div class="clearfix"></div>
                </div>
            </div>-->
            <? if(Url::current() != "/site/index"){?>
            <h4 class="text-left" style="margin: 0 auto 0;">
                <?/*=Yii::$app->university->model->name;*/?>
            </h4>
            <?}?>
            <div>&nbsp;</div>

            <div class="hidden-print">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            </div>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left"><strong>&copy; <a href="//onlineconsulting.pro" target="_blank" title="Откроется в новом окне">Онлайн Консалтинг</a>, <?= date('Y') ?></strong></p>
            <!--<p class="pull-right"><?/*= Yii::powered() */?></p>-->
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
