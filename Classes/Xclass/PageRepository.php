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

namespace PAD\CookieconsentPlus\Xclass;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Domain\Repository\PageRepository as CmsPageRepository;
use PAD\CookieconsentPlus\Cookie\CookieManager;

class PageRepository extends CmsPageRepository
{
    const ISCOOKIESDEPENDENT_FIELD = 'tx_cookieconsentplus_iscookiesdependent';
    const ISCOOKIESDEPENDENT_OFF = 0;
    const ISCOOKIESDEPENDENT_ON = 1;
    const CONDITIONTYPE_FIELD = 'tx_cookieconsentplus_conditiontype';
    const CONDITIONTYPE_VALUE_SHOWAND = 'showand';
    const CONDITIONTYPE_VALUE_SHOWOR = 'showor';
    const CONDITIONTYPE_VALUE_HIDEAND = 'hideand';
    const CONDITIONTYPE_VALUE_HIDEOR = 'hideor';
    const MANDATORYCONDITION_FIELD = 'tx_cookieconsentplus_mandatorycondition';
    const STATISTICSCONDITION_FIELD = 'tx_cookieconsentplus_statisticscondition';
    const MARKETINGCONDITION_FIELD = 'tx_cookieconsentplus_marketingcondition';
    const CONDITION_VALUE_ANYVALUE = 'anyvalue';
    const CONDITION_VALUE_DENIED = 'denied';
    const CONDITION_VALUE_ACCEPTED = 'accepted';

    protected $allowedTables = [
        'pages',
        'tt_content',
    ];

    /**
     * Returns enable fields (constraints) for cookies dependency
     * 
     * @param string $table - table on which to create the query
     * @return string
     */
    protected function getCookiesEnableFields($table): string
    {
        $constraints = [];
        if (in_array($table, $this->allowedTables)) {
            $cookieManager = GeneralUtility::makeInstance(CookieManager::class);
            $isMandatoryOn = $cookieManager->isMandatoryOn();
            $isStatisticsOn = $cookieManager->isStatisticsOn();
            $isMarketingOn = $cookieManager->isMarketingOn();
            $mandatoryValues = [
                self::CONDITION_VALUE_ANYVALUE,
                $isMandatoryOn ? self::CONDITION_VALUE_ACCEPTED : self::CONDITION_VALUE_DENIED,
            ];
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
            $mandatoryValues = array_map([$expressionBuilder, 'literal'], $mandatoryValues);
            $statisticsValues = array_map([$expressionBuilder, 'literal'], $statisticsValues);
            $marketingValues = array_map([$expressionBuilder, 'literal'], $marketingValues);
            $constraints[] = $expressionBuilder->eq(
                self::ISCOOKIESDEPENDENT_FIELD,
                self::ISCOOKIESDEPENDENT_OFF
            );
            $constraints[] = $expressionBuilder->andX(
                $expressionBuilder->eq(
                    self::ISCOOKIESDEPENDENT_FIELD,
                    self::ISCOOKIESDEPENDENT_ON
                ),
                $expressionBuilder->eq(
                    self::CONDITIONTYPE_FIELD,
                    $expressionBuilder->literal(self::CONDITIONTYPE_VALUE_SHOWAND)
                ),
                $expressionBuilder->andX(
                    $expressionBuilder->in(
                        self::MANDATORYCONDITION_FIELD,
                        $mandatoryValues
                    ),
                    $expressionBuilder->in(
                        self::STATISTICSCONDITION_FIELD,
                        $statisticsValues
                    ),
                    $expressionBuilder->in(
                        self::MARKETINGCONDITION_FIELD,
                        $marketingValues
                    ),
                )
            );
            $constraints[] = $expressionBuilder->andX(
                $expressionBuilder->eq(
                    self::ISCOOKIESDEPENDENT_FIELD,
                    self::ISCOOKIESDEPENDENT_ON
                ),
                $expressionBuilder->eq(
                    self::CONDITIONTYPE_FIELD,
                    $expressionBuilder->literal(self::CONDITIONTYPE_VALUE_SHOWOR)
                ),
                $expressionBuilder->orX(
                    $expressionBuilder->in(
                        self::MANDATORYCONDITION_FIELD,
                        $mandatoryValues
                    ),
                    $expressionBuilder->in(
                        self::STATISTICSCONDITION_FIELD,
                        $statisticsValues
                    ),
                    $expressionBuilder->in(
                        self::MARKETINGCONDITION_FIELD,
                        $marketingValues
                    ),
                )
            );
        }
        return strval($expressionBuilder->orX(...$constraints));
    }

    /**
     * {@inheritdoc}
     * 
     * In addition cookies sql constraints
     * are added to enableFields query
     */
    public function enableFields($table, $show_hidden = -1, $ignore_array = [], $noVersionPreview = false): string
    {
        $enableFields = parent::enableFields($table, $show_hidden, $ignore_array, $noVersionPreview);
        if (in_array($table, $this->allowedTables)) {
            $cookiesEnableFields = $this->getCookiesEnableFields($table);
            if (!empty($cookiesEnableFields)) {
                $enableFields .= ' AND (' . $cookiesEnableFields . ')';
            }
        }
        return $enableFields;
    }
}
