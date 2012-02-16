<?php
class Zend_View_Helper_Excerpt extends Zend_View_Helper_Abstract {
	
	public function excerpt($string, $startPosition = 0, $maxLength = 32) {
		if(strlen($string) > $maxLength) {
			$excerpt   = substr($string, $startPosition, $maxLength - 3);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt   = substr($excerpt, 0, $lastSpace);
			$excerpt  .= '...';
			
			return $excerpt;
		}
		
		return $string;
	}
	
}