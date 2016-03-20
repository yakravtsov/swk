<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\User;
use app\models\StudentWorks;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Json;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWorks */

$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;
//$role_id == User::ROLE_TEACHER || $role_id == User::ROLE_ADMINISTRATOR || $role_id == User::ROLE_GOD;
$roles = [User::ROLE_TEACHER,User::ROLE_ADMINISTRATOR,User::ROLE_GOD];

$this->title = $model->title;
if ($role_id == User::ROLE_GUEST) {
    $this->params['breadcrumbs'][] = ['label' => 'Записи'];
} else {
    if ($role_id == User::ROLE_STUDENT) {
        $this->params['breadcrumbs'][] = ['label' => 'Записи'];
    } else {
        $this->params['breadcrumbs'][] = ['label' => 'Записи', 'url' => ['index']];
    }
}
$this->params['breadcrumbs'][] = ['label' => $model->author->phio,
    //'url'   => ['studentworks', 'id' => $model->author_id]];
    'url' => ['users/view', 'id' => $model->author_id]];
$this->params['breadcrumbs'][] = 'Просмотр записи';
if ($role_id == User::ROLE_STUDENT) {

    $access_url = Url::to(array_merge([Yii::$app->request->getPathInfo()], Yii::$app->request->getQueryParams(), ['access_code' => md5(Url::current() . Yii::$app->user->identity->login_hash)]));
    //echo "<div><a href='{$access_url}'>Ссылка доступа</a></div>";
}

$teacherIsEmpty = empty($teacher);

?>
<div class="student-works-view">

    <h1><?= $model->title ?></h1>
    <?

    if (Yii::$app->user->id == $model->author_id || $role_id == User::ROLE_ADMINISTRATOR) {

        echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model->work_id], ['class' => 'btn btn-primary'])
            . " " .
            Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete', 'id' => $model->work_id], ['class' => 'btn btn-danger',
                'data' => ['confirm' => 'Вы уверены, что хотите удалить эту запись?',
                    'method' => 'post',]]);

    }

    ?>


    <?
    $all_files = '';
    foreach ($initialPreview as $file) {
        $all_files .= $file . "<br>";
    }
    ?>


    <?
    if (in_array($role_id,$roles)) {
        Modal::begin([
            'header' => '<h2>Оценка и рецензирование</h2>',
            'toggleButton' => ['label' => '<i class="glyphicon glyphicon-pencil"></i> Оценить и написать рецензию','class'=>'btn btn-primary'],
            'size' => Modal::SIZE_LARGE
        ]);

        echo $review;

        Modal::end();
    } ?>

    <div>&nbsp;</div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' =>
            [
                //'created',
                //'updated',
                [
                    'attribute' => 'author_id',
                    'value' => Html::a($model->author->phio, ['studentworks', 'id' => $model->author_id]),
                    'format' => 'html',
                ],
                //'filename',
                ['attribute' => 'discipline_id',
                    'value' => $model->disciplineLabel,
                    'format' => 'html',],
                //'student_id',
                'mark',
                ['attribute' => 'status',
                    'value' => Html::tag('span', $model->statusLabel, ['class' => 'label label-' . $model->statusClass]),
                    'format' => 'html',
                ],
                [
                    'label' => 'Прикреплённые файлы',
                    'value' => $all_files,
                    'format' => 'raw'
                ]
            ],
    ]); ?>

    <div>&nbsp;</div>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= $model->comment ?>
        </div>
    </div>

</div>
