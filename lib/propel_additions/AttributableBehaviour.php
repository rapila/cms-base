<?php

/**
 * Gives a model class the ability to track the rapila users who created/updated the models
 * Uses two additional columns storing the creation and update date
 *
 * @package    propel.generator.behavior
 */
class AttributableBehaviour extends Behavior {
	private $bIsUsersTable = false;
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
		$oUsersTable = $this->getDatabase()->getTable('users');
		$oUsersId = $oUsersTable->getColumn('id');
		$this->bIsUsersTable = $oUsersTable === $this->getTable();
		
		if(!$this->getTable()->containsColumn($this->getParameter('create_column'))) {
			$oCreateColumn = $this->getTable()->addColumn(array(
				'name' => $this->getParameter('create_column'),
				'type' => 'integer'
			));
			if(!$this->bIsUsersTable) {
				$this->addRelation($oCreateColumn, $oUsersTable, $oUsersId);
			}
		}
		
		if(!$this->getTable()->containsColumn($this->getParameter('update_column'))) {
			$oUpdateColumn = $this->getTable()->addColumn(array(
				'name' => $this->getParameter('update_column'),
				'type' => 'integer'
			));
			if(!$this->bIsUsersTable) {
				$this->addRelation($oUpdateColumn, $oUsersTable, $oUsersId);
			}
		}
		$this->getTable()->doNaming();
	}
	
	private function addRelation($oLocalColumn, $oUsersTable, $oUsersId) {
		$oFk = new ForeignKey();
		$oFk->setTable($this->getTable());
		$oFk->setForeignTableCommonName($oUsersTable->getName());
		if(!$oFk->isMatchedByInverseFK()) {
			$oFk->setOnDelete(ForeignKey::SETNULL);
			$oFk->setOnUpdate(null);
			$oFk->addReference($oLocalColumn, $oUsersId);
			$this->getTable()->addForeignKey($oFk);				
		}
	}
	
	/**
	 * Get the setter of one of the columns of the behavior
	 * 
	 * @param string $column One of the behavior colums, 'create_column' or 'update_column'
	 * @return string The related setter, 'setCreatedBy' or 'setUpdatedBy'
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
".($this->bIsUsersTable ? "
	/**
	 * Get the associated User object
	 *
	 * @param     PropelPDO \$con Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByCreatedBy(PropelPDO \$con = null)
	{
		return UserQuery::create()->findPk(\$this->".$this->getParameter('create_column').");
	}
	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO \$con Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByUpdatedBy(PropelPDO \$con = null)
	{
		return UserQuery::create()->findPk(\$this->".$this->getParameter('update_column').");
	}
" : '');
	}
}
