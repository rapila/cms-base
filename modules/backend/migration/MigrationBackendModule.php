<?php
/**
 * @package modules.backend
 */
class MigrationBackendModule extends BackendModule {

  private $sCheckName = null;

  private static $STRING_REPLACE_ARRAY  = array('{{{', '}}}', '\{\{\{', '\}\}\}');
  private static $TO_BE_REPLACED_ARRAY = array('{{', '}}', '\{\{', '\}\}');

  // default mini-cms tables
  private static $MODEL_FIELD_NAMES = array('LanguageObject' => 'getData', 
                                            'LanguageObjectHistory' => 'getData'  
                                              );


  // cms_gems tables
  // private static $MODEL_FIELD_NAMES = array('LanguageObject' => 'getData', 
  //                                           'LanguageObjectHistory' => 'getData', 
  //                                           'PractitionerText' => 'getDescription',
  //                                           'CollaboratorText' => 'getDescription',
  //                                           'CourseOutline' => 'getDescription',
  //                                           'Event' => 'getDescription'
  //                                           );
                             
  // default mini-cms object types to be checked                                          
  private static $OBJECT_TYPES_CHECK_ONLY = array('text');
  
  // cms_gems examples object types to be checked
  // private static $OBJECT_TYPES_CHECK_ONLY = array('text', 'teaser_dynamic');

  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->sCheckName = Manager::usePath();
    }
    $this->oTemplate = $this->constructTemplate("detail");
  }

  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    $this->parseTree($oTemplate, array('template_identifier_change_test', 'template_identifier_change', 'SQL Migration'), $this->sCheckName);
    return $oTemplate;
  }

  public function getDetail() {
    if($this->sCheckName === null) {
      return $this->constructTemplate("module_info");
    }

    switch($this->sCheckName) {
      case "template_identifier_change":
        $this->migrateTemplateIdentifierChange();
      break;
      case "template_identifier_change_test":
        $this->migrateTemplateIdentifierChangeTest();
      break;
      case "SQL Migration":
        if(isset($_REQUEST['previous_revision'])) {
          $this->migrateSQL(!isset($_REQUEST['execute']));
        } else {
          $this->migrateSQLInterface();
        }
      break;
    }
    $this->oTemplate->replacePstring("check.text", array('check_item' => $this->sCheckName));
    return $this->oTemplate;
  }

  // test of migrate template indentifer returning count of instances in count of objects
  public function migrateTemplateIdentifierChangeTest() {
    $this->migrateTemplateIdentifierChange(true);
  }

  // migrate template identifier changes to site specific content in tables, r1596
  public function migrateTemplateIdentifierChange($bTestOnly = false) {
    foreach(self::$MODEL_FIELD_NAMES as $sModelName => $sMethodName) {
      $aObjects = call_user_func(array($sModelName.'Peer', 'doSelect'), new Criteria());
      $iCount = 0;
      $iCountObjects = 0;
      
      // for LanguageObjects.... the object type has to be checked
      $bCheckObjectType = $sModelName ==='LanguageObject' || $sModelName ==='LanguageObjectHistory';
      foreach($aObjects as $oObject) {
        // default object type
        $sObjectType = null;
        if($bCheckObjectType) {
          $sObjectType = $oObject->getContentObject()->getObjectType();
          if(!in_array($sObjectType, self::$OBJECT_TYPES_CHECK_ONLY)) {
            continue;
          } 
        } 
        if($bTestOnly) {
          $iCount += $this->countIdentifiers($oObject->$sMethodName(), $sObjectType);
          $iCountObjects++;
        } else {
          $sSetterName = 's'.substr($sMethodName, 1);
          $oObject->$sSetterName($this->replaceIdentifiers($oObject->$sMethodName(), $sObjectType));
          $oObject->save();
        }
      }
      $sCheckName = !$bTestOnly ? $this->sCheckName : "$this->sCheckName (Identifiers to be replaced: $iCount in $iCountObjects Objects of type $sModelName)";
      $this->oTemplate->replaceIdentifierMultiple("messages", StringPeer::getString('check.text', null, null, array('check_item' => $sCheckName)));
    }
  }

  private function replaceIdentifiers($oBlob, $sObjectType) {
    // object type teaser dynamic only exists for cms_gems, replace by other type if required and blob content is serialized
    if($sObjectType == 'teaser_dynamic') {
      $aContent = unserialize($oBlob->getContents());
      $sContent = $aContent['teaser_contents'];
    } else {
      $sContent = $oBlob->getContents();
    }
    $sContentStripped = str_replace(self::$STRING_REPLACE_ARRAY, self::$TO_BE_REPLACED_ARRAY, $sContent);
    if($sObjectType == 'teaser_dynamic') {
      $aContent['teaser_contents'] = $sContentStripped;
      return serialize($aContent);
    }
    return $sContentStripped;
  }

  private function countIdentifiers($oBlob, $sObjectType) {
    // object type teaser dynamic only exists for cms_gems, replace by other type if required and blob content is serialized
    if($sObjectType == 'teaser_dynamic') {
      $aContent = unserialize($oBlob->getContents());
      $sContent = $aContent['teaser_contents'];
    } else {
      $sContent = $oBlob->getContents();
    }
    str_replace(self::$STRING_REPLACE_ARRAY, self::$TO_BE_REPLACED_ARRAY, $sContent, $iCount);
    return $iCount;
  }
  
  private function migrateSQL($bIsTest) {
    $sMigrationFile = $this->getSQLMigrationFile();
    $iStartRevision = $_REQUEST['previous_revision'];
    $rFile = fopen($sMigrationFile, 'r');
    $iCurrentlyReadRevision = 0;
    $sStatement = "";
    $iQueryCount = 0;
    while (($sReadLine = fgets($rFile)) !== false) {
      $aMatches;
      if(preg_match("/^#svn r?(\d+)$/", $sReadLine, $aMatches) === 1) {
        $iCurrentlyReadRevision = (int)$aMatches[1];
        continue;
      }
      if($iCurrentlyReadRevision > $iStartRevision) {
        if($sReadLine !== "\n" && !StringUtil::startsWith($sReadLine, "#") && !StringUtil::startsWith($sReadLine, "--")) {
          $sStatement .= $sReadLine;
        }
        if(StringUtil::endsWith($sReadLine, ";\n")) {
          $iQueryCount += $this->executeQuery($sStatement, $bIsTest);
          $sStatement = "";
        }
      }
    }
    $iQueryCount += $this->executeQuery($sStatement, $bIsTest);
    if($bIsTest) {
      $this->oTemplate->replaceIdentifier('content', TagWriter::quickTag('a', array('href' => LinkUtil::linkToSelf(null, array('execute' => true))), "Execute!"));
    } else {
      $this->oTemplate->replaceIdentifierMultiple('messages', "Executed $iQueryCount queries");
    }
  }
  
  private function executeQuery($sStatement, $bIsTest) {
    if(trim($sStatement) === "") {
      return 0;
    }
    $oConnection = Propel::getConnection();
    if($bIsTest) {
      $this->oTemplate->replaceIdentifierMultiple('messages', $sStatement);
    } else {
      $oConnection->exec($sStatement);
    }
    return 1;
  }
  
  private function migrateSQLInterface() {
    $oTemplate = $this->constructTemplate('migrate_sql');
    $this->oTemplate->replaceIdentifier('content', $oTemplate);
  }
  
  private function getSQLMigrationFile() {
    $sMigrationFile = ResourceFinder::findResource(array('data', 'install', 'migration.sql'));
    return $sMigrationFile;
  }
}
