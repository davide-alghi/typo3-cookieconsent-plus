<?php

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

$EM_CONF[$_EXTKEY] = array (
    'title' => 'Cookie Consent Plus',
    'description' => 'Cookie Consent Plus adds some new features to Dirk Persky\'s Cookie Consent extension (dp_cookieconsent).',
    'category' => 'fe',
    'state' => 'alpha',
    'version' => '0.0.1',
    'clearCacheOnLoad' => true,
    'author' => 'Davide Alghi',
    'author_email' => 'davide@penguinable.it',
    'author_company' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'dp_cookieconsent' => '11.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'PAD\\CookieconsentPlus\\' => 'Classes'
        ],
    ],
);
