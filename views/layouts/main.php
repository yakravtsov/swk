<?php
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
    <title><?= Html::encode($this->title) ?></title>
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
</head>
<body>

<?php $this->beginBody() ?>


<?

$user_id = !Yii::$app->user->isGuest ? Yii::$app->user->identity->user_id : 0;
?>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Элпост',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-inverse',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' Общая информация', 'url' => ['/users/view/?id=' . $user_id], 'visible'=> !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id==\app\models\User::ROLE_STUDENT],
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-user']) . ' Пользователи', 'url' => ['/users'], 'visible'=>!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id!=\app\models\User::ROLE_STUDENT],
                    ['label' => Html::tag('i','',['class'=>'glyphicon glyphicon-th-list']) . ' Работы', 'url' => ['/works'], 'visible'=>!Yii::$app->user->isGuest],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Войти', 'url' => ['/site/login']] :
                        ['label' => 'Выйти (' . Yii::$app->user->identity->phio . ')',
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
			]);*/
			?>
            <div>&nbsp;</div>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left"><strong>&copy; Онлайн Консалтинг, <?= date('Y') ?></strong></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
