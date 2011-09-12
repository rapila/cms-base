<?php

/**
 * Gives a model class the ability to automatically delete references on delete
 *
 * @package    propel.generator.behavior
 */
class ReferencingBehaviour extends Behavior
{
	public function staticMethods($oBuilder) {
		$oBuilder->declareClassFromBuilder($oBuilder->getStubQueryBuilder());
		return "public static function doDeleteWithReferencing(\$values, PropelPDO \$con = null) {
		if (\$con === null) {
			\$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if(\$values instanceof Criteria) {
			// rename for clarity
			\$criteria = clone \$values;
		} elseif (\$values instanceof {$this->getTable()->getPhpName()}) { // it's a model object
			// create criteria based on pk values
			\$criteria = \$values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			\$criteria = new Criteria(self::DATABASE_NAME);
			\$criteria->add(PagePeer::ID, (array) \$values, Criteria::IN);
		}
		
		foreach({$this->getTable()->getPhpName()}Peer::doSelect(clone \$criteria, \$con) as \$object) {
			ReferencePeer::removeReferences(\$object);
		}

		return self::doDeleteBeforeReferencing(\$criteria, \$con);
}";
	}

	public function peerFilter(&$sScript) {
		$sScript = str_replace(array(
			'public static function doDelete(', 
			'public static function doDeleteWithReferencing('
		), array(
			'private static function doDeleteBeforeReferencing(',
			'public static function doDelete('
		), $sScript);
	}

	public function objectMethods($builder)
	{
		return "
/**
 * @return A list of References (not Objects) which this ".$builder->getStubObjectBuilder()->getClassname()." references
 */
public function getReferenced()
{
	return ReferencePeer::getReferencesFromObject(\$this);
}";
	}
}
