<?php
/**
 * Denies CUD to certain models based on roles/rights.
 *
 * @package    propel.generator.behavior
 */
class DenyableBehaviour extends Behavior {
	protected $parameters = array(
		'mode' => 'allow', //possible values: allow, valid_user, backend_user, admin_user, administrator
		'role_key' => '' //Uses `mode` if no role given, role-based operation mode otherwise
	);

	/**
	 * This method is automatically called on database behaviors when the database model is finished
	 * Propagate the behavior to the tables of the database
	 * Override this method to have a database behavior do something special
	 */
	public function modifyDatabase() {
		foreach ($this->getDatabase()->getTables() as $oTable) {
			if($oTable->hasBehavior($this->getName())) {
				continue;
			}
			$oTable->addBehavior(clone $this);
		}
	}

	public function preInsert($oBuilder) {
		return $this->addPre('insert', $oBuilder);
	}

	public function preUpdate($oBuilder) {
		return $this->addPre('update', $oBuilder);
	}

	public function preDelete($oBuilder) {
		return $this->addPre('delete', $oBuilder);
	}

	private function addPre($sAction, $oBuilder) {
		$sPeerClassname = $oBuilder->getStubPeerBuilder()->getClassname();
		$sMode = $this->getParameter('role_key') ? 'by_role' : $this->getParameter('mode');
		if($sMode === 'allow') {
			$sMode = 'custom';
		}
		$sActionModeEscaped = '"'.$sAction.'.'.$sMode.'"';
		$sModeEscaped = '"'.addslashes($sMode).'"';
		$sRoleKeyEscaped = '"'.addslashes($this->getParameter('role_key')).'"';
		return 'if(!('.$sPeerClassname.'::isIgnoringRights() || '.$sPeerClassname.'::mayOperateOn(Session::getSession()->getUser(), $this, "'.$sAction.'"))) {
	throw new NotPermittedException('.$sActionModeEscaped.', array("role_key" => '.$sRoleKeyEscaped.'));
}
';
	}

	public function staticAttributes($oBuilder) {
		$sAttrs = '';
		$sAttrs .= $this->addIgnoreProp();
		return $sAttrs;
	}

	public function staticMethods($oBuilder) {
		$sMethods = '';
		$sMethods .= $this->addIgnoreMethod();
		$sMethods .= $this->addIsIgnoringMethod();
		$sMethods .= $this->addMayMethod();
		return $sMethods;
	}

	private function addIgnoreProp() {
		return 'private static $bIgnoreRights = false;';
	}

	private function addIgnoreMethod() {
		return 'public static function ignoreRights($bIgnore = true) {
	$this->bIgnoreRights = $bIgnore;
}
';
	}
	
	private function addIsIgnoringMethod() {
		return 'public static function isIgnoringRights() {
	return $this->bIgnoreRights;
}
';
	}

	private function addMayMethod() {
		if($this->getParameter('role_key')) {
			return $this->addMayMethodForRoleKey($this->getParameter('role_key'));
		}
		if($this->getParameter('mode') === 'valid_user') {
			return $this->addMayMethodForValidUser();
		}
		if($this->getParameter('mode') === 'backend_user') {
			return $this->addMayMethodForBackendUser();
		}
		if($this->getParameter('mode') === 'admin_user') {
			return $this->addMayMethodForAdminUser();
		}
		if($this->getParameter('mode') === 'administrator') {
			return $this->addMayMethodForAdministrator();
		}

		return $this->addMayMethodForAllow();
	}

	private function addMayMethodForRoleKey($sRoleKey) {
		$sOwnRoleKey = '"'.addslashes($sRoleKey.'-own').'"';
		$sRoleKey = '"'.addslashes($sRoleKey).'"';
		return 'public static function mayOperateOn($oUser, $mObject, $sOperation) {
	if($oUser === null) {
		return false;
	}
	if($oUser->getIsAdmin()) {
		return true;
	}
	if($oUser->hasRole('.$sRoleKey.') {
		return true;
	}
	if(!$oUser->hasRole('.$sOwnRoleKey.')) {
		return false;
	}
	if($sOperation === "create") {
		return true;
	}
	if($mObject instanceof User) {
		return $mObject->getId() === $oUser->getId();
	}
	return $mObject->getCreatedBy() === $oUser->getId();
}
';
	}
	private function addMayMethodForValidUser() {
		return 'public static function mayOperateOn($oUser, $mObject, $sOperation) {
	return $oUser !== null;
}
';
	}
	private function addMayMethodForBackendUser() {
		return 'public static function mayOperateOn($oUser, $mObject, $sOperation) {
	if($oUser === null) {
		return false;
	}
	if($oUser->getIsAdmin()) {
		return true;
	}
	return $oUser->getIsBackendLoginEnabled();
}
';
	}
	private function addMayMethodForAdminUser() {
		return 'public static function mayOperateOn($oUser, $mObject, $sOperation) {
	if($oUser === null) {
		return false;
	}
	if($oUser->getIsAdmin()) {
		return true;
	}
	return $oUser->getIsAdminLoginEnabled();
}
';
	}
	private function addMayMethodForAdministrator() {
		return 'public static function mayOperateOn($oUser, $mObject, $sOperation) {
	if($oUser === null) {
		return false;
	}
	return $oUser->getIsAdmin();
}
';
	}
	private function addMayMethodForAllow() {
		return 'public static function mayOperateOn($oUser, $mObject, $sOperation) {
	return true;
}
';
	}
}
