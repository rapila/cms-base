<?php

if(PHP_MAJOR_VERSION < 7) {
	// String alias supported
	class_alias('Translation', 'String', true);
}