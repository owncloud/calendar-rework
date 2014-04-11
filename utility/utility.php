<?php
/**
 * Copyright (c) 2014 Georg Ehrke <oc.list@georgehrke.com>
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */
namespace OCA\Calendar\Utility;

use \DateTimeZone;
use \OCA\Calendar\Sabre\VObject\Component;

class Utility {

	public static function slugify($string) {
		$string = preg_replace('~[^\\pL\d\.]+~u', '-', $string);
		$string = trim($string, '-');

		if (function_exists('iconv')) {
			$string = iconv('utf-8', 'us-ascii//TRANSLIT//IGNORE', $string);
		}

		$string = strtolower($string);
		$string = preg_replace('~[^-\w\.]+~', '', $string);
		$string = preg_replace('~\.+$~', '', $string);

		if (empty($string)) {
			return uniqid();
		}

		return $string;
	}

	public static function isTimezoneSupported($timezone) {
		$supportedTimezones = DateTimeZone::listIdentifiers();
		return in_array($timezone, $supportedTimezones);
	}
}