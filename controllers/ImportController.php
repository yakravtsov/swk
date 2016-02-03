<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
namespace app\commands;

use app\components\Import;
use app\models\Import as ImportModel;
use app\models\ImportUsers;
use app\models\User;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class ImportController extends Controller {

	/**
	 * This command echoes what you have entered as the message.
	 *
	 * @param string $message the message to be echoed.
	 */
	public function actionPrepareUsers() {
		while (TRUE) {
			$waiting = ImportModel::findAll(['status' => ImportModel::STATUS_WAITING]);
			$import  = new Import();
			foreach ($waiting as $file) {
				$result = $import->processFile($file);
			}
			sleep(5);
		}
	}

	public function actionSaveUsers() {
		while (TRUE) {
			$waiting = ImportUsers::findAll(['status' => 0]);
			foreach ($waiting as $tmp) {
				$user = new User();
				$user->load($tmp->toArray());
				$user->save();
			}
			sleep(5);
		}
	}
}
