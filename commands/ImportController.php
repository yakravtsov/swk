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
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\VarDumper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class ImportController extends Controller {

	/** @var Import */
	protected $import;

	public function init() {
		$this->import = Yii::$app->import;
	}


	public function actionIndex() {
	}

	/**
	 * This command echoes what you have entered as the message.
	 *
	 * @param string $message the message to be echoed.
	 */
	public function actionPrepareUsers() {
		while (TRUE) {
			$waiting = ImportModel::findReadyToPrepare();
			$found   = count($waiting);
			echo $this->ansiFormat("Found $found files\n", Console::FG_YELLOW);
			foreach ($waiting as $file) {
				try {
					echo $this->ansiFormat("Preparing file #$file->file_id\n", Console::FG_YELLOW);
					$resultFile  = $this->import->processFile($file);
					$status      = $resultFile->status == $resultFile::STATUS_SUCCESS ? 'successfully' : 'with errors: ' . $this->import->lastError;
					$outputColor = $resultFile->status == $resultFile::STATUS_SUCCESS ? Console::FG_GREEN : Console::FG_RED;
				} catch (\Exception $e) {
					$status       = "with exception: {$e->getMessage()}";
					$outputColor  = Console::FG_RED;
					$file->status = $file::STATUS_ERROR;
					$file->save();
					throw $e;
				}
				echo $this->ansiFormat("File prepared $status\n", $outputColor);
				//				print $resultFile->status
			}
			sleep(5);
		}
	}

	public function actionSaveUsers() {
		while (TRUE) {
			$waiting = ImportUsers::findReadyToProcess();
			$found   = count($waiting);
			echo $this->ansiFormat("Found $found users\n", Console::FG_YELLOW);
			foreach ($waiting as $tmp) {
				try {
					$user = new User();
					$user->setScenario('import');
					$user->password = $this->generatePassword($tmp);
					if ($user->load($tmp->toArray(), '') && $user->save()) {
						$tmp->import_status = $tmp::STATUS_SUCCESS;
					} else {
						$tmp->import_status = $tmp::STATUS_ERROR;
					}
					$status      = $tmp->import_status == $tmp::STATUS_SUCCESS ? 'successfully' : 'with errors: ' . VarDumper::dumpAsString($user->getFirstErrors());
					$outputColor = $tmp->import_status == $tmp::STATUS_SUCCESS ? Console::FG_GREEN : Console::FG_RED;
				} catch (\Exception $e) {
					$status             = "with exception: {$e->getMessage()}";
					$outputColor        = Console::FG_RED;
					$tmp->import_status = $tmp::STATUS_ERROR;
					throw $e;
				}
				$tmp->save();
				$tmp->updateCounters(['try' => 1]);
				echo $this->ansiFormat("User imported $status\n", $outputColor);
			}
			sleep(5);
		}
	}

	public function actionGenerateCsv() {
		while (TRUE) {
			$waiting = ImportModel::findReadyToCsv();
			$found   = count($waiting);
			echo $this->ansiFormat("Found $found ready to csv output files\n", Console::FG_YELLOW);
			foreach ($waiting as $tmp) {
				try {
					$tmp->status = $tmp::STATUS_CSV_IN_PROCESS;
					$tmp->save();
					$tmp->status = $tmp::STATUS_IMPORTED;
					$filename = $this->import->outputPath . DIRECTORY_SEPARATOR . microtime(true) . '.csv';
					$file     = fopen($filename, 'w+');
					if (!$file) {
						throw new Exception('creating csv output file error');;
					}
					$users = $tmp->users;
					foreach ($users as $user) {
						$data = [$user->phio, $user->number, $user->isSuccess() ? $this->generatePassword($user) : 'ошибка'];
						if (!fputcsv($file, $data)) {
							$tmp->status = $tmp::STATUS_OUTPUT_ERROR;
						}
					}
					$status      = $tmp->status != $tmp::STATUS_OUTPUT_ERROR ? 'successfully' : 'with errors: ';
					$outputColor = $tmp->status != $tmp::STATUS_OUTPUT_ERROR ? Console::FG_GREEN : Console::FG_RED;
					fclose($file);
				} catch (\Exception $e) {
					$status      = "with exception: {$e->getMessage()}";
					$outputColor = Console::FG_RED;
					$tmp->status = $tmp::STATUS_OUTPUT_ERROR;
					throw $e;
				}
				$tmp->csv = $filename;
				$tmp->save();
				$tmp->updateCounters(['try' => 1]);
				echo $this->ansiFormat("Users imported to csv $status\n", $outputColor);
			}
			sleep(5);
		}
	}

	/**
	 * @param $tmp
	 *
	 * @return string
	 */
	protected function generatePassword(ImportUsers $tmp) {
		return substr(md5($tmp->password_hash . $this->import->hash), 0, 8);
	}
}
