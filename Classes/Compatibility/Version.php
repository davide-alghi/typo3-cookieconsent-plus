<?php

declare(strict_types = 1);

/**
 * This file is part of the TYPO3 CMS extension.
 * The extension name is: Cookie Consent Plus.
 * The extension key is: cookieconsent_plus.
 * Cookie Consent Plus extends dp_cookieconsent TYPO3 extension
 * The developer is Davide Alghi (Abbiategrasso - Italy).
 * Cookie Consent Plus Copyright (C) 2021 Davide Alghi.
 * All Rights Reserved.
 * Cookie Consent Plus is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * Cookie Consent Plus is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Cookie Consent Plus. If not, see https://www.gnu.org/licenses/gpl-3.0.en.html.
 * See the file LICENSE.md for copying conditions.
 * Website: https://www.penguinable.it
 *
 * @category TYPO3
 * @copyright 2021 Davide Alghi
 * @author Davide Alghi <davide@penguinable.it>
 * @license GPLv3
 */

namespace PAD\CookieconsentPlus\Compatibility;

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class Version
{
    const DP_COOKIECONSENT_KEY = 'dp_cookieconsent';

    /**
     * If dp_cookieconsent is the new version
     * returns true
     * else false
     * It is the new version, if it is eq to 11.2.1 or gte to 11.4.0
     *
     * @param none
     * @return bool
     */
    public function isTheNewVersion(): bool
    {
        $version = ExtensionManagementUtility::getExtensionVersion(self::DP_COOKIECONSENT_KEY);
        $result = false;
        if (\version_compare($version, '11.2.1', '==') || \version_compare($version, '11.4.0', '>=')) {
            $result = true;
        }
        return $result;
    }
}
