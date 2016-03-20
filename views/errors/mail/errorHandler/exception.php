<?php
/* @var $this \yii\web\View */
/* @var $exception \Exception */
/* @var $handler \yii\web\ErrorHandler */

?>
<div class="header" style="background: #f3f3f3;padding: 20px 50px 10px 50px;border-bottom: #ccc 1px solid;"><?
	if ($exception instanceof \yii\base\ErrorException): ?>
		<h1 style="font-size: 30px;color: #e57373;margin: 0 0 10px 0;">
			<span style="color: #e51717;"><?= $handler->htmlEncode($exception->getName()) ?></span>
			&ndash; <?= $handler->addTypeLinks(get_class($exception), 'color: #e57373;') ?>
		</h1>
	<?php else: ?>
		<h1 style="font-size: 30px;color: #e57373;margin-bottom: 30px;"><?php
			if ($exception instanceof \yii\web\HttpException) {
				echo '<span>' . $handler->createHttpStatusLink($exception->statusCode, $handler->htmlEncode($exception->getName()),'color: #e51717;') . '</span>';
				echo ' &ndash; ' . $handler->addTypeLinks(get_class($exception), 'color: #e57373;');
			} else {
				$name = $handler->getExceptionName($exception);
				if ($name !== NULL) {
					echo '<span>' . $handler->htmlEncode($name) . '</span>';
					echo ' &ndash; ' . $handler->addTypeLinks(get_class($exception), 'color: #e57373;');
				} else {
					echo '<span>' . $handler->htmlEncode(get_class($exception)) . '</span>';
				}
			}
			?></h1>
	<?php endif; ?>
	<h2 style="font-size: 20px;line-height: 1.25;font-family: Arial,sans-serif;color: #505050;">
		<?= nl2br($handler->htmlEncode($exception->getMessage())) ?>
	</h2>

	<?php if ($exception instanceof \yii\db\Exception && !empty($exception->errorInfo)) {
		echo '<pre style="margin: 10px 0;overflow-y: scroll;font-family: Courier, monospace;font-size: 14px;">Error Info: ' . print_r($exception->errorInfo, TRUE) . '</pre>';
	} ?>

	<?= $handler->renderPreviousExceptions($exception) ?>
</div>

<div class="call-stack" style="margin-top: 30px;margin-bottom: 40px;">
	<ul style="list-style:none;margin:0;padding:0;">
		<?= $handler->renderCallStackItem($exception->getFile(), $exception->getLine(), NULL, NULL, [], 1) ?>
		<?php for ($i = 0, $trace = $exception->getTrace(), $length = count($trace); $i < $length; ++$i): ?>
			<?= $handler->renderCallStackItem(@$trace[$i]['file'] ?: NULL, @$trace[$i]['line'] ?: NULL,
				@$trace[$i]['class'] ?: NULL, @$trace[$i]['function'] ?: NULL, $trace[$i]['args'], $i + 2) ?>
		<?php endfor; ?>
	</ul>
</div>

<div class="request">
	<div class="code" style="display:block;padding-left:50px;line-height: 20px;font-size: 14px;font-family: Consolas, Courier New, monospace;">
		<?= $handler->renderRequest() ?>
	</div>
</div>

