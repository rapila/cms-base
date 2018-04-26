<?php
require_once('behavior/TimestampableBehavior.php');
class ExtendedTimestampableBehaviour extends TimestampableBehavior {
	public function objectMethods(PHP5ObjectBuilder $builder) {
		$sMethods = parent::objectMethods($builder);
		$sMethods .= "
/**
 * @return created_at as int (timestamp)
 */
public function get".$this->getColumnForParameter('create_column')->getPhpName()."Timestamp()
{
	return (int)\$this->get".$this->getColumnForParameter('create_column')->getPhpName()."('U');
}

/**
 * @return created_at formatted to the current locale
 */
public function get".$this->getColumnForParameter('create_column')->getPhpName()."Formatted(\$sLanguageId = null, \$sFormatString = 'x')
{
	if(\$this->".$this->getColumnForParameter('create_column')->getName()." === null) {
		return null;
	}
	return LocaleUtil::localizeDate(\$this->".$this->getColumnForParameter('create_column')->getName().", \$sLanguageId, \$sFormatString);
}
";
		if($this->withUpdatedAt()) {
			$sMethods .= "
/**
 * @return updated_at as int (timestamp)
 */
public function get".$this->getColumnForParameter('update_column')->getPhpName()."Timestamp()
{
	return (int)\$this->get".$this->getColumnForParameter('update_column')->getPhpName()."('U');
}

/**
 * @return updated_at formatted to the current locale
 */
public function get".$this->getColumnForParameter('update_column')->getPhpName()."Formatted(\$sLanguageId = null, \$sFormatString = 'x')
{
	if(\$this->".$this->getColumnForParameter('update_column')->getName()." === null) {
		return null;
	}
	return LocaleUtil::localizeDate(\$this->".$this->getColumnForParameter('update_column')->getName().", \$sLanguageId, \$sFormatString);
}
";
		}

		return $sMethods;
	}

  public function queryMethods(QueryBuilder $builder) {
		$sMethods = parent::queryMethods($builder);
		if($this->withUpdatedAt()) {
			$sMethods .= '
public function findMostRecentUpdate($bAsTimestamp = false) {
	$oQuery = clone $this;
	$sDate = $oQuery->clearOrderByColumns()->lastUpdatedFirst()->select("'.$this->getColumnForParameter('update_column')->getPhpName().'")->findOne();
	if($sDate === null) {
		return null;
	}
	$oDate = new DateTime($sDate);
	if($bAsTimestamp) {
		return $oDate->getTimestamp();
	}
	return $oDate;
}
';
		}
		return $sMethods;
  }

}
