<?php

/**
 * Estende il comportamento di DataObject per:
 * - Loggare ogni intervento sul DB. 
 * 
 * PREREQUISITI:
 * Il DataObject deve avere un membro chiamato Title, in modo 
 * da identificarlo in caso di Delete
 * 
 * POSTCONDIZIONI:
 * Ad ogni INSERT, UPDATE e DELETE di DataObject estesi mediante
 * Object::add_extension viene loggata una riga nella tabella LOG
 */
class DataObjectLog extends DataExtension {
	
	private static $logged;

	/**
	 * Logga $msg mediante l'apposito controller
	 * 
	 * @param String $msg
	 */
	private function zlog($msg = null) {
		
		// Evito di loggare se l'ho già fatto
		if (self::$logged !== TRUE) {
			// Verifica necessaria ad evitare loop infiniti
			// e coerenza semantica
			$class = get_class($this->owner);
			if ($class !== 'Log'
							&& $class !== 'DataObject'
							&& $this->owner instanceof DataObject) {

				// Creo il Log
				$log = new Log();
				$log->doLog($msg, $this->owner);
				self::$logged = TRUE;
			}
		}
	}

	/**
	 * Prima della scrittura sul db
	 */
	public function onBeforeWrite() {
		parent::onBeforeWrite();
	}

	/**
	 * Dopo la scrittura sul db
	 */
	public function onAfterWrite() {
		parent::onAfterWrite();
		$this->zlog('Write');
	}

	/**
	 * Prima della cancellazione sul db
	 */
	public function onBeforeDelete() {
		parent::onBeforeDelete();
	}

	/**
	 * Dopo la cancellazione sul db
	 */
	public function onAfterDelete() {
		parent::onAfterDelete();
		$this->zlog('Delete');
	}

}
