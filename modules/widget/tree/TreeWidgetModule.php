<?php
/**
 * @package modules.widget
 */
class TreeWidgetModule extends PersistentWidgetModule {
	private $oDelegate = null;
	private $bIsOrdered = false;
	
	public function setDelegate($oDelegate) {
		$this->oDelegate = $oDelegate;
	}
	
	public function getDelegate() {
		return $this->oDelegate;
	}
	
	public function setOrdered($bIsOrdered)
	{
	    $this->bIsOrdered = $bIsOrdered;
	}

	public function isOrdered()
	{
	    return $this->bIsOrdered;
	}
	
	public function doWidget() {
		$oListTag = new TagWriter($this->bIsOrdered ? 'ol' : 'ul');
		$oListTag->addToParameter('class', 'ui-tree ui-list');
		$oListTag->setParameter('data-widget-session', $this->sPersistentSessionKey);
		$oListTag->setParameter('data-widget-type', $this->getModuleName());
		return $oListTag->parse();
	}
	
	public function listChildren($mParentData) {
		return $this->oDelegate->listChildren($mParentData);
	}
}