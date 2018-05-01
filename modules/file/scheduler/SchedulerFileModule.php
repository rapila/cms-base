<?php
class SchedulerFileModule extends FileModule {
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
	}

	public function renderFile() {
		header('Content-Type: text/plain');
		$this->processScheduledActions();
	}

	public function processScheduledActions() {
		$iFailures = 0;
		$iSuccesses = 0;
		$iTotal = 0;
		foreach(ScheduledActionQuery::create()->filterByOverdue()->find() as $oAction) {
			$bResult = $oAction->process();
			if($bResult) {
				$iSuccesses++;
			} else {
				$iFailures++;
			}
			$iTotal++;
		}
		print "Processed $iTotal actions, $iSuccesses sucessfully, $iFailures failed.";
	}
}