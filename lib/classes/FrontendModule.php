<?php
abstract class FrontendModule extends Module {
	protected static $MODULE_TYPE = 'frontend';
	
	protected $oLanguageObject;
	protected $oData;
	protected $aPath;
	protected $iId;
	
	public function __construct($oLanguageObject = null, $aPath = null, $iId = 1) {
		if($oLanguageObject instanceof LanguageObject || $oLanguageObject instanceof LanguageObjectHistory) {
			$this->oLanguageObject = $oLanguageObject;
		} else {
			$this->oData = $oLanguageObject;
		}
		$this->aPath = $aPath;
		$this->iId = $iId;
	}

	public abstract function renderFrontend();

	/**
	* Override this method to transform the data sent from your config widget into a string/blob that can be stored in the database.
	*/
	public function getSaveData($aData) {
		return serialize($aData);
	}

	/**
	* Do the reverse transformation of getSaveData: from string/blob into a configuration value that can be used by the config widget.
	*/
	public function widgetData() {
		$sData = $this->getData();
		if($sData) {
			return unserialize($sData);
		}
		return null;
	}

	/**
	* @deprecated Use the ResourceIncluder to include CSS resource files
	*/
	public function getCssForFrontend() {
		return null;
	}

	/**
	* @deprecated Use the ResourceIncluder to include JS resource files
	*/
	public function getJsForFrontend() {
		return null;
	}

	/**
	* Return a form (as string or Template) to be serialized on saving in either admin or preview contexts. Use getWidget instead if you wish to provide more interactive configuration options.
	*/
	public function renderBackend() {
		return null;
	}
	
	/**
	* Returns the widget used to configure this particular frontend module. Default implementation outputs the contents of renderBackend as form and serializes that on save. If renderBackend returns a falsish value, the default widget is the one that’s named the same as this frontend module plus a suffix of “_frontend_config” and whose constructor, in addition to the session key, takes but one argument: the frontend module instance $this.
	*/
	public function getWidget() {
		$oBackend = $this->renderBackend();
		if($oBackend) {
			return WidgetModule::getWidget("generic_frontend_module", null, $this, $this->renderBackend());
		}
		return WidgetModule::getWidget($this->getModuleName().'_frontend_config', null, $this);
	}
	
	/**
	* Returns the words for which this module should be listed in the site’s search index
	*/
	public function getWords() {
		return StringUtil::getWords($this->renderFrontend(), true);
	}
	
	/**
	* Convenience constructTemplate that can be used without any arguments, yielding 'main' as the template’s name.
	*/
	protected function constructTemplate($sTemplateName = "main", $bUseGlobalTemplatesDir = false) {
		return self::constructTemplateForModuleAndType($this->getType(), $this->getModuleName(), $sTemplateName, $bUseGlobalTemplatesDir);
	}
	
	/**
	* Gets the raw form of the data currently associated with this frontendmodule instance. Use widgetData for the transformed data.
	*/
	protected final function getData() {
		if($this->oLanguageObject !== null && $this->oLanguageObject->getData() !== null) {
			return stream_get_contents($this->oLanguageObject->getData(), -1, 0);
		}
		return $this->oData;
	}
	
	public static function listContentModules($bIncludeEmpty = false) {
		$aResult = array();
		$aModules = self::listModules();
		// list modules except empty [if there is no inherit=true] and tag [if none exist]
		foreach($aModules as $sModuleName => $aModulePath) {
			if(!$bIncludeEmpty && $sModuleName === 'empty'
			|| ($sModuleName === 'tag' && TagPeer::doCount(new Criteria()) == 0)) {
				continue;
			}
			$sClassName = self::getClassNameByName($sModuleName);
			$aResult[$sModuleName] = self::getDisplayNameByName($sModuleName);
		}
		asort($aResult);
		return $aResult;
	}
	
	protected function getModuleSetting($sName, $sDefaultValue) {
		return Settings::getSetting($this->getModuleName(), $sName, $sDefaultValue, 'modules');
	}
	
	public static function getDirectoryForModule($sModuleName) {
		$aModules = FrontendModule::listModules();
		$sPath = $aModules[$sModuleName];
		return $sPath;
	}
	
	public static function getConfigDirectoryForModule($sModuleName) {
		return self::getDirectoryForModule($sModuleName)."/config";
	}
	
	public static function isDynamic() {
		return false;
	}
	
	public function getLanguageObject() {
		return $this->oLanguageObject;
	}
	
	/**
	 * @param LanguageObject $oLanguageObject The language object with the data whose content info you want
	 * description: should return some helpful information in page_detail filled_module, displaying filtered unserialized language object data
	 * mainly for custom modules with options
	 * @return string|Template|null Something that describes the content, preferably text-only
 */
	public static function getContentInfo($oLanguageObject) {
		if(!$oLanguageObject) {
			return null;
		}
		$mData = @unserialize(stream_get_contents($oLanguageObject->getData()));
		if(!$mData) {
			return null;
		}
		return var_export($mData, true);
	}

	public function __sleep() {
		if($this->oLanguageObject !== null) {
			$this->oLanguageObject = $this->oLanguageObject->getId();
		}
		return array_keys(get_object_vars($this));
	}
	
	public function __wakeup() {
		if($this->oLanguageObject !== null) {
			$sId = explode('_', $this->oLanguageObject);
			$sClass = 'LanguageObject';
			if(count($sId) === 3) {
				$sClass .= 'History';
			}
			$this->oLanguageObject = call_user_func_array(array("{$sClass}Peer", 'retrieveByPK'), $sId);
			if($this->oLanguageObject === null) {
				$this->oLanguageObject = new $sClass();
				$this->oLanguageObject->setObjectId($sId[0]);
				$this->oLanguageObject->setLanguageId($sId[1]);
				if(isset($sId[2])) {
					$this->oLanguageObject->setRevision($sId[2]);
				}
			}
		}
	}

}
