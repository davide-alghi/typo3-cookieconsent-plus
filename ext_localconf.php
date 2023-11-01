<?php

declare(strict_types=1);

defined('TYPO3') or die();

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

// Adds cookies query restriction for QueryBuilder
$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions'][\PAD\CookieconsentPlus\Database\Query\Restriction\CookieRestriction::class] ??= [];
// Adds where clause for custom EnableColumns
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['addEnableColumns'][1698385983] = \PAD\CookieconsentPlus\Hook\AddEnableColumnsHook::class . '->addAdditionalWhereConditions';
