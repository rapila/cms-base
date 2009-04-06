<?php
class TagWriter {
  private $sTagName;
  private $aParameters;
  private $sContent;
  
  private static $SELF_CLOSING_TAGS = array("img", "br", "hr", "meta", "link", "input");
  
  public function __construct($sTagName, $aParameters = array(), $sContent = "") {
    if(!is_array($aParameters)) {
      $aParameters = array();
    }
    $this->sTagName = $sTagName;
    $this->aParameters = $aParameters;
    $this->sContent = $sContent;
  }
  
  public function setParameter($sName, $sValue) {
    if($sValue === null) {
      unset($this->aParameters[$sName]);
      return;
    }
    $this->aParameters[$sName] = $sValue;
  }
  
  public function getParameter($sName) {
    return @$this->aParameters[$sName];
  }
  
  public function hasParameter($sName) {
    return isset($this->aParameters[$sName]);
  }
  
  public function addToParameter($sName, $sValue) {
    if($this->hasParameter($sName)) {
      if($sValue === '' || $sValue === null) {
        return;
      }
      $this->setParameter($sName, $this->getParameter($sName)." ".$sValue);
    } else {
      $this->setParameter($sName, $sValue);
    }
  }
  
  public function parse($bContentIsEscaped=false) {
    $sTemplateText = "<".TemplateIdentifier::constructIdentifier('tag_name');
    foreach($this->aParameters as $sName => $sValue) {
      if(!$sValue) {
        continue;
      } else if($sValue === true) {
        $sValue = $sName;
      } else if(!is_string($sValue)) {
        $sValue = (string) $sValue;
      }
      $sTemplateText .= " ".$sName.'="'.Template::htmlEncode($sValue).'"';
    }
    if(in_array($this->sTagName, self::$SELF_CLOSING_TAGS)) {
      $sTemplateText .= " />";
    } else {
      $sTemplateText .= ">".TemplateIdentifier::constructIdentifier('tag_contents')."</".TemplateIdentifier::constructIdentifier('tag_name').">";
    }
    $oTemplate = new Template($sTemplateText, ($bContentIsEscaped ? 'db' : null), true, false, ($bContentIsEscaped ? Settings::getSetting("encoding", "db", "utf-8") : null));
    $oTemplate->replaceIdentifier("tag_name", $this->sTagName);
    $iFlags = Template::LEAVE_IDENTIFIERS;
    if($bContentIsEscaped) {
      $iFlags |= Template::NO_HTML_ESCAPE|Template::NO_RECODE;
    }
    $oTemplate->replaceIdentifier("tag_contents", $this->sContent, null, $iFlags);
    return $oTemplate;
  }
  
  public function __toString() {
    return $this->parse()->render();
  }
  
  public static function quickTag($sTagName = 'div', $aParameters = array(), $sContent = '') {
    $oTagWriter = new TagWriter($sTagName, $aParameters, $sContent);
    return $oTagWriter->parse();
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
      if(self::inArray($oObject, $mSelected, true, $sKeyMethod)) {
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
}
?>