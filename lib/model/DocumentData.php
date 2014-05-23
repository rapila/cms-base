<?php



/**
 * Skeleton subclass for representing a row from the 'document_data' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.model
 */
class DocumentData extends BaseDocumentData {
	private $iDataSize = null;
	
	public function getDataSize(PropelPDO $oConnection = null) {
		if($this->iDataSize === null) {
			$oCriteria = $this->buildPkeyCriteria();
			$oCriteria->addSelectColumn('OCTET_LENGTH(data)');
			$rs = DocumentPeer::doSelectStmt($oCriteria, $oConnection);
			$this->iDataSize = (int)$rs->fetchColumn(0);
		}
		return $this->iDataSize;
	}
}
