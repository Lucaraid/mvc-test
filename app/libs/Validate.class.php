<?php

class Validate
{
	private $_itemname 	= '',
			$_passed 	= false,
			$_errors 	= array(),
			$_db		= null;
	function __construct()
	{
		$this->_db = dbConnector::getInstance();
	}
	public function check($source, $items = array())
	{
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = trim($source[$item]);
				$item = escape($item);

				if ($rule === 'required' && empty($value)) {
					$this->adderror("{$item} is required!");
				} else if (!empty($value)) {
					switch ($rule) {
						case 'min':
							if (strlen($value) < $rule_value) {
								$this->adderror("{$item} must be a minimum of {$rule_value} Characters");
							}
						break;
						case 'max':
							if (strlen($value) > $rule_value) {
								$this->adderror("{$item} must be a maximum of {$rule_value} Characters");
							}
						break;
						case 'matches':
							if ($value != $source[$rule_value]) {
								$this->adderror("{$rule_value} must match {$item}");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if ($check->count()) {
								$this->adderror("{$item} already exists.");
							}
						break;
					}
				}
			}
		}
		if (empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
	}

	private function adderror($error)
	{
		$this->_errors[] = $error;
	}

	public function errors()
	{
		return $this->_errors;
	}

	public function passed()
	{
		return $this->_passed;
	}
}

?>