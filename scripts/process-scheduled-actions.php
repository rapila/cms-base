#!/usr/bin/env php
<?php

require(dirname(__FILE__).'/../lib/inc.php');

$oScheduler = new SchedulerFileModule(null);
$oScheduler->processScheduledActions();

print "\n";
