<?php
abstract class WidgetModule extends Module {
	
	const USE_NAMESPACED_CSS = true;
	
	const WIDGET_SESSION_KEY = 'widget_storage';
	
	protected static $MODULE_TYPE = 'widget';
	
	protected $sPersistentSessionKey = null;
	protected $sInputName = null;
	private $bIsNew = false;
	protected $aInitialSettings = array();
	
	public function doWidget() {
		$oElement = $this->getElementType();
		if($oElement === null) {
			return null;
		}
		if(!$oElement instanceof TagWriter) {
			$oElement = new TagWriter($oElement);
		}
		$oElement->setParameter('data-widget-type', $this->getModuleName());
		$oElement->setParameter('data-widget-session', $this->sPersistentSessionKey);
		if($this->sInputName !== null) {
			$oElement->setParameter('name', $this->sInputName);
		}
		return $oElement->parse();
	}
	
	public static function includeResources($oResourceIncluder = null) {
		self::includeWidgetResources(false, $oResourceIncluder);
	}
	
	protected static function includeWidgetResources($bEndDependenciesOnJS = false, $oResourceIncluder = null) {
		TemplateResourceFileModule::includeAvailableResources(get_called_class(), $bEndDependenciesOnJS, $oResourceIncluder);
	}
	
	public static function isPersistent() {
		return false;
	}
	
	public static function needsLogin() {
		return true;
	}
	
	public function setNew($bIsNew = true) {
		$this->bIsNew = $bIsNew;
	}
	
	public function isNew() {
		return $this->bIsNew;
	}
	
	public function setInputName($sInputName) {
		$this->sInputName = $sInputName;
	}
	
	public function getElementType() {
		return $this->sInputName === null ? 'div' : 'input';
	}

	public function getInputName() {
		return $this->sInputName;
	}
	
	public function getSessionKey() {
		return $this->sPersistentSessionKey;
	}
	
	public function setSetting($sSettingName, $mSettingValue) {
		$this->aInitialSettings[$sSettingName] = $mSettingValue;
	}
	
	public function allSettings() {
		return $this->aInitialSettings;
	}

	public static function getCustomMethods($sClassName) {
		$aMethods = array();
		$aStaticMethods = array();
		$oSuperClass = new ReflectionClass(get_class());
		$oClass = new ReflectionClass($sClassName);
		foreach($oClass->getMethods(ReflectionMethod::IS_PUBLIC) as $oMethod) {
			if(StringUtil::startsWith($oMethod->getName(), '__')) {
				continue;
			}
			if($oSuperClass->hasMethod($oMethod->getName())) {
				continue;
			}
			if($oMethod->isStatic()) {
				$aStaticMethods[] = $oMethod->getName();
			} else {
				$aMethods[] = $oMethod->getName();
			}
		}
		$aMethods[] = 'getInputName';
		$aMethods[] = 'setInputName';
		
		return array('static' => $aStaticMethods, 'instance' => $aMethods);
	}
	
	public static function removeStoredWidgets() {
		Session::getSession()->setAttribute(self::WIDGET_SESSION_KEY, array());
	}
	
	/**
	 * Instanciates a widget or extracts it from the session.
	 * This method is preferred over using “new MyWidgetModule()” because it takes into account the session key as well as the disabled flag.
	 * Pass additional arguments to the module’s constructor after the session key. If your module is not persistent, do not pass a session key.
	 * @param string $sWidgetType The widget_type (in underscore notation)
	 * @param string|null $sSessionKey The session key (most often null, but still required for persistent modules if you wish to pass additional parameters)
	 * @return WidgetModule the instanciated widget
	*/
	public static function getWidget($sWidgetType, $sSessionKey = null) {
		if($sSessionKey !== null) {
			$oWidget = Session::getSession()->getArrayAttributeValueForKey(WidgetModule::WIDGET_SESSION_KEY, $sSessionKey);
			if($oWidget !== null) {
				if($oWidget->getModuleName() !== $sWidgetType) {
					throw new Exception("Widget with session key $sSessionKey expected to be $sWidgetType, but found ".$oWidget->getModuleName());
				}
				$oWidget->setNew(false); //Widget has been retrieved from session → is definitely not new
				return $oWidget;
			}
		}
		$sWidgetClass = self::getClassNameByName($sWidgetType);
		$aArgs = func_get_args();
		array_shift($aArgs);
		if(!$sWidgetClass::isPersistent()) {
			array_shift($aArgs);
		}
		array_unshift($aArgs, $sWidgetType);
		$oWidget = call_user_func_array(array("WidgetModule", "getModuleInstance"), $aArgs);
		$oWidget->setNew(true); //Widget just been created → mark as being “new”
		return $oWidget;
	}
	
	//This method is all the way at the bottom because phpDocumentor can’t handle the static:: keyword.
	public function __construct($sSessionKey = null) {
		if(static::isPersistent()) {
			if($sSessionKey === null) {
				$this->sPersistentSessionKey = get_class($this);
				if(!call_user_func(array($this->sPersistentSessionKey, 'isSingleton'))) {
					$this->sPersistentSessionKey .= "_".Util::uuid();
				}
			} else {
				$this->sPersistentSessionKey = $sSessionKey;
			}
			Session::getSession()->setArrayAttributeValueForKey(self::WIDGET_SESSION_KEY, $this->sPersistentSessionKey, $this);
		}
	}
	
}