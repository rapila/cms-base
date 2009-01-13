<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'rights' table to 'mini_cms' DatabaseMap object.
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
class RightMapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.RightMapBuilder';

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

		$tMap = $this->dbMap->addTable('rights');
		$tMap->setPhpName('Right');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('GROUP_ID', 'GroupId', 'int', CreoleTypes::INTEGER, 'groups', 'ID', true, null);

		$tMap->addForeignKey('PAGE_ID', 'PageId', 'int', CreoleTypes::INTEGER, 'pages', 'ID', true, null);

		$tMap->addColumn('IS_INHERITED', 'IsInherited', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('MAY_EDIT_PAGE_DETAILS', 'MayEditPageDetails', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('MAY_EDIT_PAGE_CONTENTS', 'MayEditPageContents', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('MAY_DELETE', 'MayDelete', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('MAY_CREATE_CHILDREN', 'MayCreateChildren', 'boolean', CreoleTypes::BOOLEAN, false, 1);

		$tMap->addColumn('MAY_VIEW_PAGE', 'MayViewPage', 'boolean', CreoleTypes::BOOLEAN, false, 1);

	} // doBuild()

} // RightMapBuilder
