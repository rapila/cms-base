<?php
require_once('behavior/TimestampableBehavior.php');
class ExtendedTimestampableBehaviour extends TimestampableBehavior {
		public function objectMethods($builder)
	{
		$sMethods = parent::objectMethods($builder);
		return "$sMethods
/**
 * @return created_at as int (timestamp)
 */
public function getCreatedAtTimestamp()
{
	return (int)\$this->getCreatedAt('U');
}

/**
 * @return created_at formatted to the current locale
 */
public function getCreatedAtFormatted(\$sLanguageId = null, \$sFormatString = 'x')
{
	if(\$this->created_at === null) {
		return null;
	}
	return LocaleUtil::localizeDate(\$this->created_at, \$sLanguageId, \$sFormatString);
}

/**
 * @return updated_at as int (timestamp)
 */
public function getUpdatedAtTimestamp()
{
	return (int)\$this->getUpdatedAt('U');
}

/**
 * @return updated_at formatted to the current locale
 */
public function getUpdatedAtFormatted(\$sLanguageId = null, \$sFormatString = 'x')
{
	if(\$this->updated_at === null) {
		return null;
	}
	return LocaleUtil::localizeDate(\$this->updated_at, \$sLanguageId, \$sFormatString);
}
";
	}

}
