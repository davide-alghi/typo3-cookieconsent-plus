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

namespace PAD\CookieconsentPlus\Database\Query\Restriction;

use TYPO3\CMS\Core\Database\Query\Expression\CompositeExpression;
use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\QueryRestrictionInterface;
use PAD\CookieconsentPlus\Cookie\CookieConstraint;

class CookieRestriction implements QueryRestrictionInterface
{
    /**
     * Main method to build expressions for given tables
     * Evaluates the ctrl/delete flag of the table and adds the according restriction if set
     *
     * @param array $queriedTables Array of tables, where array key is table alias and value is a table name
     * @param ExpressionBuilder $expressionBuilder Expression builder instance to add restrictions with
     * @return CompositeExpression The result of query builder expression(s)
     */
    public function buildExpression(array $queriedTables, ExpressionBuilder $expressionBuilder): CompositeExpression
    {
        $constraints = [];
        foreach ($queriedTables as $tableAlias => $tableName) {
            if (isset($GLOBALS['TCA'][$tableName]['ctrl']['enablecolumns'])) {
                $enableColumns = $GLOBALS['TCA'][$tableName]['ctrl']['enablecolumns'];
                if (isset($enableColumns['cookiesdependent_iscookiesdependent']) && $enableColumns['cookiesdependent_iscookiesdependent'] &&
                isset($enableColumns['cookiesdependent_conditiontype']) && $enableColumns['cookiesdependent_conditiontype'] &&
                isset($enableColumns['cookiesdependent_statisticscondition']) && $enableColumns['cookiesdependent_statisticscondition'] &&
                isset($enableColumns['cookiesdependent_marketingcondition']) && $enableColumns['cookiesdependent_marketingcondition'])
                {
                    $enableFields = [
                        'iscookiesdependent' => $tableAlias . '.' . $enableColumns['cookiesdependent_iscookiesdependent'],
                        'conditiontype' => $tableAlias . '.' . $enableColumns['cookiesdependent_conditiontype'],
                        'statisticscondition' => $tableAlias . '.' . $enableColumns['cookiesdependent_statisticscondition'],
                        'marketingcondition' => $tableAlias . '.' . $enableColumns['cookiesdependent_marketingcondition'],
                    ];
                    $constraints[] = CookieConstraint::getCookiesConstraints($tableName, $enableFields);
                }
            }
        }
        return $expressionBuilder->andX(...$constraints);
    }
}
