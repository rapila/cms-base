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
 * @return updated_at as int (timestamp)
 */
public function getUpdatedAtTimestamp()
{
	return \$this->updated_at;
}
";
	}

}
