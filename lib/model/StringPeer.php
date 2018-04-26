<?php

if(PHP_MAJOR_VERSION < 7) {
	// StringPeer alias supported
	class_alias('TranslationPeer', 'StringPeer', true);
}