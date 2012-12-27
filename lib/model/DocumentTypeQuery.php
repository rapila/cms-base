<?php


/**
 * @package   propel.generator.model
 */
class DocumentTypeQuery extends BaseDocumentTypeQuery {
	public function filterByDocumentKind($sDocumentKind = 'image', $bInclude = true) {
		$this->filterByMimetype("$sDocumentKind/%", $bInclude ? Criteria::LIKE : Criteria::NOT_LIKE);
		return $this;
	}
	
	public static function findDocumentTypeByMimetype($sMimetype=null) {
		return self::create()->filterByMimeType($sMimetype)->findOne();
	}
	
	public static function findDocumentTypeByExtension($sMimetype=null) {
		return self::create()->filterByExtension($sMimetype)->findOne();
	}
	
	public static function findDocumentTypeIDsByKind($sMimeTypeKind, $bLike = true) {
		return self::create()->filterByDocumentKind($sMimeTypeKind, $bLike)->select(array('Id'))->find()->toArray();
	}
	
	public static function findDocumentTypeAndMimetypeByDocumentKind($sMimeTypeKind='image', $bLike=true) {
		return self::create()->filterByDocumentKind($sMimeTypeKind, $bLike)->select()->find()->toKeyValue('Id', 'Mimetype');
	}
	
}

