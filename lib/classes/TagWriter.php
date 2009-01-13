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
}
?>