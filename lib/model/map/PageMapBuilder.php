<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'pages' table to 'mini_cms' DatabaseMap object.
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
class PageMapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.PageMapBuilder';

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

		$tMap = $this->dbMap->addTable('pages');
		$tMap->setPhpName('Page');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('PARENT_ID', 'ParentId', 'int', CreoleTypes::INTEGER, 'pages', 'ID', false, null);

		$tMap->addColumn('SORT', 'Sort', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('PAGE_TYPE', 'PageType', 'string', CreoleTypes::VARCHAR, false, 15);

		$tMap->addColumn('TEMPLATE_NAME', 'TemplateName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('IS_INACTIVE', 'IsInactive', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('IS_FOLDER', 'IsFolder', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('IS_HIDDEN', 'IsHidden', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('IS_PROTECTED', 'IsProtected', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addForeignKey('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, 'users', 'ID', true, null);

		$tMap->addForeignKey('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, 'users', 'ID', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} // doBuild()

} // PageMapBuilder
