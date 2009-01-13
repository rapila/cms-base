<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'tag_instances' table to 'mini_cms' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    model.map
 */
class TagInstanceMapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.TagInstanceMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('mini_cms');

		$tMap = $this->dbMap->addTable('tag_instances');
		$tMap->setPhpName('TagInstance');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('TAG_ID', 'TagId', 'int' , CreoleTypes::INTEGER, 'tags', 'ID', true, null);

		$tMap->addPrimaryKey('TAGGED_ITEM_ID', 'TaggedItemId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addPrimaryKey('MODEL_NAME', 'ModelName', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addForeignKey('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, 'users', 'ID', false, null);

	} // doBuild()

} // TagInstanceMapBuilder
