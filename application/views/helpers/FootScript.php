<?php
class Zend_View_Helper_FootScript extends Zend_View_Helper_HeadScript {
	
	protected $_regKey = 'Zend_View_Helper_FootScript';
	
	public function footScript($mode = Zend_View_Helper_FootScript::FILE, $spec = null, $placement = 'APPEND', array $attrs = array(), $type = 'text/javascript') {
		return $this->headScript($mode, $spec, $placement, $attrs, $type);
	}
	
}