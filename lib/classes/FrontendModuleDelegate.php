<?php

interface FrontendModuleDelegate {
	public function useTransformedData();
	public function referencing();
	public function key();
	public function setData($mData);
	public function data();
}
