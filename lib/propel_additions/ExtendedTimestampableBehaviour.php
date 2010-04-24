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
	return \$this->created_at;
}

/**
 * @return created_at formatted to the current locale
 */
public function getCreatedAtFormatted()
{
	return LocaleUtil::localizeDate(\$this->created_at);
}

/**
 * @return updated_at as int (timestamp)
 */
public function getUpdatedAtTimestamp()
{
	return \$this->updated_at;
}

/**
 * @return updated_at formatted to the current locale
 */
public function getUpdatedAtFormatted()
{
	return LocaleUtil::localizeDate(\$this->updated_at);
}
";
	}

}
