<?php
/**
 * @package modules.file
 */

include_once('propel/util/Criteria.php');

class GetImageArrayFileModule extends FileModule {
	private $aImages;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->aImages = DocumentPeer::getDocumentsByKindOfImage(!isset($_REQUEST['include_externally_managed']));
	}
	
	public function renderFile() {
		header("Content-Type: text/javascript;charset=".Settings::getSetting("encoding", "browser", "utf-8"));
		$aArrayText = array();
		$iDummyCatId=null;
		foreach($this->aImages as $oImage) {
			if($oImage->getDocumentCategoryId() !== $iDummyCatId) {
				$iDummyCatId = $oImage->getDocumentCategoryId();
				$aArrayText[] = '["--------'.StringPeer::getString('widget.documents').'-'.($oImage->getDocumentCategory() ? $oImage->getDocumentCategory()->getName() : '').'-------",""]';
			}
			$sLinkUrl = LinkUtil::link(array('display_document', $oImage->getId()));
			$aArrayText[] = '["'.$oImage->getName().'.'.$oImage->getDocumentType()->getExtension()." (".$oImage->getId().")".'", "'.$sLinkUrl.'"]';
		}
		$oTemplate = $this->constructTemplate("array");
		$oTemplate->replaceIdentifier("array_content", implode(",\n\t", $aArrayText), null, Template::NO_HTML_ESCAPE);
		print $oTemplate->render();
	}
}
