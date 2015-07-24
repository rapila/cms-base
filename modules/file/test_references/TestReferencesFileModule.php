<?php
class TestReferencesFileModule extends FileModule {

	private static $REFERENCES_WITHOUT_FROM = array();
	private static $REFERENCES_WITHOUT_TO = array();

	const DO_CLEANUP = 'do_cleanup';

	public function __construct($aRequestPath) {
		if(!Session::user() || !Session::user()->getIsAdmin()) {
			die(StringPeer::getString('wns.page.not_found'));
		}
		parent::__construct($aRequestPath);
	}

	public function renderFile() {
		$bCleanup = Manager::usePath() === self::DO_CLEANUP;
		$aReferences = ReferenceQuery::create()->find();
		self::checkReferences($aReferences, $bCleanup);

		if(count(self::$REFERENCES_WITHOUT_FROM) === 0 && count(self::$REFERENCES_WITHOUT_TO) === 0) {
			if(!$bCleanup) {
				print StringPeer::getString('test_references.references_are_ok', null, null, array('count' => count($aReferences)));
			} else {
				print StringPeer::getString('test_references.wrong_references_removed');
				print TagWriter::quickTag('p', array(), TagWriter::quickTag('a', array('href' => LinkUtil::link(array('test_references'), 'FileManager')), StringPeer::getString('test_references.test_again')));
			}
		} else {
			if(count(self::$REFERENCES_WITHOUT_FROM) > 0) {
				print TagWriter::quickTag('p', array(), count(self::$REFERENCES_WITHOUT_FROM). StringPeer::getString('test_references.loose_from_references_found'));
				foreach(self::$REFERENCES_WITHOUT_FROM as $oReference) {
					print TagWriter::quickTag('p', array(), $oReference->getFromModelName().'/'.$oReference->getFromId());
				}
			}
			if(count(self::$REFERENCES_WITHOUT_TO) > 0) {
				print TagWriter::quickTag('p', array(), count(self::$REFERENCES_WITHOUT_TO). StringPeer::getString('test_references.loose_to_references_found'));
				foreach(self::$REFERENCES_WITHOUT_TO as $oReference) {
					print TagWriter::quickTag('p', array(), $oReference->getToModelName().'/'.$oReference->getToId());
				}
			}
			print TagWriter::quickTag('p', array(), TagWriter::quickTag('a', array('href' => LinkUtil::link(array('test_references', self::DO_CLEANUP), 'FileManager')), StringPeer::getString('test_references.remove_loose_ends')));
		}
	}

	public static function checkReferences($aReferences, $bCleanup = false) {
		foreach($aReferences as $oReference) {
			if($oReference->getFrom() === null) {
				if($bCleanup) {
					$oReference->delete();
				} else {
					self::$REFERENCES_WITHOUT_FROM[] = $oReference;
				}
			}
			if($oReference && $oReference->getTo() === null) {
				if($bCleanup) {
					$oReference->delete();
				} else {
					self::$REFERENCES_WITHOUT_TO[] = $oReference;
				}
			}
		}
	}
}