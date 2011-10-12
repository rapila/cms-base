<?php

/**
 * Gives a model class the ability to prevent deletion if references exist
 *
 * @package    propel.generator.behavior
 */
class ReferenceableBehaviour extends Behavior
{
	/**
	 * Add code in ObjectBuilder::preUpdate
	 *
	 * @return    string The code to put at the hook
	 */
	public function preDelete()
	{
		return 'if(ReferencePeer::hasReference($this)) {
	throw new PropelException("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
}';
	}

	public function objectMethods($builder)
	{
		return "
/**
 * @return A list of References (not Objects) which reference this ".$builder->getStubObjectBuilder()->getClassname()."
 */
public function getReferees()
{
	return ReferencePeer::getReferences(\$this);
}";
	}
}
