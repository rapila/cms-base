<?php

/**
 * Gives a model class the ability to track the CMOS users who created/updated the models
 * Uses two additional columns storing the creation and update date
 *
 * @package    propel.generator.behavior
 */
class AttributableBehaviour extends Behavior
{
	// default parameters value
	protected $parameters = array(
		'create_column' => 'created_by',
		'update_column' => 'updated_by'
	);
	
	/**
	 * Add the create_column and update_columns to the current table
	 */
	public function modifyTable()
	{
		
		if(!$this->getTable()->containsColumn($this->getParameter('create_column'))) {
			$oCreateColumn = $this->getTable()->addColumn(array(
				'name' => $this->getParameter('create_column'),
				'type' => 'integer'
			));
			$this->addRelation($oCreateColumn);
		}
		
		if(!$this->getTable()->containsColumn($this->getParameter('update_column'))) {
			$oUpdateColumn = $this->getTable()->addColumn(array(
				'name' => $this->getParameter('update_column'),
				'type' => 'integer'
			));
			$this->addRelation($oUpdateColumn);
		}
	}
	
	private function addRelation($oLocalColumn) {
		$oUsersTable = $this->getDatabase()->getTable('users');
		$oUsersId = $oUsersTable->getColumn('id');
		$oFk = new ForeignKey();
		$oFk->setTable($this->getTable());
		$oFk->setForeignTableName($oUsersTable->getName());
		if(!$oFk->isMatchedByInverseFK() && $oUsersTable !== $this->getTable()) {
			$oFk->setOnDelete(ForeignKey::SETNULL);
			$oFk->setOnUpdate(null);
			$oFk->addReference($oLocalColumn, $oUsersId);
			$this->getTable()->addForeignKey($oFk);				
		}
	}
	
	/**
	 * Get the setter of one of the columns of the behavior
	 * 
	 * @param     string $column One of the behavior colums, 'create_column' or 'update_column'
	 * @return    string The related setter, 'setCreatedOn' or 'setUpdatedOn'
	 */
	protected function getColumnSetter($column)
	{
		return 'set' . $this->getColumnForParameter($column)->getPhpName();
	}
	
	/**
	 * Add code in ObjectBuilder::preUpdate
	 *
	 * @return    string The code to put at the hook
	 */
	public function preUpdate()
	{
		return "
if(Session::getSession()->isAuthenticated()) {
	if (\$this->isModified() && !\$this->isColumnModified(" . $this->getColumnForParameter('update_column')->getConstantName() . ")) {
		\$this->" . $this->getColumnSetter('update_column') . "(Session::getSession()->getUser()->getId());
	}
}";
	}
	
	/**
	 * Add code in ObjectBuilder::preInsert
	 *
	 * @return    string The code to put at the hook
	 */
	public function preInsert()
	{
		return "
if(Session::getSession()->isAuthenticated()) {
	if (!\$this->isColumnModified(" . $this->getColumnForParameter('create_column')->getConstantName() . ")) {
		\$this->" . $this->getColumnSetter('create_column') . "(Session::getSession()->getUser()->getId());
	}
	if (!\$this->isColumnModified(" . $this->getColumnForParameter('update_column')->getConstantName() . ")) {
		\$this->" . $this->getColumnSetter('update_column') . "(Session::getSession()->getUser()->getId());
	}
}
";
	}

	public function objectMethods($builder)
	{
		return "
/**
 * Mark the current object so that the updated user doesn't get updated during next save
 *
 * @return     " . $builder->getStubObjectBuilder()->getClassname() . " The current object (for fluent API support)
 */
public function keepUpdateUserUnchanged()
{
	\$this->modifiedColumns[] = " . $this->getColumnForParameter('update_column')->getConstantName() . ";
	return \$this;
}
";
	}
}