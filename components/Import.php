<?php
/**
 * Created by PhpStorm.
 * User: Андрюха
 * Date: 17.05.2015
 * Time: 22:08
 */
namespace app\components;

use app\models\ImportUsers;
use Yii;
use yii\base\Component;
use yii\helpers\VarDumper;

/**
 * Class Import
 * 
 * @property string $outputPath
 * @package app\components
 */
class Import extends Component {

	public $columnsMap = [];

	public $startRow = 1;
	public $delimiter = ',';
	public $lastError, $hash;
	protected $_outputPath;

	protected $_users = [];

	protected $_keeper = [];

	private $_currentRow = 0;

	/**
	 * @param \app\models\Import $file
	 *
	 * @return \app\models\Import
	 */
	public function processFile(\app\models\Import $file) {
		if (($handle = fopen($file->getPath(), "r")) !== FALSE) {
			$file->try += 1;
			$file->status = $file::STATUS_IN_PROCESS;
			$file->save();
			while (($data = fgetcsv($handle, NULL, $this->delimiter)) !== FALSE) {
				$this->_currentRow += 1;
				if ($this->_currentRow < $this->startRow) {
					continue;
				}
				$newUser = $this->processLine($data);
				if ($newUser) {
					$newUser['file_id']       = $file->file_id;
					$newUser['university_id'] = $file->university_id;
					$newUser['structure_id']  = $file->structure_id;
					$newUser['author_id']  = $file->author_id;
					$result = $this->storeTempUser($newUser);
					if (!$result) {
						$this->lastError = "save error";
						$file->status = $file::STATUS_HAS_ERROR;
					};
				} else {
					$file->status = $file::STATUS_HAS_ERROR;
				}
			}
			if($file->status == $file::STATUS_IN_PROCESS) {
				$file->status = $file::STATUS_SUCCESS;
			}
			if($file->save()){

			}
			fclose($handle);
		} else {
			$file->status = $file::STATUS_ERROR;
			$file->save();
		}

		return $file;
	}

	public function keepUser($user) {
		$this->_keeper[] = $user;
	}

	public function getKeeper() {
		return $this->_keeper;
	}

	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	private function processLine($data) {
		$user = [];
		foreach ($this->columnsMap as $key => $column) {
			$value = '';
			try {
				if (is_array($column)) {
					foreach ($column as $c) {
						$value .= mb_convert_encoding($data[$c], 'utf8', mb_detect_encoding($data[$c]));
					}
				} else {
					$value = mb_convert_encoding($data[$column], 'utf8', mb_detect_encoding($data[$column], ['UTF-8', 'Windows-1251']));
				}
				$user[$key] = $value;
			} catch (\Exception $e) {
				return FALSE;
			}
		}

		return $user;
	}

	private function storeTempUser($user) {
		$provider = new ImportUsers();
		$provider->setScenario('insert');
		if ($l = $provider->load($user, '') && $s = $provider->save()) {
			return TRUE;
		}
		print 'load: '. var_dump($l) ."\n";
		print 'save: '. var_dump($s) ."\n";
		print VarDumper::dumpAsString($provider->getErrors());
		return FALSE;
	}

	public function setOutputPath($path) {
		if($alias = Yii::getAlias($path)) {
			$path = $alias;
		}
		if(!is_dir($path)) {
			mkdir($path);
		}
		$this->_outputPath = $path;

		return $this;
	}

	public function getOutputPath()  {
		return $this->_outputPath;
	}
}