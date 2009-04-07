<?php
/**
 * @package modules.file
 */

include_once('propel/util/Criteria.php');
include_once('classes/Template.php');

class GetLinkArrayFileModule extends FileModule {
  private $aDisabledSections;
    
  public function __construct($aRequestPath) {
    parent::__construct($aRequestPath);

    $this->aDisabledSections = Settings::getSetting('backend', 'link_array_disabled', array());
    $this->aDisabledSections = is_array($this->aDisabledSections) ? $this->aDisabledSections : array();
  }
    
  public function renderFile() {
    header("Content-Type: text/javascript;charset=".Settings::getSetting("encoding", "browser", "utf-8"));
    $aArrayText = array();
    
    if(!in_array('documents', $this->aDisabledSections)) {
      $aDocuments = DocumentPeer::getDocumentsForMceLinkArray();

      $iDummyCatId = 'null'; // cannot be null, since the document_category_id can be null
      foreach($aDocuments as $oDocument) {
        if($oDocument->getDocumentCategoryId() !== $iDummyCatId) {
          $iDummyCatId = $oDocument->getDocumentCategoryId();
          $aArrayText[] = '["--------'.StringPeer::getString('documents').'-'.($oDocument->getDocumentCategory() ? $oDocument->getDocumentCategory()->getName() : '').'-------",""]';
        }
  	    $sLinkUrl = LinkUtil::link(array('display_document', $oDocument->getId()));
        $aArrayText[] = '["'.$oDocument->getName().'.'.$oDocument->getDocumentType()->getExtension()." (".$oDocument->getId().")".'", "'.$sLinkUrl.'"]';
      }
    }

    $aParents = PagePeer::getRootPage()->getTree();
    if(!in_array('internal_links', $this->aDisabledSections) && count($aParents) > 0) {
      $aArrayText[] = '["--------'.StringPeer::getString('links.internal').'-----------",""]';
      foreach($aParents as $oParent) {
  	    $sLinkUrl = LinkUtil::link(array('internal_link_proxy', $oParent->getId()));
        $aArrayText[] = '["'.$oParent->getNameMceIndented().'", "'.$sLinkUrl.'"]';
      }
    }
    
    if(!in_array('external_links', $this->aDisabledSections)) {
      $aLinks = LinkPeer::getLinksSorted();
      if(count($aLinks) > 0) {
        $aArrayText[] = '["--------'.StringPeer::getString('links.external').'-----------",""]';
      }
      foreach($aLinks as $oLink) {
  	    $sLinkUrl = LinkUtil::link(array('external_link_proxy', $oLink->getId()));
        $aArrayText[] = '["'.$oLink->getName().'", "'.$sLinkUrl.'"]';
      }
    }
    
    if(!in_array('images', $this->aDisabledSections)) {
      $aDocuments = DocumentPeer::getDocumentsByKindOfImage();
      if(count($aDocuments) > 0) {
        $aArrayText[] = '["--------'.StringPeer::getString('images').'-----------",""]';
      }
      foreach($aDocuments as $oDocument) {
  	    $sLinkUrl = LinkUtil::link(array('display_document', $oDocument->getId()));
        $aArrayText[] = '["'.$oDocument->getName().'.'.$oDocument->getDocumentType()->getExtension()." (".$oDocument->getId().")".'", "'.$sLinkUrl.'"]';
      }
    }
    
    $oTemplate = $this->constructTemplate("array");
    $oTemplate->replaceIdentifier("array_content", implode(",\n\t", $aArrayText), null, Template::NO_HTML_ESCAPE);
    print $oTemplate->render();
  }
}
