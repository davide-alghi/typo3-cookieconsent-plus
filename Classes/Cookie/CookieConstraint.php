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

use \TYPO3\CMS\Core\Database\ConnectionPool;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \PAD\CookieconsentPlus\Cookie\CookieManager;

class CookieConstraint
{
    const ISCOOKIESDEPENDENT_OFF = 0;
    const ISCOOKIESDEPENDENT_ON = 1;
    const CONDITIONTYPE_VALUE_SHOWAND = 'showand';
    const CONDITIONTYPE_VALUE_SHOWOR = 'showor';
    const CONDITION_VALUE_ANYVALUE = 'anyvalue';
    const CONDITION_VALUE_DENIED = 'denied';
    const CONDITION_VALUE_ACCEPTED = 'accepted';

    /**
     * Returns enable fields (constraints) for cookies dependency
     *
     * @param string $table
     * @param array $enableFields - cookieconsent enable fields
     * @return string
     */
    public static function getCookiesConstraints(string $table, array $enableFields): string
    {
        $constraints = [];
        $cookieManager = GeneralUtility::makeInstance(CookieManager::class);
        $isStatisticsOn = $cookieManager->isStatisticsOn();
        $isMarketingOn = $cookieManager->isMarketingOn();
        $statisticsValues = [
            self::CONDITION_VALUE_ANYVALUE,
            $isStatisticsOn ? self::CONDITION_VALUE_ACCEPTED : self::CONDITION_VALUE_DENIED,
        ];
        $marketingValues = [
            self::CONDITION_VALUE_ANYVALUE,
            $isMarketingOn ? self::CONDITION_VALUE_ACCEPTED : self::CONDITION_VALUE_DENIED,
        ];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $expressionBuilder = $queryBuilder->expr();
        $statisticsValues = array_map([$expressionBuilder, 'literal'], $statisticsValues);
        $marketingValues = array_map([$expressionBuilder, 'literal'], $marketingValues);
        $constraints[] = $expressionBuilder->eq(
            $enableFields['iscookiesdependent'],
            self::ISCOOKIESDEPENDENT_OFF
        );
        $constraints[] = $expressionBuilder->and(
            $expressionBuilder->eq(
                $enableFields['iscookiesdependent'],
                self::ISCOOKIESDEPENDENT_ON
            ),
            $expressionBuilder->eq(
                $enableFields['conditiontype'],
                $expressionBuilder->literal(self::CONDITIONTYPE_VALUE_SHOWAND)
            ),
            $expressionBuilder->and(
                $expressionBuilder->in(
                    $enableFields['statisticscondition'],
                    $statisticsValues
                ),
                $expressionBuilder->in(
                    $enableFields['marketingcondition'],
                    $marketingValues
                ),
            )
        );
        $constraints[] = $expressionBuilder->and(
            $expressionBuilder->eq(
                $enableFields['iscookiesdependent'],
                self::ISCOOKIESDEPENDENT_ON
            ),
            $expressionBuilder->eq(
                $enableFields['conditiontype'],
                $expressionBuilder->literal(self::CONDITIONTYPE_VALUE_SHOWOR)
            ),
            $expressionBuilder->or(
                $expressionBuilder->in(
                    $enableFields['statisticscondition'],
                    $statisticsValues
                ),
                $expressionBuilder->in(
                    $enableFields['marketingcondition'],
                    $marketingValues
                ),
            )
        );
        return strval($expressionBuilder->or(...$constraints));
    }
}
