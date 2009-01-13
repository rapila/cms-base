<?php

class ResourceFinder {
  const SEARCH_INT_ONLY = 1;
  const SEARCH_EXT_ONLY = 2;
  const SEARCH_INT_FIRST = 3;
  const SEARCH_EXT_FIRST = 4;
  
  private static function getDefaultFlag($bFindAll=false) {
    if($bFindAll) {
      return self::SEARCH_INT_FIRST;
    }
    return self::SEARCH_EXT_FIRST;
  }
  
  private static function processArguments(&$mRelativePath, &$iFlag, $bFindAll=false) {
    if($iFlag === null) {
      $iFlag = self::getDefaultFlag($bFindAll);
    }
    
    if(is_array($mRelativePath) && array_key_exists('flag', $mRelativePath)) {
      $iFlag = constant("ResourceFinder::".$mRelativePath['flag']);
      unset($mRelativePath['flag']);
    }
    
    if(is_string($mRelativePath)) {
      $mRelativePath = explode('/', $mRelativePath);
    } else if(!is_array($mRelativePath)) {
      throw new Exception("Exception in ResourceFinder: given path is neither array nor string");
    }
  }
  
  public static function findResource($mRelativePath, $iFlag = null, $bByExpressions = false, $bFindAll = false) {
    if($bByExpressions) {
      $bFindAll = true;
    }
    self::processArguments($mRelativePath, $iFlag, $bFindAll);
    $mResult = array();
    foreach(self::buildFindMethodList($iFlag) as $sMethod) {
      $sPath = call_user_func(array('ResourceFinder', $sMethod), $mRelativePath, $bByExpressions);
      if($sPath) {
        if($bFindAll) {
          if(!$bByExpressions) {
            $sPath = array($sPath);
          }
          $mResult = array_merge($mResult, $sPath);
        } else {
          return $sPath;
        }
      }
    }
    
    if($bFindAll) {
      return $mResult;
    }
    
    return null;
  }
  
  public static function findAllResources($mRelativePath, $iFlag = null, $bByExpressions = false) {
    return self::findResource($mRelativePath, $iFlag, $bByExpressions, true);
  }
  
  public static function findResourceByExpressions($aExpressions, $iFlag = null) {
    return self::findResource($aExpressions, $iFlag, true);
  }
  
  public static function buildFindMethodList($iFlag, $bByExpressions = false) {
    $bIntFirst = $iFlag === self::SEARCH_INT_ONLY || $iFlag === self::SEARCH_INT_FIRST;
    
    if($iFlag === self::SEARCH_INT_ONLY || $iFlag === self::SEARCH_EXT_ONLY) {
      return array($bIntFirst ? 'findInInt' : 'findInExt');
    }
    
    return array($bIntFirst ? 'findInInt' : 'findInExt',
                 $bIntFirst ? 'findInExt' : 'findInInt');
  }
  
  public static function isInt($mRelativePath, $iFlag = null) {
    self::processArguments($mRelativePath, $iFlag);
    if($iFlag === self::SEARCH_EXT_ONLY) {
      return false;
    }
    if($iFlag === self::SEARCH_EXT_FIRST && self::findInExt($mRelativePath) !== null) {
      return false;
    }
    return self::findInInt($mRelativePath) !== null;
  }
  
  public static function listResourcesInAllDirs($mRelativePath) {
    $iFlag = null;
    self::processArguments($mRelativePath, $iFlag);
    
    return Util::getFolderContents(self::findInInt($mRelativePath)) + Util::getFolderContents(self::findInExt($mRelativePath));
  }
  
  private static function findInInt($aPath, $bByExpressions = false) {
    if(!isset($aPath[0]))
      debug_print_backtrace();
    if($aPath[0] === DIRNAME_LANG || $aPath[0] === DIRNAME_TEMPLATES || $aPath[0] === DIRNAME_WEB) {
      array_unshift($aPath, DIRNAME_RESOURCES);
    } else if($aPath[0] === DIRNAME_CLASSES || $aPath[0] === DIRNAME_VENDOR || $aPath[0] === DIRNAME_MODEL) {
      array_unshift($aPath, DIRNAME_INCLUDES);
    }
    return $bByExpressions ? self::findInPathByExpressions($aPath, MAIN_DIR) : self::findInPath($aPath, MAIN_DIR);
  }
  
  private static function findInExt($aPath, $bByExpressions = false) {
    if($aPath[0] === DIRNAME_RESOURCES) {
      array_shift($aPath);
    }
    return $bByExpressions ? self::findInPathByExpressions($aPath, SITE_DIR) : self::findInPath($aPath, SITE_DIR);
  }
  
  private static function findInPath($aPath, $sPath) {
    foreach($aPath as $sPathElement) {
      if(file_exists("$sPath/$sPathElement")) {
        $sPath .= "/$sPathElement";
      } else {
        return null;
      }
    }
    return $sPath;
  }
  
  private static function findInPathByExpressions($aExpressions, $sPath, $sRelativePath = null) {
    if(count($aExpressions) === 0) {
      return array();
    }
    
    $aResult = array();
    $sPathExpression = $aExpressions[0];
    $sParentName = null;
    if($sRelativePath !== null) {
      $sParentName = explode('/', $sRelativePath);
      $sParentName = $sParentName[count($sParentName)-1];
    }
    
    if($sParentName !== null) {
      $sPathExpression = str_replace('${parent_name}', $sParentName, $sPathExpression);
      $sPathExpression = str_replace('${parent_name_camelized}', Util::camelize($sParentName, true), $sPathExpression);
    }
    
    if(!Util::startsWith($sPathExpression, "/")) {
      $sPathExpression = '/^'.preg_quote($sPathExpression, '/').'$/';
    }
    
    foreach(Util::getFolderContents($sPath) as $sFileName => $sFilePath) {
      if(preg_match($sPathExpression, $sFileName) !== 0) {
        $sNextRelativePath = $sFileName;
        if($sRelativePath !== null) {
          $sNextRelativePath = "$sRelativePath/$sFileName";
        }
        if(count($aExpressions) > 1) {
          $aNewResult = self::findInPathByExpressions(array_slice($aExpressions, 1), $sFilePath, $sNextRelativePath);
          $aResult = array_merge($aResult, $aNewResult);
        } else {
          $aResult[$sNextRelativePath] = $sFilePath;
        }
      }
    }
    return $aResult;
  }
  
  //Helper function for classes that are given a filename, base path and path name
  public static function parsePathArguments($sBasicDirname = null, $mPath = null, $sFileName = null) {
    if($mPath === null) {
      $mPath = array();
    } else if(is_string($mPath)) {
      $mPath = explode("/", $mPath);
    }
    
    if($sBasicDirname !== null) {
      array_unshift($mPath, $sBasicDirname);
    }
    
    if($sFileName !== null) {
      $mPath = array_merge($mPath, explode('/', $sFileName));
    }
    
    return $mPath;
  }
}