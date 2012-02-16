<?php
class Zend_View_Helper_Csv extends Zend_View_Helper_Abstract
{
	public function csv(array $values, $delimiter = ';', $enclosure = '"', $encloseAll = false, $newLine = "\r\n", $nullToMysqlNull = false) {
		$result = array();
		
		foreach($values as $fields) {
			$delimiter_esc = preg_quote($delimiter, '/');
			$enclosure_esc = preg_quote($enclosure, '/');
			
			$output = array();
			foreach ( $fields as $field ) {
				if ($field === null && $nullToMysqlNull) {
					$output[] = 'NULL';
				continue;
			}
			
			// Enclose fields containing $delimiter, $enclosure or whitespace
			if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
					$output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
				}
				else {
					$output[] = $field;
				}
			}
			
			$result[] = implode( $delimiter, $output );
		}

		return implode($newLine, $result);
	}
}