<?php
namespace Etobi\CoreAPI\Command;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Georg Ringer <georg.ringer@cyberhouse.at>
 *  (c) 2014 Stefano Kowalke <blueduck@gmx.net>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * API Command Controller
 *
 * @author Georg Ringer <georg.ringer@cyberhouse.at>
 * @author Stefano Kowalke <blueduck@gmx.net>
 * @package Etobi\CoreAPI\Service\SiteApiService
 */
class DatabaseApiCommandController extends CommandController {

	/**
	 * Database compare.
	 * Leave the argument 'actions' empty or use "help" to see the available ones
	 *
	 * @param string $actions List of actions which will be executed
	 */
	public function databaseCompareCommand($actions = '') {
		$service = $this->getService();

		if ($actions === 'help' || strlen($actions) === 0) {
			$actions = $service->databaseCompareAvailableActions();
			foreach ($actions as $number => $action) {
				$this->outputLine('  - ' . $action . ' => ' . $number);
			}
			$this->quit();
		}

		$result = $service->databaseCompare($actions);
		if (empty($result)) {
			$this->outputLine('DB has been compared');
		} else {
			$this->outputLine('DB could not be compared, Error(s): %s', array(LF . implode(LF, $result)));
			$this->quit();
		}
	}

	/**
	 * Returns the service object.
	 *
	 * @return \Etobi\CoreAPI\Service\DatabaseApiService object
	 */
	private function getService() {
		return $this->objectManager->get('Etobi\\CoreAPI\\Service\\DatabaseApiService');
	}
}