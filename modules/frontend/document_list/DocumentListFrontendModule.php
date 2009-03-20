<?php
/**
 * @package modules.frontend
 */

class DocumentListFrontendModule extends DynamicFrontendModule {
  const LIST_ITEM_POSTFIX = '_item';
  
  public function renderFrontend() {
    $aOptions = @unserialize($this->getData());
    $oCriteria = new Criteria();
    if(isset($aOptions['categories']) && is_array($aOptions['categories']) && (count($aOptions['categories']) > 0)) {
      $oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $aOptions['categories'], Criteria::IN);
      $oCriteria->addAscendingOrderByColumn(DocumentPeer::NAME);
    }
    $aDocuments = DocumentPeer::doSelect($oCriteria);
    // var_dump($aOptions, new Template($aOptions['list_template'])); exit;
    
    try {
      $oListTemplate = new Template($aOptions['list_template']);

      foreach($aDocuments as $i => $oDocument) {
        $oItemTemplate = new Template($aOptions['list_template'].self::LIST_ITEM_POSTFIX);
        $oItemTemplate->replaceIdentifier('name', $oDocument->getName());
        $oItemTemplate->replaceIdentifier('description', $oDocument->getDescription());
        $oItemTemplate->replaceIdentifier('extension', $oDocument->getExtension());
        $oItemTemplate->replaceIdentifier('url', $oDocument->getDisplayUrl());
        $oItemTemplate->replaceIdentifier('category_id', $oDocument->getDocumentCategoryId());
        $oListTemplate->replaceIdentifierMultiple('documents', $oItemTemplate);
      }
    } catch(Exception $e) {
      $oListTemplate = new Template("", null, true);
    }
    
    return $oListTemplate;
  } // renderFrontend()

  
  public function renderBackend() {
    $aOptions = @unserialize($this->getData());
    $aDocumentCategories = DocumentCategoryPeer::doSelect(new Criteria());
    $oTemplate = $this->constructTemplate('backend');
    $oTemplate->replaceIdentifier('categories', Util::optionsFromObjects($aDocumentCategories, 'getId', 'getName', @$aOptions['categories'], false));
    $aTemplateList = Util::arrayWithValuesAsKeys(Template::listTemplates(DIRNAME_TEMPLATES, true));
    $aListTemplates = array();
    foreach($aTemplateList as $sPath => $sListName) {
      if(Util::endsWith($sListName, self::LIST_ITEM_POSTFIX)) {
        $aListTemplates[$sPath] = substr($sListName, 0, -strlen(self::LIST_ITEM_POSTFIX));
      }
    }
    foreach($aListTemplates as $sListItemPath => $sListPath) {
      if(in_array($sListItemPath, $aTemplateList)) {
        $aListTemplates[$sListPath] = $sListPath;
      }
      unset($aListTemplates[$sListItemPath]);
    }
    
    $oTemplate->replaceIdentifier('list_templates', Util::optionsFromArray($aListTemplates, @$aOptions['list_template'], false));
    return $oTemplate;
  } // renderBackend()
  
  public function save(Blob $oData) {
    // fixed problem, is this correct
    $_POST['categories'] = is_array($_POST['categories']) ? $_POST['categories'] : array($_POST['categories']);
    foreach($_POST['categories'] as $sKey => $sValue) {
      settype($_POST['categories'][$sKey], 'integer');
    }
    $oData->setContents(serialize(array('categories' => $_POST['categories'], 'list_template' => $_POST['list_template'])));
  } // save()
}