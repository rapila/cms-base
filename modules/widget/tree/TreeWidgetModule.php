<?php
/**
 * @package modules.widget
 */
class TreeWidgetModule extends PersistentWidgetModule {
	private $oDelegate = null;
	
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
		// $oResourceIncluder->addResource('widget/jquery.ndd.js');
		$oResourceIncluder->addResource('widget/jsTree/jquery.jstree.js');
		$oResourceIncluder->addResource('widget/jsTree/jquery.jstree.tree_widget_plugin.js');
		self::includeWidgetResources(false, $oResourceIncluder);
	}
	
	public function doWidget() {
		$oListTag = new TagWriter('div');
		$oListTag->addToParameter('class', 'widget-tree');
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
	
	public function moveItem($mFromData, $mToData, $sPosition) {
		return $this->oDelegate->moveItem($mFromData, $mToData, $sPosition);
	}
	
}
