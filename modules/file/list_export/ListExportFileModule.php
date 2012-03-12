<?php
class ListExportFileModule extends FileModule {
	private $oListWidget;
	private $sWidgetType;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$sSessionKey = Manager::usePath();
		$this->oListWidget = Session::getSession()->getArrayAttributeValueForKey(WidgetModule::WIDGET_SESSION_KEY, $sSessionKey);
		if($this->oListWidget === null) {
			throw new Exception('Invalid list widget session key: '.$sSessionKey);
		}
		$this->sWidgetType = $this->oListWidget->getModuleName();
		if($this->oListWidget->getDelegate() instanceof WidgetModule) {
			$this->sWidgetType = $this->oListWidget->getDelegate()->getModuleName();
		} else if($this->oListWidget->getDelegate() instanceof CriteriaListWidgetDelegate) {
			$this->sWidgetType = $this->oListWidget->getDelegate()->getModelName();
		}
	}
	
	public function renderFile() {
		header('Content-Encoding: chunked');
		header('Connection: keep-alive');
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: ' . sprintf('attachment;filename="%s.csv"', $this->sWidgetType));

		$rCSV = fopen('php://output', 'w');

		$aHeadings = array();
		$aFields = array();
		foreach($this->oListWidget->getSchema() as $aColumn) {
			if(self::includeField($aColumn['display_type'],  $aColumn)) {
				$aFields[] = $aColumn['identifier'];
				if(!isset($aColumn['heading']) || isset($aColumn['heading_filter'])) {
					$aColumn['heading'] = $aColumn['identifier'];
				}
				$aHeadings[] = $aColumn['heading'];
			}
		}

		fputcsv($rCSV, $aHeadings);
		fflush($rCSV);flush();

		foreach($this->oListWidget->completeList() as $aListItem) {
			$aRow = array();
			foreach($aFields as $sFieldIdentifier) {
				if(!isset($aListItem[$sFieldIdentifier])) {
					$aListItem[$sFieldIdentifier] = '';
				}
				$aRow[] = $aListItem[$sFieldIdentifier];
			}
			fputcsv($rCSV, $aRow);
			fflush($rCSV);flush();
		}
	}
	
	private static function includeField($sDisplayType, $aColumn) {
		return $aColumn['has_data'] && $sDisplayType !== ListWidgetModule::DISPLAY_TYPE_DOCUMENT && $sDisplayType !== ListWidgetModule::DISPLAY_TYPE_REORDERABLE;
	}
}