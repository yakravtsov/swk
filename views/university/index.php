<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create University', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'created',
            'updated',
            'author_id',
            'university_id',
            'name',
            // 'db_host',
            // 'db_port',
            // 'db_user',
            // 'db_pass',
            // 'db_name',
            // 'paid_till',
            // 'tarif',
            // 'status',
            // 'subdomain',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
