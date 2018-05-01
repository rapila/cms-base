<?php
/**
 * @package modules.widget
 */
class TreeWidgetModule extends PersistentWidgetModule {
	private $oDelegate = null;

	const JSTREE_VERSION = '3.3.5';

	public function setDelegate($oDelegate) {
		$this->oDelegate = $oDelegate;
	}
	
	public function getDelegate() {
		return $this->oDelegate;
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder == null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->addJavaScriptLibrary('jstree', self::JSTREE_VERSION);
		// TODO: Local override
		$oResourceIncluder->addResource('//cdn.rawgit.com/vakata/jstree/'.self::JSTREE_VERSION.'/dist/themes/default/style.min.css');
		self::includeWidgetResources(false, $oResourceIncluder);
	}
	
	public function doWidget() {
		$oListTag = new TagWriter('div');
		$oListTag->addToParameter('class', 'ui-tree');
		$oListTag->setParameter('data-widget-session', $this->sPersistentSessionKey);
		$oListTag->setParameter('data-widget-type', $this->getModuleName());
		return $oListTag->parse();
	}
	
	public function listChildren($mParentData=null) {
		return $this->oDelegate->listChildren($mParentData);
	}
	
	public function loadItem($mData) {
		return $this->oDelegate->loadItem($mData);
	}
	
	public function moveItem($mFromData, $mParentData, $iPosition) {
		return $this->oDelegate->moveItem($mFromData, $mParentData, $iPosition);
	}
	
	public function getModelName() {
		if(!method_exists($this->oDelegate, 'getModelName')) {
			return null;
		}
		return $this->oDelegate->getModelName();
	}
	
}
