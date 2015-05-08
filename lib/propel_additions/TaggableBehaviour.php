<?php

/**
 * Gives a model class the ability to automatically delete tag instances on delete
 *
 * @package    propel.generator.behavior
 */
class TaggableBehaviour extends Behavior
{
	protected $parameters = array(
		'tag_model' => 'Tag', //The name of the model to save tags in.
		'tag_instance_model' => '', //The name of the model to save instances in. Using '' defaults to '«tag_model»Instance'
	);

	public function getParameter($sName) {
		$sParam = parent::getParameter($sName);
		if($sName === 'tag_instance_model' && $sParam === '') {
			$sParam = parent::getParameter('tag_model').'Instance';
		}
		return $sParam;
	}

	public function staticMethods($oBuilder) {
		$oBuilder->declareClassFromBuilder($oBuilder->getStubQueryBuilder());
		return "public static function doDeleteWithTaggable(\$values, PropelPDO \$con = null) {
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
			TagPeer::deleteTagsForObject(\$object);
		}

		return self::doDeleteBeforeTaggable(\$criteria, \$con);
}";
	}

	public function peerFilter(&$sScript) {
		$sScript = str_replace(array(
			'public static function doDelete(',
			'public static function doDeleteWithTaggable('
		), array(
			'private static function doDeleteBeforeTaggable(',
			'public static function doDelete('
		), $sScript);
	}

	public function objectMethods($oBuilder) {
		$sMethods = '';
		// Instance methods
		$sMethods .= $this->addAddTag($oBuilder);
		$sMethods .= $this->addRemoveTag($oBuilder);
		$sMethods .= $this->addRemoveAllTags($oBuilder);
		$sMethods .= $this->addTags($oBuilder);
		$sMethods .= $this->addDeprecatedGetTags($oBuilder);
		// Static methods
		$sMethods .= $this->addAddTagTo($oBuilder);
		$sMethods .= $this->addRemoveTagFrom($oBuilder);
		$sMethods .= $this->addRemoveAllTagsFrom($oBuilder);
		$sMethods .= $this->addTagsFor($oBuilder);
		// Constants
		$sMethods .= $this->addConstants($oBuilder);
		return $sMethods;
	}

	public function addAddTag($builder)
	{
		return "
/**
 * Add a tag to the current ".$builder->getStubObjectBuilder()->getClassname()."
 */
public function addTag(\$mTag)
{
	return self::addTagTo(\$this->getPKString(), \$mTag);
}";
	}

	public function addRemoveTag($builder)
	{
		return "
/**
 * Remove tag from the current ".$builder->getStubObjectBuilder()->getClassname()."
 */
public function removeTag(\$mTag)
{
	return self::removeTagFrom(\$this->getPKString(), \$mTag);
}";
	}

	public function addRemoveAllTags($builder)
	{
		return "
/**
 * Remove all tags from the current ".$builder->getStubObjectBuilder()->getClassname()."
 */
public function removeAllTags()
{
	return self::removeAllTagsFrom(\$this->getPKString());
}";
	}

	public function addTags($builder)
	{
		return "
/**
 * @return All tags for the current ".$builder->getStubObjectBuilder()->getClassname()."
 */
public function tags(\$sReturn = 'tag')
{
	return self::tagsFor(\$this->getPKString(), \$sReturn);
}";
	}

	public function addDeprecatedGetTags($builder)
	{
		return "
/**
 * @return A list of TagInstances (not Tags) which reference this ".$builder->getStubObjectBuilder()->getClassname()."
 * @deprecated Use ->tags('instances')
 */
public function getTags()
{
	return \$this->tags('instances');
}";
	}

	public function addAddTagTo($builder)
	{
		$sTagClass = $this->getParameter('tag_model');
		$sInstanceClass = $this->getParameter('tag_instance_model');
		$sClass = $builder->getStubObjectBuilder()->getClassname();
		return "
/**
 * Add a tag to the ${sClass} given by the id
 */
public static function addTagTo(\$s${sClass}Id, \$mTag)
{
	if(\$mTag instanceof $sInstanceClass) {
		\$mTag = \$mTag->get$sTagClass();
	}
	if(\$mTag instanceof $sTagClass) {
		\$mTag = \$mTag->getName();
	}
	\$sTagName = StringUtil::normalize(\$mTag);
	\$oTag = ${sTagClass}Query::create()->findOneByName(\$sTagName);
	if(\$oTag === null) {
		\$oTag = new $sTagClass();
		\$oTag->setName(\$sTagName);
		\$oTag->save();
	}
	\$oTagInstance = ${sInstanceClass}Query::create()->findPk(array(\$oTag->getId(), \$s${sClass}Id, \"$sClass\"));
	if(\$oTagInstance !== null) {
		return \$oTagInstance;
	}
	\$oTagInstance = new $sInstanceClass();
	\$oTagInstance->set${sTagClass}(\$oTag);
	\$oTagInstance->setModelName(\"$sClass\");
	\$oTagInstance->setTaggedItemId(\$s${sClass}Id);
	\$oTagInstance->save();
	return \$oTagInstance;
}";
	}

	public function addRemoveTagFrom($builder)
	{
		$sTagClass = $this->getParameter('tag_model');
		$sInstanceClass = $this->getParameter('tag_instance_model');
		$sClass = $builder->getStubObjectBuilder()->getClassname();
		return "
/**
 * Remove tag from the ${sClass} given by the id
 */
public static function removeTagFrom(\$s${sClass}Id, \$mTag)
{
	if(is_string(\$mTag)) {
		\$mTag = ${sTagClass}Query::create()->findOneByName(\$mTag);
	}
	if(\$mTag instanceof $sInstanceClass) {
		\$mTag = \$mTag->get$sTagClass();
	}
	if(!(\$mTag instanceof $sTagClass)) {
		return;
	}
	\$oQuery = ${sInstanceClass}Query::create();
	\$oQuery->filterByTaggedItemId(\$s${sClass}Id);
	\$oQuery->filterByModelName(\"$sClass\");
	\$oQuery->filterByTag(\$mTag);
	\$oTagInstance = \$oQuery->findOne();
	if(\$oTagInstance) {
		\$oTagInstance->delete();
	}
}";
	}

	public function addRemoveAllTagsFrom($builder)
	{
		$sTagClass = $this->getParameter('tag_model');
		$sInstanceClass = $this->getParameter('tag_instance_model');
		$sClass = $builder->getStubObjectBuilder()->getClassname();
		return "
/**
 * Remove all tags from the ${sClass} given by the id
 */
public static function removeAllTagsFrom(\$s${sClass}Id)
{
	\$aTagInstances = self::tagsFor(\$s${sClass}Id, 'instances');
	foreach(\$aTagInstances as \$oTagInstance) {
		\$oTagInstance->delete();
	}
	return count(\$aTagInstances);
}";
	}

	public function addTagsFor($builder)
	{
		$sTagClass = $this->getParameter('tag_model');
		$sInstanceClass = $this->getParameter('tag_instance_model');
		$sClass = $builder->getStubObjectBuilder()->getClassname();
		return "
/**
 * @return All tags for the ${sClass} given by the id
 */
public static function tagsFor(\$s${sClass}Id = null, \$sReturn = 'tag')
{
	\$oQuery = ${sInstanceClass}Query::create();
	if(\$s${sClass}Id !== null) {
		\$oQuery->filterByTaggedItemId(\$s${sClass}Id);
	}
	\$oQuery->filterByModelName(\"$sClass\");
	if(\$sReturn === 'count') {
		return \$oQuery->find()->count();
	}
	\$aTagInstances = \$oQuery->find()->getArrayCopy();
	if(\$sReturn === 'instances') {
		return \$aTagInstances;
	}
	if(\$sReturn === 'tags') {
		return array_map(function(\$oTagInstance) {
			return \$oTagInstance->get$sTagClass();
		}, \$aTagInstances);
	}
	return array_map(function(\$oTagInstance) {
		return \$oTagInstance->get$sTagClass()->getName();
	}, \$aTagInstances);
}";
	}
	
	public function addConstants($builder) {
		$sTagClass = $this->getParameter('tag_model');
		$sInstanceClass = $this->getParameter('tag_instance_model');
		return "
const TAG_MODEL_NAME = '$sTagClass';
const TAG_INSTANCE_MODEL_NAME = '$sInstanceClass';
";
	}

	//TODO: filter by tag name (with queryMethods)
}
