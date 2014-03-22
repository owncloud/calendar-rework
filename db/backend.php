<?php
/**
 * Copyright (c) 2014 Georg Ehrke <oc.list@georgehrke.com>
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */
namespace OCA\Calendar\Db;

use \OCA\Calendar\Backend\CalendarInterface;

class Backend extends Entity {

	public $id;
	public $backend;
	public $classname;
	public $arguments;
	public $enabled;

	public $api;

	/**
	 * @brief init Backend object with data from db row
	 * @param array $fromRow
	 */
	public function __construct($fromRow=null){
		if($fromRow){
			$this->fromRow($fromRow);
		}

		$this->api = null;
	}

	/**
	 * registers an API for a backend
	 * @param CalendarInterface $api
	 * @return Backend
	 */
	public function registerAPI(CalendarInterface $api){
		$this->api = $api;
		return $this;
	}


	/**
	 * @brief take data from VObject and put into this Calendar object
	 * @return VCalendar Object
	 */
	public function fromVObject(VCalendar $vcalendar) {
		throw new Exception();
	}

	/**
	 * @brief get VObject from Calendar Object
	 * @return VCalendar Object
	 */
	public function getVObject() {
		throw new Exception();
	}

	/**
	 * disables a backend
	 * @return Backend
	 */
	public function disable() {
		$this->setEnabled(false);
		return $this;
	}

	/**
	 * enables a backend
	 * @return Backend
	 */
	public function enable() {
		$this->setEnabled(true);
		return $this;
	}

	/**
	 * @brief check if object is valid
	 * @return boolean
	 */
	public function isValid() {
		if(is_string($this->backend) === false) {
			return false;
		}
		if(trim($this->backend) === '') {
			return false;
		}

		if(is_string($this->classname) === false) {
			return false;
		}
		if(class_exists($this->classname) === false) {
			return false;
		}

		if(is_array($this->arguments) === false || $this->arguments === null) {
			return false;
		}

		if(is_bool($this->enabled) === false) {
			return false;
		}

		if(($this->api instanceof CalendarInterface) === false || $this->api !== null) {
			return false;
		}

		return true;
	}
}