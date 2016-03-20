<?php
/* @var $exception \yii\base\Exception */
/* @var $handler \yii\web\ErrorHandler */
?>
<div class="previous" style="margin: 20px 0;padding-left: 30px;">
    <span class="arrow" style="-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);transform: scale(-1, 1);filter: progid:DXImageTransform.Microsoft.BasicImage(mirror=1);font-size: 26px;position: absolute;margin-top: -3px;margin-left: -30px;color: #e51717;">&crarr;</span>
    <h2 style="font-size: 20px;color: #e57373;margin-bottom: 10px;">
        <span style="color: #e51717;">Caused by:</span>
        <?php $name = $handler->getExceptionName($exception);
            if ($name !== null): ?>
            <span style="color: #e51717;"><?= $handler->htmlEncode($name) ?></span> &ndash;
            <?= $handler->addTypeLinks(get_class($exception),'color: #e57373;') ?>
        <?php else: ?>
            <span style="color: #e51717;"><?= $handler->htmlEncode(get_class($exception)) ?></span>
        <?php endif; ?>
    </h2>
    <h3 style="font-size: 14px;margin: 10px 0;"><?= nl2br($handler->htmlEncode($exception->getMessage())) ?></h3>
    <p style="font-size: 14px;color: #aaa;">in <span class="file"><?= $exception->getFile() ?></span> at line <span class="line"><?= $exception->getLine() ?></span></p>
    <?php if ($exception instanceof \yii\db\Exception && !empty($exception->errorInfo)) {
        echo '<pre style="font-family: Courier, monospace;font-size: 14px;margin: 10px 0;">Error Info: ' . print_r($exception->errorInfo, true) . '</pre>';
    } ?>
    <?= $handler->renderPreviousExceptions($exception) ?>
</div>
