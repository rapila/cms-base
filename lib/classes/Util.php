<?php
/**
 * classname:   Util
 */
class Util {
  private static $SQL_ENCODINGS = array("utf-8" => "utf8",
                                        "iso-8859-1" => "latin1",
                                        "iso-8859-2" => "latin2");

  private static $COMMON_DESCRIPTION_METHODS = array("getDescription", "getText", "getTitle", "__toString");
  private static $COMMON_NAME_METHODS = array("getName", "getFullName", "getTitle", "getExtension", "getStringKey", "getId");

  public static function encodeFromDatabase($sText) {
    return self::encodeForBrowser($sText, Settings::getSetting("encoding", "db", "utf-8"));
  }

  public static function encodeForBrowser($sText, $sEncoding="utf-8") {
    $sBrowserEncoding = Settings::getSetting("encoding", "browser", "utf-8");
    return self::encode($sText, $sEncoding, $sBrowserEncoding);
  }

  public static function encodeForDbFromFile($sText) {
    $sDbEncoding = Settings::getSetting("encoding", "db", "utf-8");
    return self::encode($sText, 'utf-8', $sDbEncoding);
  }

  public static function encode($sText, $sEncoding, $sDestinationEncoding) {
    if($sEncoding == $sDestinationEncoding) {
      return $sText;
    }
    return iconv($sEncoding, "$sDestinationEncoding//TRANSLIT", $sText);
  }

  public static function convertEncodingNameToSql($sEncoding) {
    if(isset(self::$SQL_ENCODINGS[$sEncoding])) {
      return self::$SQL_ENCODINGS[$sEncoding];
    }
    return $sEncoding;
  }

  public static function runFunctionOnArrayValues(&$aArray, $mCallback) {
    $aShortenedArgs = func_get_args();
    $aShortenedArgs = array_slice($aShortenedArgs, 2);
    foreach($aArray as $mKey => $mValue) {
      if(is_string($mValue))
      {
        $aArray[$mKey] = call_user_func_array($mCallback, array_merge(array($mValue), $aShortenedArgs));
      } else if(is_array($mValue)) {
        $aArray[$mKey] = call_user_func_array(array("Util", 'runFunctionOnArrayValues'), array_merge(array($mValue), array($mCallback), $aShortenedArgs));
      }
    }
    return $aArray;
  }

  public static function trimStringsInArray(&$aArray) {
    return Util::runFunctionOnArrayValues($aArray, 'trim');
  }

  public static function setEmptyArrayValuesToNull(&$aArray) {
    return Util::runFunctionOnArrayValues($aArray, create_function('$mValue', 'return $mValue === "" ? null : $mValue;'));
  }

  public static function getFolderContents($sPath) {
    if(!is_dir($sPath)){
      return array();
    }

    $rFolderHandle = opendir($sPath);
    $sFileName = "";

    $aResult = array();
    while (false !== ($sFileName = readdir($rFolderHandle)))
    {
      if(strpos($sFileName, ".")!==0) {
        $aResult[$sFileName] = "$sPath/$sFileName";
      }
    }
    natcasesort($aResult);
    return $aResult;
  }

  function mimeTypeOfFile($sFile) {
    $sMimeType = null;
    if(function_exists("finfo_open")) {
      $rFinfo = finfo_open(FILEINFO_MIME);
      $sMimeType = finfo_file($rFinfo, $sFile);
      finfo_close($rFinfo);
    } else if(function_exists("mime_content_type")) {
      $sMimeType = mime_content_type($sFile);
    } else {
      $aName = explode(".", $sFile);
      if(count($aName) > 0) {
        $oDocumentType = DocumentTypePeer::getDocumentTypeByExtension($aName[count($aName)-1]);
      }
      if($oDocumentType) {
        $sMimeType = $oDocumentType->getMimetype();
      }
    }
    if($sMimeType === null) {
      $sMimeType = 'application/octet-stream';
    }
    return $sMimeType;
  }
  
  public static function equals($mFirst, $mSecond) {
    if($mFirst === $mSecond) {
      return true;
    }
    if($mFirst instanceof BaseObject && $mSecond instanceof BaseObject) {
      return ($mFirst->getPeer() === $mSecond->getPeer()) && ($mFirst->getPrimaryKey() === $mSecond->getPrimaryKey());
    }
    if(is_object($mFirst)) {
      $mFirst = self::idForObject($mFirst);
    }
    if(is_object($mSecond)) {
      $mSecond = self::idForObject($mSecond);
    }
    return $mFirst === $mSecond;
  }
  
  public static function inArray($mScalar, $aArray, $bStrict = true) {
    if(in_array($mScalar, $aArray, $bStrict)) {
      return true;
    }
    foreach($aArray as $mValue) {
      if(self::equals($mScalar, $mValue)) {
        return true;
      }
    }
    return false;
  }

/**
 * optionsFromArray
 *
 * @param array assoc (optionvalue => optiondisplayname)
 *        or hash (optionvalue => array('value'=> displayname, 'level'=>integer for indenting of nested items)
 * @param mixed string/array selected item
 * @param string optional indent char for nested items, require value as array including param 'level'
 * @return string of html options
 *
 */
  public static function optionsFromArray($aKeyValues, $mSelected=null, $sIndent='_', $aCustomOptions = array('' => '------')) {
    if(!is_array($mSelected)) {
      if($mSelected === null) {
        $mSelected = array();
      } else {
        $mSelected = array($mSelected);
      }
    }
    $oTemplate = new Template(TemplateIdentifier::constructIdentifier('result'), null, true);
    $aKeyValuesToRender = is_array($aCustomOptions) ? $aCustomOptions : array();
    $aKeyValuesToRender = $aKeyValuesToRender+$aKeyValues;

    foreach($aKeyValuesToRender as $mKey => $mValue) {
      $sIntented = '';
      if(is_array($mValue)) {
        $sValue = $mValue['value'];
        $iLevel = $mValue['level'];
        for($i=0; $i < $mValue['level']; $i++) {
          $sIntented .= $sIndent;
        }
      } else {
        $sValue = $mValue;
      }
      $bActiveKey = in_array($mKey, $mSelected);
      $sSelectedString = $bActiveKey ? ' selected="selected"' : '';
      $sClass = $bActiveKey ? ' class="selected"' : '';

      $oOptionTemplate = new Template('<option'.TemplateIdentifier::constructIdentifier('class').' value="'.TemplateIdentifier::constructIdentifier('key').'"'.TemplateIdentifier::constructIdentifier('selected').'>'.TemplateIdentifier::constructIdentifier('indent').''.TemplateIdentifier::constructIdentifier('value').'</option>', null, true);
      $oOptionTemplate->replaceIdentifier("key", $mKey);
      $oOptionTemplate->replaceIdentifier("selected", $sSelectedString, null, Template::NO_HTML_ESCAPE);
      $oOptionTemplate->replaceIdentifier("class", $sClass, null, Template::NO_HTML_ESCAPE);
      $oOptionTemplate->replaceIdentifier("indent", $sIntented);
      $oOptionTemplate->replaceIdentifier("value", $sValue);

      $oTemplate->replaceIdentifierMultiple("result", $oOptionTemplate);
    }
    return $oTemplate;
  }

  public static function optionsFromObjects($aObjects, $sKeyMethod = null, $sValueMethod = null, $mSelected = null, $aCustomOptions = array( '' => '------')) {
    $aResult = array();
    if(!is_array($mSelected)) {
      if($mSelected === null) {
        $mSelected = array();
      } else {
        $mSelected = array($mSelected);
      }
    }
    $aSelected = array();
    
    foreach ($aObjects as $oObject) {
      $sKey = null;
      $sValue = null;
      if($sKeyMethod === null) {
        $sKey = self::idForObject($oObject);
      } else {
        $sKey = $oObject->$sKeyMethod();
      }
      if($sValueMethod === null) {
        $sValue = self::nameForObject($oObject);
      } else {
        $sValue = $oObject->$sValueMethod();
      }
      $aResult[$sKey] = $sValue;
      if(self::inArray($oObject, $mSelected)) {
        $aSelected[] = $sKey;
      }
    }
    if(is_array($aCustomOptions)) {
      foreach($aCustomOptions as $sCustomKey => $sCustomValue) {
        if(self::inArray($sCustomKey, $mSelected, false)) {
          $aSelected[] = $sCustomKey;
        }
      }
    }
    return self::optionsFromArray($aResult, $aSelected, '_', $aCustomOptions);
  }

  public static function listItemsFromArray($aArray) {
    if(count($aArray) === 0) {
      return "";
    }
    $oTemplate = new Template(TemplateIdentifier::constructIdentifier('result'), null, true);
    foreach($aArray as $sListItem) {
      $oOptionTemplate = new Template('<li>'.TemplateIdentifier::constructIdentifier('value').'</li>', null, true);
      $oOptionTemplate->replaceIdentifier("value", $sListItem);

      $oTemplate->replaceIdentifierMultiple("result", $oOptionTemplate);
    }
    return $oTemplate;
  }

  public static function getEmailLinkWriter($sLinkUrl, $sText=null) {
    if($sText === null) {
      $sText = StringPeer::getString("email");
    } else if(Settings::getSetting("frontend", "protect_email_addresses", false)) {
      $sText = str_replace("@", " [at] ", $sText);
    }

    if(Settings::getSetting("frontend", "protect_email_addresses", false)) {
      $sLinkUrl = str_replace("@", "^", $sLinkUrl);
      $sLinkUrl = str_replace(".", "!", $sLinkUrl);
    } else {
      $sLinkUrl = "mailto:".$sLinkUrl;
    }

    $oWriter = new TagWriter("a", array('class' => 'mailto_link', 'href' => $sLinkUrl), $sText);

    return $oWriter;
  }

  public static function writeEmailLink($sLinkUrl, $sText) {
    return self::getEmailLinkWriter($sLinkUrl, $sText)->parse();
  }

  public static function camelize($sString, $bUcFirst=false) {
    $aExploded = explode('_', $sString);
    $sResult = '';
    foreach($aExploded as $key => $value){
      if($bUcFirst || ($key > 0)) {
        $sResult.= ucfirst($value);
      } else {
        $sResult.= $value;
      }
    }
    return $sResult;
  }

  public static function deCamelize($sString) {
    $sResult = "";
    $iStrLen = strlen($sString);
    for($i=0;$i<$iStrLen;$i++) {
      $cPart = substr($sString, $i, 1);
      if(preg_match("/[A-Z]/", $cPart) && $i>0) {
        $sResult .= "_".strtolower($cPart);
      } else {
        $sResult .= strtolower($cPart);
      }
    }
    return $sResult;
  }

  public static function makeReadableName($sString) {
    $aSplit = explode('_', $sString);
    foreach($aSplit as $i => $sChunks) {
      $aSplit[$i] = ucfirst($sChunks);
    }
    return implode(" ", $aSplit);
  }

  public static function endsWith($str, $end) {
    return strrpos($str, $end)===strlen($str)-strlen($end);
  }

  public static function startsWith($str, $start) {
    return strpos($str, $start)===0;
  }

  public static function nameForObject($oObject) {
    if(!is_object($oObject)) {
      return $oObject;
    }
    foreach(self::$COMMON_NAME_METHODS as $sMethodName) {
      if(method_exists($oObject, $sMethodName)) {
        return $oObject->$sMethodName();
      }
    }
    return "";
  }

  // used in BackendModule only, could be used from somewhere else?
  public static function idForObject($oObject) {
    if(!is_object($oObject)) {
      return $oObject;
    }
    if(method_exists($oObject, 'getIdMethodName')) {
      $sMethodName = $oObject->getIdMethodName();
      return $oObject->$sMethodName();
    }
    foreach(array_reverse(self::$COMMON_NAME_METHODS) as $sMethodName) {
      if(method_exists($oObject, $sMethodName)) {
        return $oObject->$sMethodName();
      }
    }
    return "";
  }

  // used in Template only, could be used from somewhere else?
  public static function descriptionForObject($oObject) {
    if(is_string($oObject)) {
      return $oObject;
    }
    foreach(array_merge(self::$COMMON_DESCRIPTION_METHODS, self::$COMMON_NAME_METHODS) as $sMethodName) {
      if(method_exists($oObject, $sMethodName)) {
        return $oObject->$sMethodName();
      }
    }
    return "";
  }

  public static function dumpAll() {
    $aArgs = func_get_args();
    ob_clean();
    header("Content-Type: text/plain;charset=".Settings::getSetting('encoding', 'browser', 'utf-8'));
    call_user_func_array('var_dump', $aArgs);
    exit();
  }

  public static function fireDump() {
    $aArgs = func_get_args();
    require_once("FirePHPCore/fb.php");
    if(count($aArgs) === 1) {
      $aArgs = $aArgs[0];
    }
    fb($aArgs);
  }

  public static function arrayWithValuesAsKeys($aArray) {
    $aResult = array();
    foreach($aArray as $iKey => $sValue) {
      $aResult[$sValue] = $sValue;
    }
    return $aResult;
  }

  public static function truncate($sText, $iLength=20, $sPostfix="…", $iTolerance=3) {
    if(mb_strlen($sText) > $iLength+$iTolerance) {
      $sText = mb_substr($sText, 0, $iLength).$sPostfix;
    }
    return $sText;
  }

  public static function normalize($sInput, $sReplaceSpaceBy = '-') {
    if($sInput === null || $sInput === '') {
      return null;
    }
    $sInput = @iconv(Settings::getSetting('encoding', 'browser', 'utf-8'), 'US-ASCII//TRANSLIT', $sInput);
    $sInput = mb_ereg_replace('-|–|—', '-', $sInput);
    $sInput = mb_ereg_replace('\s+', $sReplaceSpaceBy, $sInput);
    $sNewName = strtolower(preg_replace("/([^\\w\\d\-_])/u", "", $sInput));
    if($sNewName !== "") {
      return $sNewName;
    } else {
      return null;
    }
  }

  public static function getWords($sString, $bFromHtml=false) {
    if($sString instanceof Template) {
      $sString = $sString->render();
    }

    if($bFromHtml) {
      $aReplaceByLinebreak = array('<br />', '<br/>', '<br>', '</p><p>', '</li><li>', '</div><div>');
      $sString = str_replace($aReplaceByLinebreak, "\n", $sString);
      $sString = html_entity_decode(strip_tags($sString), ENT_QUOTES, Settings::getSetting('encoding', 'browser', 'utf-8'));
    }

    $aWords = mb_split("[^\w\-–—]+", $sString);
    $aResult = array();
    foreach($aWords as $sWord) {
      $sWord = self::normalize($sWord);
      if($sWord !== null) {
        $aResult[] = $sWord;
      }
    }
    return $aResult;
  }

  public static function getDocumentSize($sDocContent=null, $sFormat = 'KiB', $bAutomatic = true) {
    $iDocLength = 0;
    if($sDocContent !== null) {
      $iDocLength = strlen($sDocContent);
    }
    $oOutputDividor = 1;
    switch($sFormat) {
      case "KiB":
      case "kB":
      case "kb":
      case "k":
      case "Kb":
        $oOutputDividor = 1024;
        break;
      case "MiB":
      case "MB":
      case "M":
        $oOutputDividor = 1024 * 1024;
        break;
      case "GiB":
      case "GB":
      case "Gb":
        $oOutputDividor = 1024 * 1024 * 1024;
        break;
    }
    if($bAutomatic && ($iDocLength > (1024*1024))) {
      $oOutputDividor =  1024 * 1024;
      $sFormat = 'MB';
    }
    return round($iDocLength/$oOutputDividor, 2)." ".$sFormat;
  }

  public static function redirectToManager($mPath="", $mManager=null, $aParameters=array(), $bIncludeLanguage=null) {
    self::redirect(Util::link($mPath, $mManager, $aParameters, $bIncludeLanguage));
  }

  //redirectToLanguage can only be used if language attribute is still in REQUEST_PATH
  public static function redirectToLanguage($bNoRedirectIfMultilingual=true, $sLanguageId=null) {
    if($bNoRedirectIfMultilingual && !Settings::getSetting('general', 'multilingual', true)) {
      return;
    }
    if($sLanguageId == null) {
      $sLanguageId = Session::language();
    }
    if(Manager::hasNextPathItem() && (strlen(Manager::peekNextPathItem()) === 2 || LanguagePeer::languageExists(Manager::peekNextPathItem()))) {
      Manager::usePath();
    }
    self::redirectToManager(array_merge(array($sLanguageId), Manager::getRequestPath()), null, array(), false);
  }

  public static function redirect($sLocation, $sHost = null, $sProtocol = 'http://') {
    header("HTTP/1.0 301 Moved Permanently");
    $sRedirectString = "Location: ".self::absoluteLink($sLocation, $sHost, $sProtocol);
    ob_clean();header($sRedirectString);exit;
  }
  
  public static function absoluteLink($sLocation, $sHost = null, $sProtocol = "http://") {
    if($sHost === null) {
      $sHost = $_SERVER['HTTP_HOST'];
    }
    return "$sProtocol$sHost$sLocation";
  }

  public static function linkToSelf($mPath=null, $aParameters=null, $bIgnoreRequest = false) {
    $aRequestPath = Manager::getUsedPath();
    if($aParameters === null) {
      $aParameters = array();
    }
    if($mPath !== null) {
      if(!is_array($mPath)) {
        $mPath = explode("/", $mPath);
      }
      $aPath = array_merge($aRequestPath, $mPath);
    } else {
      $aPath = $aRequestPath;
    }
    if(!$bIgnoreRequest) {
      foreach(array_diff_assoc($_REQUEST, $_COOKIE) as $sName=>$sValue) {
        if($sName === 'path') {
          continue;
        }
        if(!isset($aParameters[$sName])) {
          $aParameters[$sName] = $sValue;
        }
      }
    }
    return Util::link($aPath, null, $aParameters, false);
  }

  public static function getManagerClassNormalized($mManager = null) {
    if($mManager === null) {
      return Manager::getCurrentManager();
    }
    if(is_object($mManager)) {
      return get_class($mManager);
    }
    return $mManager;
  }

  public static function link($mPath=array(), $mManager=null, $aParameters=array(), $bIncludeLanguage=null) {
    if(!is_array($mPath)) {
      $mPath = explode("/", $mPath);
    }

    $mManager = self::getManagerClassNormalized($mManager);
    $sPrefix = Manager::getPrefixForManager($mManager);

    if($bIncludeLanguage === null) {
      $bIncludeLanguage = call_user_func(array($mManager, 'shouldIncludeLanguageInLink'));
    }

    if($bIncludeLanguage) {
      array_unshift($mPath, Session::language());
    }

    foreach($mPath as $iKey => $sValue) {
      if($sValue === null || $sValue === "") {
        unset($mPath[$iKey]);
      } else {
        $mPath[$iKey] = rawurlencode($sValue);
      }
    }
    
    if($sPrefix !== null && $sPrefix !== "") {
      $sPrefix .= "/";
    } else {
      $sPrefix = '';
    }
    
    return MAIN_DIR_FE.$sPrefix.implode('/', $mPath).self::prepareLinkParameters($aParameters);
  }
  
  public static function prepareLinkParameters($aParameters) {
    $sParameters = '';
    foreach($aParameters as $sKey => $sValue) {
      if(is_array($sValue)) {
        foreach($sValue as $sKeyKey => $sValueValue) {
          $sParameters .= "&".rawurlencode($sKey)."[".rawurlencode($sKeyKey)."]".($sValueValue ? "=".rawurlencode($sValueValue) : '');
        }
      } else {
        $sParameters .= "&".rawurlencode($sKey).($sValue ? "=".rawurlencode($sValue) : '');
      }
    }
    $sParameters = substr($sParameters, 1);
    if($sParameters !== false && $sParameters !== "") {
      $sParameters = "?".$sParameters;
    }
    return $sParameters;
  }

  public static function array2HtmlList($aParams, $sClassName='doc_types') {
    if(count($aParams) === 0) return;
    $sOutput = "<table class=\"".$sClassName."\">".PHP_EOL;
    $sOutput .= "\t<tr class=\"header\">".PHP_EOL;
    foreach($aParams[0] as $sKey => $sValue) {
      $sOutput .= "\t\t<td>". $sKey . "</td>".PHP_EOL;
    }
    $sOutput .= "\t</tr>".PHP_EOL;
    foreach($aParams as $aValues) {
      $sOutput .= "\t<tr>".PHP_EOL;
      foreach($aValues as $sValue) {
        $sOutput .= "\t\t<td>". $sValue . "</td>".PHP_EOL;
      }
      $sOutput .= "\t</tr>".PHP_EOL;
    }
    $sOutput .= "</table>".PHP_EOL;
    return $sOutput;
  }

  //Gets the user's locale for the current language
  public static function getLocaleId($sLanguageId) {
    if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
      $sAcceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
      $aAcceptLanguages = explode(',' , $sAcceptLanguage);
      foreach($aAcceptLanguages as $sLocaleIdWithQ) {
        $aLocaleIdWithQ = explode(';', $sLocaleIdWithQ);
        $sLocaleId = $aLocaleIdWithQ[0];
        $aLocaleIds = explode('-' , $sLocaleId);
        $sAcceptLang = $aLocaleIds[0];
        if($sAcceptLang == $sLanguageId && isset($aLocaleIds[1])) {
          return $sAcceptLang."_".strtoupper($aLocaleIds[1]);
        }
      }
    }
    return $sLanguageId."_".strtoupper($sLanguageId);
  }
  
  public static function getPreferredUserLanguage() {
    if(Session::getSession()->hasAttribute("preferred_user_language")) {
      return Session::getSession()->getAttribute("preferred_user_language");
    }
    if(!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
      return Session::language();
    }
    $sAcceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $aAcceptLanguages = explode(',' , $sAcceptLanguage);
    if(count($aAcceptLanguages) === 0) {
      return Session::language();
    }
    $aResult = array();
    foreach($aAcceptLanguages as $sLocaleIdWithQ) {
      $aLocaleIdWithQ = explode(';', $sLocaleIdWithQ);
      $sAcceptLang = $aLocaleIdWithQ[0];
      $sAcceptLang = explode('-' , $sAcceptLang);
      $sAcceptLang = $sAcceptLang[0];
      $iQ = 1.0;
      if(isset($aLocaleIdWithQ[1])) {
        $aLocaleIdWithQ = explode("=", $aLocaleIdWithQ[1]);
        if(isset($aLocaleIdWithQ[1])) {
          $iQ = (float)$aLocaleIdWithQ[1];
        }
      }
      if(!isset($aResult[$sAcceptLang]) || $aResult[$sAcceptLang] < $iQ) {
        $aResult[$sAcceptLang] = $iQ;
      }
    }
    arsort($aResult, SORT_NUMERIC);
    $aResult = array_keys($aResult);
    Session::getSession()->setAttribute("preferred_user_language", $aResult[0]);
    return $aResult[0];
  }

  /**
  * Sets the locale settings of a given locale category to the passed locale. If a language is passed instead of a locale, the locale is searched using {@link Util::getLocaleId()}. This function tries to set the locale using the current browser output encoding. If this fails, it tries to set the locale with the default encoding.
  */
  public static function setLocaleToLanguageId($sLanguageId, $iCategory = LC_ALL) {
    if(strpos($sLanguageId, "_") === false) {
      $sLanguageId = self::getLocaleId($sLanguageId);
    }
    $sEncoding = strtoupper(Settings::getSetting("encoding", "browser", "utf-8"));
    setlocale($iCategory, "$sLanguageId.$sEncoding");
    if(setlocale($iCategory, "0") !== "$sLanguageId.$sEncoding") {
      setlocale($iCategory, $sLanguageId);
      if(setlocale($iCategory, "0") !== $sLanguageId) {
        $sLanguageId = substr($sLanguageId, 0, strpos($sLanguageId, "_"));
        setlocale($iCategory, $sLanguageId);
      }
    }
  }

  public static function localizeDate($iTimestamp = null, $sLanguageId = null, $sFormat="x") {
    if($iTimestamp === null) {
      $iTimestamp = time();
    }
    if($sLanguageId === null) {
      $sLanguageId = Session::language();
    }
    self::setLocaleToLanguageId($sLanguageId, LC_TIME);

    if(is_string($iTimestamp)) {
      $iTimestamp = strtotime($iTimestamp);
    }
    return strftime("%$sFormat", $iTimestamp);
  }

  public static function parseLocalizedDate($sDate, $sLanguageId, $sFormat="x") {
    if($sLanguageId === null) {
      $sLanguageId = Session::language();
    }
    self::setLocaleToLanguageId($sLanguageId, LC_TIME);

    $aResult = strptime($sDate, "%$sFormat");
    if($aResult === false) {
      return null;
    }

    //Some variations of strptime seem to return invalid values for hour, minute and second
    if($aResult['tm_hour'] < 0 || $aResult['tm_hour'] > 23) {
      $aResult['tm_hour'] = 0;
    }
    if($aResult['tm_min'] < 0 || $aResult['tm_min'] > 59) {
      $aResult['tm_min'] = 0;
    }
    if($aResult['tm_sec'] < 0 || $aResult['tm_sec'] > 61) {
      $aResult['tm_sec'] = 0;
    }

    return mktime($aResult['tm_hour'], $aResult['tm_min'], $aResult['tm_sec'], $aResult['tm_mon']+1, $aResult['tm_mday'], $aResult['tm_year']+1900);
  }

  public static function localizeTimestamp($iTimestamp, $sLanguageId = null, $bShowTimeShort = false) {
    if ($bShowTimeShort) {
      return substr(self::localizeDate($iTimestamp, $sLanguageId, "X"), 0, 5);
    }
    return self::localizeDate($iTimestamp, $sLanguageId, "X");
  }

  public static function normalizeDate($sDate, $sSeparator = '-') {
    return preg_replace("/[^\d]/", $sSeparator, $sDate);
  }

  public static function localizeTime($iTime, $sSeparator = '.') {
    $sTime = substr($iTime, 0, 5);
    return str_replace (':', $sSeparator, $sTime);
  }

  public static function getHostName() {
    return Settings::getSetting('domain_holder', 'name', 'Sitename');
  }

  public static function getBackendLanguages() {
    $aLanguages = array();
    foreach(self::getFolderContents(MAIN_DIR.'/resources/lang/') as $sLanguage => $sPath) {
      $sName = substr($sLanguage, 0, 2);
      $aLanguages[] = $sName;
    }
    return $aLanguages;
  }

  public static function getPropelSortMethodName($sSortOrder = 'asc') {
    return 'add'.ucfirst(strtolower($sSortOrder)).'endingOrderByColumn';
  }

  public static function getUrlWithProtocolIfNotSet($sUrl) {
    if($sUrl != '') {
      return Util::getPrefixIfNotSet($sUrl);
    }
    return '';
  }

  /**
  * @todo find a better more appropriate solution
  */
  public static function getPrefixIfNotSet($sString, $sDefaultPrefix = 'http://') {
    $sPattern = '/^\w+:/';
    if(preg_match($sPattern, $sString) === 1) {
      return $sString;
    }
    return $sDefaultPrefix.$sString;
  }
}