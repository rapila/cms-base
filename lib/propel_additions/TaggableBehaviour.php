<?php

/**
 * Gives a model class the ability to automatically delete tag instances on delete
 *
 * @package    propel.generator.behavior
 */
class TaggableBehaviour extends Behavior
{
	/**
	 * Add code in ObjectBuilder::preUpdate
	 *
	 * @return    string The code to put at the hook
	 */
	public function postDelete()
	{
		return "TagPeer::deleteTagsForObject(\$this);";
	}

	public function objectMethods($builder)
	{
		return "
/**
 * @return A list of TagInstances (not Tags) which reference this ".$builder->getStubObjectBuilder()->getClassname()."
 */
public function getTags()
{
	return TagPeer::tagInstancesForObject(\$this);
}";
	}
	
	//TODO: filter by tag name (with queryMethods)
}