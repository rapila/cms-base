<?php

class Image {
	private $rImageHandle;
	private $iWidth = null;
	private $iHeight = null;
	private $sFileType = "jpeg";
	private $fScalingFactor = 1.0;

	private $iOriginalWidth;
	private $iOriginalHeight;

	public static $GD_INFO;

	const RESIZE_TO_LARGER_VALUE = 1;
	const RESIZE_TO_SMALLER_VALUE = 2;
	const RESIZE_TO_WIDTH = 3;
	const RESIZE_TO_HEIGHT = 4;
	const STRETCH = 5;

	public function __construct($rImageHandle) {
		$this->rImageHandle = $rImageHandle;
		$this->iOriginalWidth = imagesx($this->rImageHandle);
		$this->iOriginalHeight = imagesy($this->rImageHandle);
	}

	public function setSize($iWidth, $iHeight, $iMode = self::RESIZE_TO_WIDTH) {
		if($iMode === self::STRETCH) {
			$this->iWidth = $iWidth;
			$this->iHeight = $iHeight;
			$this->fScalingFactor = null;
			return;
		}

		$fFactorOnScaleToWidth = ((float)$iWidth)/$this->iOriginalWidth;
		$fFactorOnScaleToHeight = ((float)$iHeight)/$this->iOriginalHeight;

		switch($iMode) {
			case (self::RESIZE_TO_LARGER_VALUE):
			case (self::RESIZE_TO_SMALLER_VALUE):
				$bWidthIsLarger = $fFactorOnScaleToWidth > $fFactorOnScaleToHeight;
				$this->fScalingFactor = ($iMode === self::RESIZE_TO_LARGER_VALUE) ?
													($bWidthIsLarger ? $fFactorOnScaleToWidth : $fFactorOnScaleToHeight) :
													($bWidthIsLarger ? $fFactorOnScaleToHeight : $fFactorOnScaleToWidth);
				break;
			case (self::RESIZE_TO_WIDTH):
				$this->fScalingFactor = $fFactorOnScaleToWidth;
				break;
			case (self::RESIZE_TO_HEIGHT):
				$this->fScalingFactor = $fFactorOnScaleToHeight;
				break;
		}
		$this->iWidth = $this->iOriginalWidth * $this->fScalingFactor;
		$this->iHeight = $this->iOriginalHeight * $this->fScalingFactor;
	}

	public function getOriginalWidth()
	{
			return $this->iOriginalWidth;
	}

	public function getOriginalHeight()
	{
			return $this->iOriginalHeight;
	}

	public function getWidth()
	{
			return $this->iWidth;
	}

	public function getHeight()
	{
			return $this->iHeight;
	}

	public function getOrientation() {
		if($this->iOriginalHeight < $this->iOriginalWidth) {
			return "landscape";
		}
		return "portrait";
	}

	public function getScalingFactor()
	{
			return $this->fScalingFactor;
	}

	public function getImageHandle()
	{
			return $this->rImageHandle;
	}

	public function setFileType($sFileType)
	{
			$this->sFileType = $sFileType;
	}

	public function getFileType()
	{
			return $this->sFileType;
	}

	public function addText($sFontFilePath, $sText, $iOpacity, $iFontSize, $iRed, $iGreen, $iBlue, $iX = 0, $iY = 0, $iRotationAngle = 0) {
		$rColor = imagecolorallocatealpha($this->rImageHandle, $iRed, $iGreen, $iBlue, $iOpacity);
		imagefttext($this->rImageHandle, $iFontSize, $iRotationAngle, $iX, $iY, $rColor, $sFontFilePath, $sText);
		imagecolordeallocate($this->rImageHandle, $rColor);
	}

	public function addWatermark($sFontFilePath, $sText) {
		$iFontSize = $this->iOriginalHeight/10;
		$iAngle = 0;
		$aImageInfo = imageftbbox($iFontSize, $iAngle, $sFontFilePath, $sText);
		$iWidth = $aImageInfo[4] - $aImageInfo[6] + $this->iOriginalWidth/20;
		$iHeight = $this->iOriginalHeight/20;

		$rColor = imagecolorallocatealpha($this->rImageHandle, 255, 255, 255, 30);
		imagefttext($this->rImageHandle, $iFontSize, $iAngle, $this->iOriginalWidth-$iWidth, $this->iOriginalHeight-$iHeight, $rColor, $sFontFilePath, $sText);
		imagecolordeallocate($this->rImageHandle, $rColor);
	}

	public function fill($iRed, $iGreen, $iBlue, $iAlpha = 0) {
		$rColor = $iAlpha === 0 ? imagecolorallocate($this->rImageHandle, $iRed, $iGreen, $iBlue) : imagecolorallocatealpha($this->rImageHandle, $iRed, $iGreen, $iBlue, $iAlpha);
		imagefill($this->rImageHandle, 0, 0, $rColor);
		imagecolordeallocate($this->rImageHandle, $rColor);
	}

	public function filterGrayscale() {
		imagefilter($this->rImageHandle, IMG_FILTER_GRAYSCALE);
	}

	public function filterInvert() {
		imagefilter($this->rImageHandle, IMG_FILTER_NEGATE);
	}

	public function filterMeanRemoval() {
		imagefilter($this->rImageHandle, IMG_FILTER_MEAN_REMOVAL);
	}

	public function filterEdgeDetect() {
		imagefilter($this->rImageHandle, IMG_FILTER_EDGEDETECT);
	}

	public function filterEmboss() {
		imagefilter($this->rImageHandle, IMG_FILTER_EMBOSS);
	}

	public function filterColorize($iRed, $iGreen, $iBlue) {
		imagefilter($this->rImageHandle, IMG_FILTER_COLORIZE, $iRed, $iGreen, $iBlue);
	}

	public function filterPixelate($iBlockSize = 20, $bUseAdvancedPixelation = false) {
		imagefilter($this->rImageHandle, IMG_FILTER_PIXELATE, $iBlockSize, $bUseAdvancedPixelation);
	}

	public function filterBrightness($iLevel = 50) {
		imagefilter($this->rImageHandle, IMG_FILTER_BRIGHTNESS, $iLevel);
	}

	public function filterContrast($iLevel = 50) {
		imagefilter($this->rImageHandle, IMG_FILTER_CONTRAST, $iLevel);
	}

	public function filterSmooth($iLevel = 20) {
		imagefilter($this->rImageHandle, IMG_FILTER_SMOOTH, $iLevel);
	}

	public function filterBlur($bUseSelectiveBlur = false) {
		imagefilter($this->rImageHandle, $bUseSelectiveBlur ? IMG_FILTER_SELECTIVE_BLUR : IMG_FILTER_GAUSSIAN_BLUR);
	}

	public function filterSepia($iRed = 100, $iGreen = 50, $iBlue = 0) {
		$this->filterGrayscale();
		$this->filterColorize($iRed, $iGreen, $iBlue);
		$this->filterContrast(-10);
		$this->filterBrightness(-20);
	}

	/**
	* frees up the image buffer
	* only call this when discarding the image object
	*/
	public function destroy() {
		imagedestroy($this->rImageHandle);
	}

	public function render($bDontBlowUp = true, $sFileName = null, $oCache = null) {
		if($bDontBlowUp) {
			if($this->iOriginalWidth < $this->iWidth || $this->iOriginalHeight < $this->iHeight) {
				$this->iWidth = null;
			}
		}

		if($this->iWidth !== null) {
			$this->resizeImage();
		}

		if($oCache !== null && !$oCache->cacheIsOffForWriting()) {
			$oStrategy = $oCache->getStrategy();
			// Take shortcut if cache is a file
			if($oStrategy instanceof CachingStrategyFile) {
				$sFilePath = $oStrategy->prepareFilePath($oCache);
				$this->save($sFilePath);
			} else {
				ob_start();
				$this->outputToScreen();
				$oCache->setContents(ob_get_contents());
				ob_end_clean();
			}
			//This is only for sending Last-Modified. You’ll still have to call this explicitly as soon as you know the cache string (as early as possible – a lot earlier than this) to send a Not Modified response if a If-Modified-Since was sent.
			$oCache->sendCacheControlHeaders();
		}

		if($sFileName === null) {
			$this->outputToScreen();
		} else {
			$this->save($sFileName);
		}
	}

	private function save($sPath) {
		switch($this->sFileType) {
			case ('jpg'):
			case ('jpeg'):
				return imagejpeg($this->rImageHandle, $sPath);
				break;
			case ('gif'):
				return imagegif($this->rImageHandle, $sPath);
				break;
			case ('png'):
				imagesavealpha($this->rImageHandle, true);
				return imagepng($this->rImageHandle, $sPath);
				break;
		}
	}

	private function outputToScreen() {
		switch($this->sFileType) {
			case ('jpg'):
			case ('jpeg'):
				header("Content-Type: image/jpeg");
				return imagejpeg($this->rImageHandle);
				break;
			case ('gif'):
				header("Content-Type: image/gif");
				return imagegif($this->rImageHandle);
				break;
			case ('png'):
				header("Content-Type: image/png");
				imagesavealpha($this->rImageHandle, true);
				return imagepng($this->rImageHandle);
				break;
		}
	}

	public function resizeImage() {
		$rNewImage = imagecreatetruecolor($this->iWidth, $this->iHeight);
		// retrieve version number since version_compare can't handle versions like “bundled (2.1.0 compatible)”
		// prerelease versions are not processed anymore
		$sVersion = preg_replace("/.*?((\\d+\\.){1,2}\\d+).*/", '$1', self::$GD_INFO['GD Version']);
		if($this->sFileType === 'png' && version_compare($sVersion, '2.0.1', '>=')) {
			$rTransparent = imagecolorallocatealpha($rNewImage, 0, 0, 0, 127);
			imagefill($rNewImage, 0, 0, $rTransparent);
			imagecolordeallocate($rNewImage, $rTransparent);
			imagealphablending($rNewImage, true);
		}
		imagecopyresampled($rNewImage, $this->rImageHandle, 0, 0, 0, 0, $this->iWidth, $this->iHeight, $this->iOriginalWidth, $this->iOriginalHeight);
		imagedestroy($this->rImageHandle);
		$this->rImageHandle = $rNewImage;
		$this->iOriginalHeight = $this->iHeight;
		$this->iOriginalWidth = $this->iWidth;
	}

	/**
	* @return an array containing the width and height of a certain text in a specific font and size
	*/
	public static function textSize($sFontFilePath, $sText, $iFontSize) {
		$aImageInfo = imageftbbox($iFontSize, 0, $sFontFilePath, $sText);
		$iWidth = abs($aImageInfo[4] - $aImageInfo[0]);
		$iHeight = abs($aImageInfo[1] - $aImageInfo[5]);
		return array($iWidth, $iHeight);
	}

	public static function imageFromData($sImageData) {
			$rImageResource = @imagecreatefromstring($sImageData);
			if(!$rImageResource) {
				throw new Exception("imagecreatefromstring: Unrecognized image format");
			}
			return new Image($rImageResource);
	}

	public static function imageFromStream($rImageResource) {
		return Image::imageFromData(stream_get_contents($rImageResource));
	}

	public static function emptyImage($iWidth, $iHeight) {
		return new Image(imagecreatetruecolor($iWidth, $iHeight));
	}

	public static function imageFromPath($sPath) {
		return Image::imageFromData(file_get_contents($sPath));
	}

	public static function imageWithText($sText, $sFontFilePath, $iFontSize, $iRed, $iGreen, $iBlue, $iOpacity, $iBackgoundRed = 255, $iBackgoundGreen = 255, $iBackgoundBlue = 255, $iBackgoundAlpha = 0) {
		list($iWidth, $iHeight) = self::textSize($sFontFilePath, $sText, $iFontSize);
		$oImage = self::emptyImage($iWidth+4, $iHeight+4);
		if($iBackgoundAlpha !== 0) {
			imagealphablending($oImage->rImageHandle, false);
			imagesavealpha($oImage->rImageHandle, true);
		}
		$oImage->fill($iBackgoundRed, $iBackgoundGreen, $iBackgoundBlue, $iBackgoundAlpha);
		$oImage->addText($sFontFilePath, $sText, $iOpacity, $iFontSize, $iRed, $iGreen, $iBlue, 0, $oImage->iOriginalHeight-4);
		return $oImage;
	}

	public static function supportsText() {
		return function_exists('imageftbbox');
	}
}

Image::$GD_INFO = gd_info();
