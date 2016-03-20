<? date_default_timezone_set('Europe/Moscow'); ?>
<table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#fdfdfd;border-collapse: collapse;">
	<tr>
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
	<!--<tr><td style="padding:15px;">фывавфыав!</td></tr>-->
	<tr>
		<td colspan="2" style="padding:20px 15px 0;vertical-align:top;">
			<span style="line-height:28px;font-size:20px;color:#333333;font-family:'Arial';">
				<!--Уважаемые коллеги из <? /*= $agent->fullname; */ ?>!<br>-->
				Здравствуйте, <?= $agent->fullname; ?>!<br>
				Пришла новая заявка с формы <?= $model->getFormLabel($model->form_id); ?>.
				</span>

			<div>&nbsp;</div>
			<div>&nbsp;</div>
			<table width="570" cellpadding="0" cellspacing="0" border="0"
			       style="font-size:20px;color:#333333;border-collapse: collapse;font-family:'Arial';">
				<tr>
					<td style="width:160px;padding:3px 0;line-height:28px;"><b>Название вуза</b></td>
					<td style="line-height:28px;"><?= $model->name; ?></td>
				</tr>
				<tr>
					<td style="padding: 3px 0;line-height:28px;"><b>Email</b></td>
					<td style="line-height:28px;"><a href="mailto:<?= $model->email; ?>"
					                                 style="color:#0063bf;"><?= $model->email; ?></a></td>
				</tr>
				<tr>
					<td style="padding: 3px 0;line-height:28px;"><b>Телефон</b></td>
					<td style="line-height:28px;"><?= $model->phone; ?></td>
				</tr>
				<tr>
					<td style="padding: 3px 0;line-height:28px;"><b>Дата и время</b></td>
					<td style="line-height:28px;"><?= Yii::$app->formatter->asDatetime(time('Y-d-m h:i:s') - 3600); ?></td>
				</tr>
			</table>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
			<table width="570" cellpadding="0" cellspacing="0" border="0"
			       style="font-size:20px;text-align:center;border-collapse: collapse;">
				<tr>
					<td style="padding: 10px 35px;text-align:center;">
						<a href="tel:<?= $model->phone; ?>"
						   style="display:block;width:220px;margin:0;padding:12px 5px 8px;text-decoration:none;line-height:24px;color:#f6f6f6;background:#63bf00;font-family:'Arial';font-weight:bold;font-size:16px;text-align:center;text-transform:uppercase;border-radius:4px;border-bottom:3px solid #419100;text-shadow: 0 1px 0 #419100;">
							Позвонить клиенту
						</a>
					</td>
					<td style="padding: 10px 35px;text-align:center;">
						<a href="http://studentsonline.ru/agent/requests?id=<?= $agent->user_id; ?>"
						   style="display:block;width:220px;margin:0;padding:12px 5px 8px;text-decoration:none;line-height:24px;color:#f6f6f6;background:#63bf00;font-family:'Arial';font-weight:bold;font-size:16px;text-align:center;text-transform:uppercase;border-radius:4px;border-bottom:3px solid #419100;text-shadow: 0 1px 0 #419100;">
							Смотреть все заявки
						</a>
					</td>
				</tr>
				<tr>
					<td style="padding: 10px 35px;text-align:center;">
						<a href="mailto:<?= $model->email; ?>"
						   style="display:block;width:220px;margin:0;padding:12px 5px 8px;text-decoration:none;line-height:24px;color:#f6f6f6;background:#63bf00;font-family:'Arial';font-weight:bold;font-size:16px;text-align:center;text-transform:uppercase;border-radius:4px;border-bottom:3px solid #419100;text-shadow: 0 1px 0 #419100;">
							Написать клиенту
						</a>
					</td>
					<td style="padding: 10px 35px;text-align:center;">
						<a href="http://studentsonline.ru/?a=<?= $agent->shortname; ?>"
						   style="display:block;width:220px;margin:0;padding:12px 5px 8px;text-decoration:none;line-height:24px;color:#f6f6f6;background:#63bf00;font-family:'Arial';font-weight:bold;font-size:16px;text-align:center;text-transform:uppercase;border-radius:4px;border-bottom:3px solid #419100;text-shadow: 0 1px 0 #419100;">
							Открыть сайт
						</a>
					</td>
				</tr>
				<tr>
					<td style="padding: 10px 35px;text-align:center;">
						<a href="http://studentsonline.ru/presentation"
						   style="display:block;width:220px;margin:0;padding:12px 5px 8px;text-decoration:none;line-height:24px;color:#f6f6f6;background:#63bf00;font-family:'Arial';font-weight:bold;font-size:16px;text-align:center;text-transform:uppercase;border-radius:4px;border-bottom:3px solid #419100;text-shadow: 0 1px 0 #419100;">
							Скачать презентацию StudentsOnline.ru
						</a>
					</td>
					<td style="padding: 10px 35px;text-align:center;">
						<a href="mailto:pochta@studentsonline.ru"
						   style="display:block;width:220px;margin:0;padding:12px 5px 8px;text-decoration:none;line-height:24px;color:#f6f6f6;background:#63bf00;font-family:'Arial';font-weight:bold;font-size:16px;text-align:center;text-transform:uppercase;border-radius:4px;border-bottom:3px solid #419100;text-shadow: 0 1px 0 #419100;">
							Написать в Онлайн Консалтинг
						</a>
					</td>
				</tr>
			</table>
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