<?php
/**
 * class FileManager
 * @package manager
 */
class FileManager extends Manager {

	private $oModule;

	/**
	 * __construct()
	 */
	public function __construct() {
		parent::__construct();
		$sPath = self::usePath();
		try {
			$this->oModule = FileModule::getModuleInstance($sPath, self::$REQUEST_PATH);
		} catch (Exception $e) {
			throw new UserError('wns.error.user.invalid_file_module', array('name' => $sPath));
		}
		$this->oModule->renderFile();
	} // __construct()

	/**
	 * render()
	 */
	public function render() {
	} // render()
} // class FileManager