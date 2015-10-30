<?php
/**
 * Created by PhpStorm.
 * User: Андрюха
 * Date: 17.05.2015
 * Time: 22:08
 */
namespace app\components;

use yii\base\Component;

class Import extends Component {

	public $columnsMap = [];

	public $startRow = 1;
	public $delimiter = ',';

	protected $_users = [];

	protected $_keeper = [];

	private $_currentRow = 0;

	public function processFile($file) {
		if (($handle = fopen($file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, NULL, $this->delimiter)) !== FALSE) {
				$this->_currentRow += 1;
				if ($this->_currentRow < $this->startRow) {
					continue;
				}
				$newUser = $this->processLine($data);
				if (empty($newUser)) {
					continue;
				}
				$this->_users[] = $newUser;
			}
			fclose($handle);
		}

		return $this->_users;
	}

	public function queueFile($file) {
		$import = new \app\models\Import();

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
				return false;
			}

		}

		return $user;
	}
}