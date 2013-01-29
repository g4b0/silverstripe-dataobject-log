<?php

/**
 * Data Object
 */
class Log extends DataObject {

	static $db = array(
			'Date' => 'Date',
			'IPaddr' => 'Varchar(15)',
			'Action' => 'Varchar',
			'Title' => 'Varchar',
			'Class' => 'Varchar',
			'DoID' => 'Int',
	);
	static $searchable_fields = array(
			'Date',
			'IPaddr',
			'Action',
			'Class',
			'DoID',
			'Title'
	);
	static $summary_fields = array(
			'Date' => 'Date',
			'IPaddr' => 'IP',
			'Action' => 'Action',
			'Class' => 'Class',
			'DoID' => 'ID'
,			'Title' => 'Title',
	);
	static $has_one = array(
			'Member' => 'Member',
	);

	/**
	 * Questo metodo deve essere definito, altrimenti 
	 * mi va in errore il ModelAdmin. 
	 * 
	 * @todo Verificare eventuale bug di SS
	 * @return boolean
	 */
	public function fortemplate() {
		return true;
	}
	
	/**
	 * Logga sul db
	 * 
	 * @param String $msg		Stringa da loggare
	 * @param String $do		DataObject da loggare
	 * @return boolean
	 */
	public function doLog($msg = null, $do = null) {

		$log = new Log();
		$oDate = new DateTime();
		$sDate = $oDate->format('Y-m-d H:i:s');
		$log->setField('Date', $sDate);
		$log->setField('IPaddr', $_SERVER['REMOTE_ADDR']);
		$log->setField('MemberID', Member::currentUserID());
		$log->setField('Action', $msg);
		$id = $this->owner->ID;
			$title = $this->owner->getField('Title');
		$log->setField('Title', $do->getField('Title'));
		$log->setField('Class', get_class($do));
		$log->setField('DoID', $do->ID);
		
		$this->extend('doLog', $log, $do);

		// Scrivo il Log
		$log->write();

		return true;
	}

}

class Log_Controller extends ContentController {

}