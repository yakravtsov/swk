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
				$newUser = [];
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
					} catch (\Exception $e) {
						continue;
					}
					if (empty($value)) {
						continue;
					}
					$newUser[$key] = $value;
				}
				if (empty($newUser)) {
					continue;
				}
				$this->_users[] = $newUser;
			}
			fclose($handle);

			return $this->_users;
		}
	}

	public function keepUser($user) {
		$this->_keeper[] = $user;
	}

	public function getKeeper() {
		return $this->_keeper;
	}
}