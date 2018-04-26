<?php

if(PHP_MAJOR_VERSION < 7) {
	// StringQuery alias supported
	class_alias('TranslationQuery', 'StringQuery', true);
}