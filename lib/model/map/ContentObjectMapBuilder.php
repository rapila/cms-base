<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'objects' table to 'mini_cms' DatabaseMap object.
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
class ContentObjectMapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.ContentObjectMapBuilder';

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

		$tMap = $this->dbMap->addTable('objects');
		$tMap->setPhpName('ContentObject');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('PAGE_ID', 'PageId', 'int', CreoleTypes::INTEGER, 'pages', 'ID', true, null);

		$tMap->addColumn('CONTAINER_NAME', 'ContainerName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('OBJECT_TYPE', 'ObjectType', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('CONDITION_SERIALIZED', 'ConditionSerialized', 'string', CreoleTypes::BLOB, false, null);

		$tMap->addColumn('SORT', 'Sort', 'int', CreoleTypes::TINYINT, false, 2);

	} // doBuild()

} // ContentObjectMapBuilder
