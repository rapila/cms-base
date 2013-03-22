<?php
class ExtendedKeyableBehaviour extends Behavior {
	protected $parameters = array(
		'key_separator' => '_' //How a composite primary key’s parts are separated when serializing the key as a string
	);

	public function objectMethods($builder) {
		if($this->getTable()->hasCompositePrimaryKey()) {
			return $this->objectMethodsComposite($builder);
		} else {
			return $this->objectMethodsSingle($builder);
		}
	}

  public function queryMethods($builder) {
		if($this->getTable()->hasCompositePrimaryKey()) {
			return $this->queryMethodsComposite($builder);
		} else {
			return $this->queryMethodsSingle($builder);
		}
  }

	public function objectMethodsComposite($builder) {
		return '
/**
 * @return the primary key as an array (even for non-composite keys)
 */
public function getPKArray()
{
	return $this->getPrimaryKey();
}

/**
 * @return the primary key as a string
 */
public function getPKString()
{
	return implode("'.addslashes($this->getParameter('key_separator')).'", $this->getPKArray());
}
';
	}

  public function queryMethodsComposite($builder) {
		return '
public function filterByPKArray($pkArray) {
	return $this->filterByPrimaryKey($pkArray);
}

public function filterByPKString($pkString) {
	return $this->filterByPrimaryKey(explode("'.addslashes($this->getParameter('key_separator')).'", $pkString));
}
';
  }

	public function objectMethodsSingle($builder) {
		return '
/**
 * @return the primary key as an array (even for non-composite keys)
 */
public function getPKArray()
{
	return array($this->getPrimaryKey());
}

/**
 * @return the composite primary key as a string, separated by '.$this->getParameter('key_separator').'
 */
public function getPKString()
{
	return implode("", $this->getPKArray());
}
';
	}

  public function queryMethodsSingle($builder) {
		return '
public function filterByPKArray($pkArray) {
		return $this->filterByPrimaryKey($pkArray[0]);
}

public function filterByPKString($pkString) {
	return $this->filterByPrimaryKey($pkString);
}
';
  }
}
