<?php
class FileUploadWidgetModule extends WidgetModule {
	public static function isSingleton() {
		return YES;
	}
	
	public function uploadFile($sFileData, $aOptions) {
		$oDocument = new Document();
		$oDocument->setData($sFileData);
		$oDocument->setName($aOptions['name']);
		return $oDocument->save();
	}
}