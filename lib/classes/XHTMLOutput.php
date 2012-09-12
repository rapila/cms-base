<?php

define("XHTML_TEMPLATE_LANGUAGE_IDENTIFIER", TemplateIdentifier::constructIdentifier("language"));
define("XHTML_TEMPLATE_CHARSET_IDENTIFIER", TemplateIdentifier::constructIdentifier("charset"));

define("DOCTYPE_HTML_4_STRICT", "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">\n<html lang=\"".XHTML_TEMPLATE_LANGUAGE_IDENTIFIER."\"{{identifierContext=start;name=className}} class=\"{{className}}\"{{identifierContext=end;name=className}}>\n");
define("DOCTYPE_HTML_4_TRANSITIONAL", "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n<html lang=\"".XHTML_TEMPLATE_LANGUAGE_IDENTIFIER."\"{{identifierContext=start;name=className}} class=\"{{className}}\"{{identifierContext=end;name=className}}>\n");
define("DOCTYPE_HTML_5", "<!DOCTYPE HTML>\n<html lang=\"".XHTML_TEMPLATE_LANGUAGE_IDENTIFIER."\"{{identifierContext=start;name=className}} class=\"{{className}}\"{{identifierContext=end;name=className}}>\n");
define("DOCTYPE_XHTML_STRICT", "<?xml version=\"1.0\" encoding=\"".XHTML_TEMPLATE_CHARSET_IDENTIFIER."\" ?>\n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".XHTML_TEMPLATE_LANGUAGE_IDENTIFIER."\"{{identifierContext=start;name=className}} class=\"{{className}}\"{{identifierContext=end;name=className}}>\n");
define("DOCTYPE_XHTML_TRANSITIONAL", "<?xml version=\"1.0\" encoding=\"".XHTML_TEMPLATE_CHARSET_IDENTIFIER."\" ?>\n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".XHTML_TEMPLATE_LANGUAGE_IDENTIFIER."\"{{identifierContext=start;name=className}} class=\"{{className}}\"{{identifierContext=end;name=className}}>\n");
define("DOCTYPE_XHTML_5", "<?xml version=\"1.0\" encoding=\"".XHTML_TEMPLATE_CHARSET_IDENTIFIER."\" ?>\n<!DOCTYPE HTML>\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".XHTML_TEMPLATE_LANGUAGE_IDENTIFIER."\"{{identifierContext=start;name=className}} class=\"{{className}}\"{{identifierContext=end;name=className}}>\n");


class XHTMLOutput {
	const SETTING_STRICT = 'strict';
	const SETTING_TRANSITIONAL = 'transitional';
	const SETTING_HTML_4_STRICT = 'html4_strict';
	const SETTING_HTML_4_TRANSITIONAL = 'html4_transitional';
	const SETTING_HTML_5 = 'html5';
	const SETTING_XHTML_5 = 'xhtml5';
	const SETTING_NONE = 'none';
	
	private $sCharset;
	private $sContentType;
	private $sLanguage;
	private $sSetting;
	private $bPrintDoctype;
	private $sClassName;
	
	public function __construct($sSetting = null, $bPrintDoctype = true, $sClassName = null, $sLanguage = null) {
		$this->sContentType = "text/html";
		if($sLanguage === null) {
			$sLanguage = Session::language();
		}
		$this->sLanguage = $sLanguage;
		$this->sCharset = Settings::getSetting("encoding", "browser", "utf-8");
		$this->sSetting = $sSetting;
		$this->bPrintDoctype = $bPrintDoctype;
		$this->sClassName = $sClassName;
		if($this->sSetting === null) {
			$this->sSetting = Settings::getSetting('frontend', 'doctype', 'none');
		}
		if($this->sSetting === self::SETTING_NONE || $this->sSetting === self::SETTING_HTML_4_STRICT || $this->sSetting === self::SETTING_HTML_4_TRANSITIONAL || $this->sSetting === self::SETTING_HTML_5) {
			return;
		}
		if(@stristr(@$_SERVER["HTTP_ACCEPT"], "application/xhtml+xml")) {
			if(preg_match("/application\/xhtml\+xml;q=([01]|0\.\d{1,3}|1\.0)/i", $_SERVER["HTTP_ACCEPT"], $matches)) {
				$xhtml_q = $matches[1];
				if(preg_match("/text\/html;q=([01]|0\.\d{1,3}|1\.0)/i", $_SERVER["HTTP_ACCEPT"], $matches)) {
					$html_q = $matches[1];
					if((float)$xhtml_q >= (float)$html_q) {
						$this->sContentType = "application/xhtml+xml";
					}
				}
			} else {
				$this->sContentType = "application/xhtml+xml";
			}
		}
	}
	
	public function render() {
		if($this->sSetting === self::SETTING_NONE) {
			return;
		}
		$sDoctype = "";
		if($this->sContentType == "application/xhtml+xml") {
			switch($this->sSetting) {
				case (self::SETTING_STRICT):
					$sDoctype = DOCTYPE_XHTML_STRICT;
					break;
				case (self::SETTING_TRANSITIONAL):
					$sDoctype = DOCTYPE_XHTML_TRANSITIONAL;
					break;
				case (self::SETTING_XHTML_5):
					ob_start(array($this, "fixCodeForXhtml5"));
					$sDoctype = DOCTYPE_XHTML_5;
					break;
			}
		} else {
			ob_start(array($this, "fixCodeForHtml"));
			switch($this->sSetting) {
				case (self::SETTING_STRICT):
				case (self::SETTING_HTML_4_STRICT):
					$sDoctype = DOCTYPE_HTML_4_STRICT;
					break;
				case (self::SETTING_TRANSITIONAL):
				case (self::SETTING_HTML_4_TRANSITIONAL):
					$sDoctype = DOCTYPE_HTML_4_TRANSITIONAL;
					break;
				case (self::SETTING_XHTML_5):
				case (self::SETTING_HTML_5):
					$sDoctype = DOCTYPE_HTML_5;
					break;
			}
		}
		header("Content-Type: $this->sContentType;charset=$this->sCharset");
		header("Vary: Accept");
		if($this->bPrintDoctype) {
			$this->renderDoctype($sDoctype);
		}
	}
	
	private function renderDoctype($sDoctype) {
		$oTemplate = new Template($sDoctype, null, true, true);
		$oTemplate->replaceIdentifier('language', $this->sLanguage);
		$oTemplate->replaceIdentifier('charset', $this->sCharset);
		$oTemplate->replaceIdentifier('className', $this->sClassName);
		$oTemplate->render();
	}
	
	public function fixCodeForHtml($sBuffer) {
		return preg_replace("!\s*/>!", ">", $sBuffer);
	}
	
	public function fixCodeForXhtml5($sBuffer) {
		return str_replace("&nbsp;", '&#160;', $sBuffer);
	}
}