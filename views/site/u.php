<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = "Выберите ваш вуз из алфавитного списка";
/* @var $this yii\web\View */
$this->params['hideHeaderLogin'][] = true;
if(Yii::$app->university->model){
    $subdomain = Yii::$app->university->model->subdomain;
    $name = Yii::$app->university->model->name;
} else {
    $subdomain = "";
    $name = "";
}


//$this->title = $name;
?>
<div class="site-u">

    <h4 class="text-center" style="margin-top: 0; font-size: 4em;">Электронное портфолио студента</h4>

    <h2 class="text-center" style="margin: 10px 0;">Выберите ваш вуз из алфавитного списка</h2>

    <div>&nbsp;</div>
    <div class="list-group">
    <?
    foreach($universities as $u){
        //echo Html::a(Html::tag('span',$u['name'],['class'=>'text-left']), "//" . $u['subdomain'] . ".studentsonline.ru",['class'=>'list-group-item']);
        ?><a class='universities-list list-group-item' href='//<?=$u['subdomain']?>.studentsonline.ru'>
        <img class="pull-left" src="/i/university_logos/<?=$u['subdomain']?>.jpg" alt="<?=$u['name']?>" />
        <h4><?=$u['name']?></h4>
        <span class='text-info'><?=$u['subdomain']?>.studentsonline.ru</span>
        <div class="clearfix"></div>
        </a>

        <?
    }
    ?>
    </div>

        <!--<a href="#" class="list-group-item active">
            Cras justo odio
        </a>
        <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
        <a href="#" class="list-group-item">Morbi leo risus</a>
        <a href="#" class="list-group-item">Porta ac consectetur ac</a>
        <a href="#" class="list-group-item">Vestibulum at eros</a>-->

</div>
