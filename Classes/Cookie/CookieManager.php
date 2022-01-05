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

namespace PAD\CookieconsentPlus\Cookie;

use \PAD\CookieconsentPlus\Compatibility\Version;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class CookieManager
{
    const COOKIECONSENTSTATUS_NAME = 'cookieconsent_status';
    const COOKIECONSENTSTATUS_DP_NAME = 'dp_cookieconsent_status';
    const COOKIEDISMISSVALUE = 'dismiss';
    const COOKIEALLOWVALUE = 'allow';
    const COOKIEDENYVALUE = 'deny';
    const COOKIEDIALOGSTATUSOPEN = 'open';
    const COOKIEDIALOGSTATUSAPPROVED = 'approved';

    protected $cookieValue = '';
    protected $dpCookieValue = [];
    protected $cookieStatus = false;
    protected $dpCookieStatus = '';
    protected $statisticsCookieStatus = false;
    protected $marketingCookieStatus = false;

    /**
     * Sets statuses from cookies value
     *
     * @param void
     */
    public function __construct()
    {
        $versionCompatibility = GeneralUtility::makeInstance(Version::class);
        if ($versionCompatibility->isTheNewVersion()) { // dp_cookieconsent new version
            if (isset($_COOKIE[self::COOKIECONSENTSTATUS_DP_NAME])) {
                $this->cookieValue = '';
                $this->cookieStatus = false;
                $this->dpCookieValue = json_decode($_COOKIE[self::COOKIECONSENTSTATUS_DP_NAME], true);
                $this->dpCookieStatus = $this->dpCookieValue['status'];
                if ($this->dpCookieStatus == self::COOKIEDIALOGSTATUSAPPROVED) {
                    if (is_array($this->dpCookieValue['checkboxes'])) {
                        foreach ($this->dpCookieValue['checkboxes'] as $key => $value) {
                            switch ($value['name']) {
                                case 'statistics':
                                    $this->statisticsCookieStatus = (boolean) $value['checked'];
                                    break;

                                case 'marketing':
                                    $this->marketingCookieStatus = (boolean) $value['checked'];
                                    break;
                            }
                        }
                    }
                } else {
                    $this->statisticsCookieStatus = false;
                    $this->marketingCookieStatus = false;
                }
            }
        } else { // dp_cookieconsent old version
            if (isset($_COOKIE[self::COOKIECONSENTSTATUS_NAME])) {
                $this->cookieValue = $_COOKIE[self::COOKIECONSENTSTATUS_NAME];
                if ($this->cookieValue) {
                    $this->cookieStatus = $_COOKIE[self::COOKIECONSENTSTATUS_NAME] == self::COOKIEDENYVALUE ? false : true;
                    if ($this->cookieStatus) {
                        if ($this->cookieValue != self::COOKIEDISMISSVALUE && isset($_COOKIE[self::COOKIECONSENTSTATUS_DP_NAME])) {
                            $this->dpCookieValue = json_decode($_COOKIE[self::COOKIECONSENTSTATUS_DP_NAME], true);
                            $this->statisticsCookieStatus = (boolean) $this->dpCookieValue['dp--cookie-statistics'];
                            $this->marketingCookieStatus = (boolean) $this->dpCookieValue['dp--cookie-marketing'];
                        } else {
                            $this->statisticsCookieStatus = true;
                            $this->marketingCookieStatus = true;
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns cookieconsent_status cookie value
     *
     * @param void
     * @return string
     */
    public function getCookieValue(): string
    {
        return $this->cookieValue;
    }

    /**
     * Returns dp_cookieconsent_status cookie value
     *
     * @param void
     * @return array
     */
    public function getDpCookieValue(): array
    {
        return $this->dpCookieValue;
    }

    /**
     * Returns cookies status
     *
     * @param void
     * @return bool
     */
    public function getCookieStatus(): bool
    {
        return $this->cookieStatus;
    }

    /**
     * Returns dp cookies status
     *
     * @param void
     * @return string
     */
    public function getDpCookieStatus(): string
    {
        return $this->dpCookieStatus;
    }

    /**
     * Returns statistics cookies status
     * accepted: true, denied: false
     *
     * @param void
     * @return bool
     */
    public function isStatisticsOn(): bool
    {
        return $this->statisticsCookieStatus;
    }

    /**
     * Returns marketing cookies status
     * accepted: true, denied: false
     *
     * @param void
     * @return bool
     */
    public function isMarketingOn(): bool
    {
        return $this->marketingCookieStatus;
    }

    /**
     * Removes cookie with defined
     * name, path and domain
     *
     * @param string $name - the cookie name
     * @param string $path - the path for which the cookie is valid
     * @param string $domain - the domain from which the cookie comes
     * @return void
     */
    public function removeCookie(string $name, string $path, string $domain): void
    {
        setcookie($name, '', time() - 3600, $path, $domain);
    }
}
