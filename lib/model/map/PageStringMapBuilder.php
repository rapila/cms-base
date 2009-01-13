<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'page_strings' table to 'mini_cms' DatabaseMap object.
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
class PageStringMapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.PageStringMapBuilder';

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

		$tMap = $this->dbMap->addTable('page_strings');
		$tMap->setPhpName('PageString');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('PAGE_ID', 'PageId', 'int' , CreoleTypes::INTEGER, 'pages', 'ID', true, null);

		$tMap->addForeignPrimaryKey('LANGUAGE_ID', 'LanguageId', 'string' , CreoleTypes::VARCHAR, 'languages', 'ID', true, 3);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('LONG_TITLE', 'LongTitle', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('KEYWORDS', 'Keywords', 'string', CreoleTypes::VARCHAR, false, 255);

	} // doBuild()

} // PageStringMapBuilder
