<?php

/**
 * Gives a model class the ability to automatically delete references on delete
 *
 * @package    propel.generator.behavior
 */
class ReferencingBehaviour extends Behavior
{
	/**
	 * Add code in ObjectBuilder::preUpdate
	 *
	 * @return    string The code to put at the hook
	 */
	public function postDelete()
	{
		return "ReferencePeer::removeReferences(\$this);";
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