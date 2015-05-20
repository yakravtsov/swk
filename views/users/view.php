<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\grid\GridView;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$role_id = Yii::$app->user->isGuest ? User::ROLE_GUEST : Yii::$app->user->identity->role_id;

$this->title = $model->phio;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <h1><?= $model->phio; ?></h1>
    <h5><?= $model->roleLabel; ?>, <?= $model->structure['name']; ?></h5>

    <div>&nbsp;</div>

    <? if ($role_id == User::ROLE_ADMINISTRATOR) { ?>
        <p>
            <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update',
                'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']) . ' Удалить', ['delete',
                'id' => $model->user_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>


        <?
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'email:email',
                [
                    'attribute' => 'author.phio',
                    'label' => 'Автор',
                    'value' => Html::a($model->getAuthor()['phio'], ['view',
                        'id' => $model->getAuthor()['user_id']], ['target' => '_blank',
                        'title' => 'Откроется в новом окне']),
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'created',
                    'value' => Yii::$app->formatter->asDatetime($model->created, "php:d M Y, H:i:s")
                ],
                [
                    'attribute' => 'updated',
                    'value' => Yii::$app->formatter->asDatetime($model->updated, "php:d M Y, H:i:s")
                ],
                //'last_login',
                [
                    'attribute' => 'status',
                    'value' => $model->getStatusLabel()
                ],
                'password_reset_token',
                'password_hash',
                'login_hash',
                //'auth_key',
            ],
        ]);
    } else { ?>

        <? if ($role_id == User::ROLE_STUDENT && Yii::$app->user->identity->email == '') { ?>

            <?
            Modal::begin([
                'header' => '<h2>Для вашей учётной записи не указан email</h2>',
                'id' => 'emailModal',
                'size' => 'modal-lg'
                //'toggleButton' => ['label' => 'click me'],
            ]);


            ?>
            <p class="alert alert-warning">
                Введите свой email в поле ниже и нажмите «Сохранить».<br />
                Без email вы не сможете прикреплять файлы к своим записям, а также восстанавливать забытый
                пароль.
            </p>



                <?php $form = ActiveForm::begin(['action' => ['/users/update?id=' . Yii::$app->user->identity->id],
                    'layout' => 'horizontal',
                ]); ?>


                <?/*= $form->field($model, 'email')->textInput()->label(false); */?>

                <div class="row">
                <?= $form->field($model, 'email', [
                    'horizontalCssClasses' => [
                        'wrapper' => 'col-sm-8',
                        //'offset' => 'col-sm-6'
                    ],
                    'inputTemplate' => '<div class="col-sm-6">{input}</div>' .
                        Html::submitButton(Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']) . ' Сохранить', ['class' => 'btn btn-success',])
                    ,
                ])->label(false) ?>
                </div>

                <!--<div class="form-group">

                </div>-->

                <?php ActiveForm::end(); ?>


            <?

            Modal::end();
            ?>

            <script type="text/javascript">
                $(document).ready(function(){
                    jQuery('#emailModal').modal('show');
                });
            </script>

        <? } ?>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <a href="#" class="btn btn-link navbar-btn"><i class="glyphicon glyphicon-user"></i> Общая
                    информация</a>
                <?
                if ($role_id == User::ROLE_STUDENT) {
                    echo Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-pencil']) . ' Редактировать', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary btn-sm navbar-btn']) ?>
                <?
                }
                ?>
                <div class="pull-right">
                    <p class="navbar-text"><strong>Вид деятельности:</strong></p>
                    <ul class="nav navbar-nav">

                        <?
                        foreach ($disciplines as $key => $d) {
                            ?>
                            <li class="">
                                <a href="/works/studentworks?id=<?= $model->user_id ?>&discipline_id=<?= $key ?>"
                                   class="">
                                    <?= $d ?>
                                </a>
                            </li>
                        <?
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div>&nbsp;</div>



        <div class="panel panel-default">
            <div class="panel-body">
                <?= $model->about ?>
            </div>
        </div>




        <?/*= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel'  => $searchModel,
			'columns'      => [
				['class' => 'yii\grid\SerialColumn'],
				//'updated',
				//'author_id',
				[
					'attribute' => 'title',
					//'label'     => 'Текст работы',
					'value'     => function ($data) {
						return Html::a($data['title'], ['/works/view', 'id' => $data['work_id']], ['target' => '_blank', 'title' => 'Откроется в новом окне']);
					},
					'format'    => 'raw'
				],
				/*[
					'attribute' => 'comment',
					//'label'     => 'Текст работы',
					'value'     => function($data){
						return mb_substr($data['comment'],0,200,"UTF-8");
					},
					'format'    => 'raw'
				],
				//'work_id',
				//'filename',
				// 'type',
				// 'mark',
				// 'comment:ntext',
				// 'discipline_id',
				[
					'attribute' => 'discipline_id',
					'value'     => function ($data) {
						return $data->disciplineLabel;
					},
					//'contentOptions' => ['style'=>'text-align: center'],
					'format'    => 'html',
					'filter'    => $disciplines
				],
				// 'student_id',
				//'status',
				[
					'attribute' => 'status',
					'value'     => function ($data) {
						return Html::tag('span', $data->statusLabel, ['class' => 'label label-' . $data->statusClass]);
					},
					//'contentOptions' => ['style'=>'text-align: center'],
					'format'    => 'html',
					'filter'    => $statuses
				],
				//'created',
				/*[
					'attribute' => 'created',
					'value'     => function ($data) {
						return Yii::$app->formatter->asDatetime($data['created'], "php:d M Y");
					}
				],
			],
		]);
*/
    }
    ?>

    <? //  print_r($model->structure) ?>


</div>
