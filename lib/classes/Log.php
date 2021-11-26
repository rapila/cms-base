<?php

class Log {
	public static function singleton() {
		return new Log();
	}

	public function __call(string $name, array $arguments): void {
		ErrorHandler::log($name, ...$arguments);
	}
}
