<?php


/**
 * @package    propel.generator.model
 */
class LanguageObjectQuery extends BaseLanguageObjectQuery {
	// does not work chainging like this
	// public function filterByStringInData($mString, $bOr = true) {
	// 	if(!is_array($mString)) {
	// 		return $this->filterByData("%$mString%", Criteria::LIKE);
	// 	}
	// 	foreach($mString as $i => $sString) {
	// 		if($i > 0) {
	// 			$this->filterByData("%$sString%", Criteria::LIKE)->_or();
	// 		}	else {
	// 			$this->filterByData("%$sString%", Criteria::LIKE);
	// 		}		
	// 	}
	// 	return $this;
	// }
}

