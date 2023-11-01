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

namespace PAD\CookieconsentPlus\Hook;

use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use PAD\CookieconsentPlus\Cookie\CookieConstraint;

class AddEnableColumnsHook
{
    /**
     * Returns clause where conditions for cookies
     *
     * @param array $params
     * @param PageRepository $pageRepository
     * @return string
     */
    public function addAdditionalWhereConditions(array $params, PageRepository $pageRepository): string
    {
        $conditions = '';
        $enableColumns = $params['ctrl']['enablecolumns'];
        if (isset($enableColumns['cookiesdependent_iscookiesdependent']) && $enableColumns['cookiesdependent_iscookiesdependent'] &&
            isset($enableColumns['cookiesdependent_conditiontype']) && $enableColumns['cookiesdependent_conditiontype'] &&
            isset($enableColumns['cookiesdependent_statisticscondition']) && $enableColumns['cookiesdependent_statisticscondition'] &&
            isset($enableColumns['cookiesdependent_marketingcondition']) && $enableColumns['cookiesdependent_marketingcondition'])
        {
            $table = $params['table'];
            $enableFields = [
                'iscookiesdependent' => $table . '.' . $enableColumns['cookiesdependent_iscookiesdependent'],
                'conditiontype' => $table . '.' . $enableColumns['cookiesdependent_conditiontype'],
                'statisticscondition' => $table . '.' . $enableColumns['cookiesdependent_statisticscondition'],
                'marketingcondition' => $table . '.' . $enableColumns['cookiesdependent_marketingcondition'],
            ];
            $conditions = CookieConstraint::getCookiesConstraints($table, $enableFields);
        }
        return $conditions;
    }
}
