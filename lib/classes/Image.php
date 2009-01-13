<?php

class Image {
  private $rImageHandle;
  private $iWidth = null;
  private $iHeight = null;
  private $sFileType = "jpeg";
  private $fScalingFactor = 1.0;
  
  private $iOriginalWidth;
  private $iOriginalHeight;
  
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
        $bWidhIsLarger = $fFactorOnScaleToWidth > $fFactorOnScaleToHeight;
        $this->$fScalingFactor = ($iMode === self::RESIZE_TO_LARGER_VALUE) ? 
                          ($bWidhIsLarger ? $fFactorOnScaleToWidth : $fFactorOnScaleToHeight) : 
                          ($bWidhIsLarger ? $fFactorOnScaleToHeight : $fFactorOnScaleToWidth);
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
  
  public function addText($sFontFilePath, $sText, $iOpacity, $iFontSize, $iRed, $iGreen, $iBlue) {
    imagefttext($this->rImageHandle, $iFontSize, 0, 0, $this->iOriginalHeight-4, imagecolorallocatealpha($this->rImageHandle, $iRed, $iGreen, $iBlue, $iOpacity), $sFontFilePath, $sText);
  }
  
  public function addWatermark($sFontFilePath, $sText) {
    $iFontSize = $this->iOriginalHeight/10;
    $iAngle = 0;
    $aImageInfo = imageftbbox($iFontSize, $iAngle, $sFontFilePath, $sText);
    $iWidth = $aImageInfo[4] - $aImageInfo[6] + $this->iOriginalWidth/20;
    $iHeight = $this->iOriginalHeight/20;
    
    imagefttext($this->rImageHandle, $iFontSize, $iAngle, $this->iOriginalWidth-$iWidth, $this->iOriginalHeight-$iHeight, imagecolorallocatealpha($this->rImageHandle, 255, 255, 255, 30), $sFontFilePath, $sText);
  }
  
  public function fill($iRed, $iGreen, $iBlue) {
    imagefill($this->rImageHandle, 0, 0, imagecolorallocate($this->rImageHandle, $iRed, $iGreen, $iBlue));
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
      $sFilePath = $oCache->getFilePath();
      $this->save($sFilePath);
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
        return imagepng($this->rImageHandle);
        break;
    }
  }
  
  public function resizeImage() {
    $rNewImage = imagecreatetruecolor($this->iWidth, $this->iHeight);
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
    return new Image(imagecreatefromstring($sImageData));
  }
  
  public static function emptyImage($iWidth, $iHeight) {
    return new Image(imagecreatetruecolor($iWidth, $iHeight));
  }
  
  public static function imageFromPath($sPath) {
    return Image::imageFromData(file_get_contents($sPath));
  }
  
  public static function imageWithText($sText, $sFontFilePath, $iFontSize, $iRed, $iGreen, $iBlue, $iOpacity, $iBackgoundRed = 255, $iBackgoundGreen = 255, $iBackgoundBlue = 255) {
    list($iWidth, $iHeight) = self::textSize($sFontFilePath, $sText, $iFontSize);
    $oImage = self::emptyImage($iWidth+2, $iHeight+2);
    $oImage->fill($iBackgoundRed, $iBackgoundGreen, $iBackgoundBlue);
    $oImage->addText($sFontFilePath, $sText, $iOpacity, $iFontSize, $iRed, $iGreen, $iBlue);
    return $oImage;
  }
}
