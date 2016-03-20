<?php

/* @var $file string|null */
use yii\helpers\Html;

/* @var $line integer|null */
/* @var $class string|null */
/* @var $method string|null */
/* @var $index integer */
/* @var $lines string[] */
/* @var $begin integer */
/* @var $end integer */
/* @var $handler \yii\web\ErrorHandler */
$condition = !$handler->isCoreFile($file) || $index === 1;
?>
<li style="margin: 1px 0;padding:0;" class="<?php if ($condition) echo 'application'; ?> call-stack-item"
    data-line="<?= (int) ($line - $begin) ?>">
    <div class="element-wrap" style="padding: 15px 0;background-color: #fafafa;">
        <div class="element" style="display: block;margin: 0 auto;padding: 0 0 0 50px;position: relative;">
            <span class="item-number" style="width: 45px;display: inline-block;"><?= (int) $index ?>.</span>
            <span class="text" style="color: #aaa;<?php if ($condition) echo 'color: #505050;white-space: pre-wrap;'; ?>"><?php if ($file !== null) echo 'in ' . $handler->htmlEncode($file); ?></span>
            <?php if ($method !== null): ?>
                <span class="call">
                    <?php if ($file !== null) echo '&ndash;'; ?>
                    <?= ($class !== null ? $handler->addTypeLinks("$class::$method",'color: #505050;') : $handler->htmlEncode($method)) . '(' . $handler->argumentsToString($args) . ')' ?>
                </span>
            <?php endif; ?>
            <span class="at" style="color: #aaa;"><?php if ($line !== null) echo 'at line'; ?></span>
            <span class="line"><?php if ($line !== null) echo (int) $line + 1; ?></span>
        </div>
    </div>
    <?php if (!empty($lines)): ?>
        <div class="code-wrap" style="position: relative;display:block;">
            <div class="code" style="min-width:910px;margin: 15px auto;position: relative;">
                <?php /*for ($i = $begin; $i <= $end; ++$i): */?><!--<span class="lines-item"><?/*= (int) ($i + 1) */?></span>--><?php /*endfor; */?>
                <pre style="position: relative;z-index: 200;line-height: 20px;font-size: 12px;color:#505050;font-family: Consolas, Courier New, monospace;display: inline;"><?php
                    // fill empty lines with a whitespace to avoid rendering problems in opera
                    for ($i = $begin; $i <= $end; ++$i) {
                        if(trim($lines[$i] == '')){
                            echo " \n";
                        } else {
                            $line_i = $i + 1;
                            $line_i_l = strlen($line_i);
                            $line_c = substr($handler->htmlEncode($lines[$i]),$line_i_l);
                            if($i == intval($line)){
                                echo Html::tag('div',Html::tag('span',$line_i,['style'=>'color:#aaaaaa;']) . " " . $handler->htmlEncode($lines[$i]),['style'=>'padding-left:50px;background:#ffebeb;']);
                            } else {
                                echo Html::tag('div',Html::tag('span',$line_i,['style'=>'color:#aaaaaa;']) . " " . $handler->htmlEncode($lines[$i]),['style'=>'padding-left:50px;']);
                            }
                        }
                    }
                ?></pre>
            </div>
        </div>
    <?php endif; ?>
</li>
