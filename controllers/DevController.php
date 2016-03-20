<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 09.02.2016
 * Time: 3:29
 * All rights are reserved
 */
namespace app\controllers;
use app\components\CustomAccessRule;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DevController extends Controller {

	public function behaviors() {
		return [
			'access' => [
				'class'        => AccessControl::className(),
				'ruleConfig'   => [
					'class' => CustomAccessRule::className()
				],
				'rules'        => [
					[
						'allow'   => TRUE,
						'roles'   => ['god'],
					],

				],
				'denyCallback' => function ($rule, $action) {
					return $this->redirect('/');
				}
			],
		];
	}

	public function actionMail() {
		return Yii::$app->mailer->compose()
		               ->setTo('dostoevskiy.spb@gmail.com')
		               ->setFrom(['postmaster@studentsonline.ru' => 'Info'])
		               ->setSubject('Паха, салют')
		               ->setTextBody('Раз два, раз два')
		               ->send();
	}

	public function actionError() {
		//sadas
	}
}