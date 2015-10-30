<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
	<div class="container">
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
