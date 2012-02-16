<?php
require_once 'Zend/Uri.php';

class Worksample_Validate_Url extends Zend_Validate_Abstract
{
	const NOT_URI = 'Not uri';
	
	protected $_messageTemplates = array(
		self::NOT_URI => "'%value%' is not a valid url"
	);
	
	public function isValid($value) {
		$this->_setValue($value);
		
		if(Zend_Uri_Http::check($value) === false) {
			$this->_error(self::NOT_URI);
			
			return false;
		}
		
		return true;
	}
}