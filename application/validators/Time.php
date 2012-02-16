<?php
class Worksample_Validate_Time extends Zend_Validate_Abstract
{
	const INVALID_TIME = 'InvalidTime';
	
	protected $_messageTemplates = array(
		self::INVALID_TIME => "'%value%' does not appear to be a valid time"
	);
	
	public function isValid($value) {
		$this->_setValue($value);
		
		if(preg_match('/^([0-1]\d|2[0-3]):[0-5]\d$/', $value)) {
			return true;
		} else {
			$this->_error(self::INVALID_TIME);
			return false;
		}
	}
}