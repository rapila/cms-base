<?php
class TestReferencesFileModule extends FileModule {
	
	private static $LOOSE_FROMS = array();
	private static $LOOSE_TOS = array();

	const DO_CLEANUP = 'do_cleanup';
	
	public function __construct($aRequestPath) {
		if(!Session::user()->getIsAdmin()) {
			die(StringPeer::getString('wns.page.not_found'));
		}
		parent::__construct($aRequestPath);
	}

	public function renderFile() {
		$bCleanup = Manager::usePath() === self::DO_CLEANUP;
		$aReferences = ReferenceQuery::create()->find();
		foreach($aReferences as $oReference) {
			if($oReference->getFrom() === null) {
				if($bCleanup) {
					$oReference->delete();
				} else {
					self::$LOOSE_FROMS[] = $oReference;
				}
			}
			if($oReference && $oReference->getTo() === null) {
				if($bCleanup) {
					$oReference->delete();
				} else {
					self::$LOOSE_TOS[] = $oReference;
				}
			}
		}
		if(count(self::$LOOSE_FROMS) === 0 && count(self::$LOOSE_TOS) === 0) {
			if(!$bCleanup) {
				print StringPeer::getString('test_references.references_are_ok', null, null, array('count' => count($aReferences)));
			} else {
				print StringPeer::getString('test_references.wrong_references_removed');
			}
		} else {
			if(count(self::$LOOSE_FROMS) > 0) {
				print TagWriter::quickTag('p', array(), count(self::$LOOSE_FROMS). StringPeer::getString('test_references.loose_from_references_found'));
			}
			if(count(self::$LOOSE_TOS) > 0) {
				print TagWriter::quickTag('p', array(), count(self::$LOOSE_TOS). StringPeer::getString('test_references.loose_to_references_found'));
			}
			print TagWriter::quickTag('p', array(), TagWriter::quickTag('a', array('href' => LinkUtil::link(array('test_references', self::DO_CLEANUP), 'FileManager')), StringPeer::getString('test_references.remove_loose_ends')));
		}
	}
}