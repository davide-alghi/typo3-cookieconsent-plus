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

class CookieManager
{
    const COOKIECONSENTSTATUS_NAME = 'cookieconsent_status';
    const COOKIECONSENTSTATUS_OPTOUT_NAME = 'dp_cookieconsent_status';
    const COOKIEDISMISSVALUE = 'dismiss';
    const COOKIEALLOWVALUE = 'allow';
    const COOKIEDENYVALUE = 'deny';
    protected $cookieValue = '';
    protected $optoutCookieValue = '';
    protected $cookieStatus = false;
    protected $mandatoryCookieStatus = false;
    protected $statisticsCookieStatus = false;
    protected $marketingCookieStatus = false;

    /**
     * Sets statuses from cookies value
     * 
     * @param void
     */
    public function __construct()
    {
        if (isset($_COOKIE[self::COOKIECONSENTSTATUS_NAME])) {
            $this->cookieValue = $_COOKIE[self::COOKIECONSENTSTATUS_NAME];
            if ($this->cookieValue) {
                $this->cookieStatus = $_COOKIE[self::COOKIECONSENTSTATUS_NAME] == self::COOKIEDENYVALUE ? false : true;
                if ($this->cookieStatus) {
                    $this->mandatoryCookieStatus = true;
                    if ($this->cookieValue != self::COOKIEDISMISSVALUE && isset($_COOKIE[self::COOKIECONSENTSTATUS_OPTOUT_NAME])) {
                        $this->optoutCookieValue = $_COOKIE[self::COOKIECONSENTSTATUS_OPTOUT_NAME];
                        $optoutCookieValueArray = json_decode($_COOKIE[self::COOKIECONSENTSTATUS_OPTOUT_NAME], true);
                        $this->statisticsCookieStatus = (boolean) $optoutCookieValueArray['dp--cookie-statistics'];
                        $this->marketingCookieStatus = (boolean) $optoutCookieValueArray['dp--cookie-marketing'];
                    } else {
                        $this->statisticsCookieStatus = true;
                        $this->marketingCookieStatus = true;
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
     * in array format
     * 
     * @param void
     * @return array
     */
    public function getOptoutCookieValue(): array
    {
        return json_decode($this->optoutCookieValue, true);
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
     * Returns mandatory cookies status
     * accepted: true, denied: false
     * 
     * @param void
     * @return bool
     */
    public function isMandatoryOn(): bool
    {
        return $this->mandatoryCookieStatus;
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
