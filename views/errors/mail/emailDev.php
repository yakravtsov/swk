<?php //date_default_timezone_set('Europe/Moscow'); ?>
<?
use yii\helpers\Html;
$user = !Yii::$app->user->isGuest ? Yii::$app->user->identity : false;
$mess = explode('/',$exception->getFile());
$mess_c = count($mess);
$controller = $mess[$mess_c - 2] . "/" . $mess[$mess_c - 1] . ":" . $exception->getLine() . "; " . str_replace('http://','',Yii::$app->request->absoluteUrl);
?>
<div style="overflow:hidden; float:left; display:none; line-height:0px;"><?=$exception->getMessage() . "; "  . $controller; ?></div>
<table cellpadding="0" cellspacing="0" border="0" style="display:table;table-layout:fixed;width:100%;background:#ffffff;border: 1px solid #dadada; border-collapse: collapse;">
	<tr style="background:#0063bf;">
		<td style="width:244px;padding:10px 15px 15px;color:#f6f6f6;background:#0063bf;text-align:center;font-family:Arial;">
			<a href="//studentsonline.ru" style="text-decoration:none;"
			   title="Нажмите, чтобы узнать больше">
				<span style="font-size:28px;font-weight:bold;color:#f6f6f6;">StudentsOnline.ru</span>
				<br>
				<span style="font-size:13px;color:#dee8f1;">Электронное портфолио обучающегося</span>
			</a>
		</td>
		<td style="padding:15px 15px 13px;color:#f6f6f6;background:#0063bf;line-height:22px;text-align:right;font-family:Arial;">
			<a href="tel:89684300888" style="font-size:24px;color:#f6f6f6;text-decoration:none;"
			   title="Позвонить в компанию">8 968 430-08-88</a><br>
			<a href="mailto:pochta@studentsonline.ru"
			   style="color:#dee8f1;font-size:12px;" title="Написать письмо в компанию">pochta@studentsonline.ru</a>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding:10px 15px;vertical-align:top;background:#dee8f1;line-height: 26px;font-size: 16px;font-family: Arial,sans-serif;">
			<a href="<?=Yii::$app->request->absoluteUrl;?>" style="color:#0063bf;"><?=str_replace('http://','',Yii::$app->request->absoluteUrl)?></a>
			<br>
			<?
			if(!Yii::$app->user->isGuest){
				echo $user->getRoleLabel() . " " . Html::a($user->phio,'http://studentsonline.ru/users/view/?id=' . $user->user_id,['style'=>'color:#0063bf;']);
			} else {
				echo 'Гость';
			}
			?>
			<br>
			<i><?=Yii::$app->formatter->asDate(time() - 3600, 'php: H:i:s, d M Y');?></i>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding:0 0 0 0;vertical-align:top;">
			<?=$body;?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td colspan="2"
		    style="padding:10px;color:gray;text-align:center;font-family:'Arial';font-size:12px;border-top:1px solid lightgray;border-bottom:1px solid lightgray;border-left:0;border-right:0;">
			Это письмо сгенерировано автоматически, пожалуйста, не отвечайте на него
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div>&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" height="50"
		    style="padding:10px 15px;font-size:12px;color:#666666;background:#222222;font-family:Arial;">
			<a href="//onlineconsulting.pro" style="display:block;color:#666666;text-decoration:none;"
			   title="Посетить сайт компании">
				<span style="font-size:18px;font-weight:bold;color:#666666;">Компания «Онлайн Консалтинг»</span><br>
				<span style="display:block;padding:3px 0;color:#666666;">ОГРН 1137847243060. 198097, Санкт-Петербург, улица Маршала
					Говорова, 29 литер А.
				</span>
			</a>
		</td>
	</tr>
</table>