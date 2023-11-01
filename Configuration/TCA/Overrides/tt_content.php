<?php

defined('TYPO3') or die();

// adds cookies-dependent enable fields to 'tt_content' model TCA and insert in 'access' sheet
$ll = 'LLL:EXT:cookieconsent_plus/Resources/Private/Language/locallang_db.xlf:ttcontent.';
$newFields = [
    'tx_cookieconsentplus_iscookiesdependent' => [
        'label' => $ll . 'tx_cookieconsentplus_iscookiesdependent',
        'description' => $ll . 'tx_cookieconsentplus_iscookiesdependent.description',
        'exclude' => 0,
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'config' => [
            'type' => 'check',
        ],
        'onChange' => 'reload',
    ],
    'tx_cookieconsentplus_conditiontype' => [
        'label' => $ll . 'tx_cookieconsentplus_conditiontype',
        'description' => $ll . 'tx_cookieconsentplus_conditiontype.description',
        'exclude' => 0,
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'displayCond' => 'FIELD:tx_cookieconsentplus_iscookiesdependent:=:1',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    $ll . 'tx_cookieconsentplus_conditiontype.showand',
                    'showand'
                ],
                [
                    $ll . 'tx_cookieconsentplus_conditiontype.showor',
                    'showor'
                ],
            ],
        ],
    ],
    'tx_cookieconsentplus_statisticscondition' => [
        'label' => $ll . 'tx_cookieconsentplus_statisticscondition',
        'description' => $ll . 'tx_cookieconsentplus_statisticscondition.description',
        'exclude' => 0,
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'displayCond' => 'FIELD:tx_cookieconsentplus_iscookiesdependent:=:1',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    $ll . 'tx_cookieconsentplus_conditionvalue.anyvalue',
                    'anyvalue'
                ],
                [
                    $ll . 'tx_cookieconsentplus_conditionvalue.denied',
                    'denied'
                ],
                [
                    $ll . 'tx_cookieconsentplus_conditionvalue.accepted',
                    'accepted'
                ],
            ],
        ],
    ],
    'tx_cookieconsentplus_marketingcondition' => [
        'label' => $ll . 'tx_cookieconsentplus_marketingcondition',
        'description' => $ll . 'tx_cookieconsentplus_marketingcondition.description',
        'exclude' => 0,
        'l10n_mode' => 'exclude',
        'l10n_display' => 'defaultAsReadonly',
        'displayCond' => 'FIELD:tx_cookieconsentplus_iscookiesdependent:=:1',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    $ll . 'tx_cookieconsentplus_conditionvalue.anyvalue',
                    'anyvalue'
                ],
                [
                    $ll . 'tx_cookieconsentplus_conditionvalue.denied',
                    'denied'
                ],
                [
                    $ll . 'tx_cookieconsentplus_conditionvalue.accepted',
                    'accepted'
                ],
            ],
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $newFields);
$GLOBALS['TCA']['tt_content']['palettes']['cookiesdependent'] = [
    'label' => $ll . 'tx_cookieconsentplus_iscookiesdependent.label',
    'showitem' => 'tx_cookieconsentplus_iscookiesdependent,
        --linebreak--, tx_cookieconsentplus_conditiontype,
        --linebreak--, tx_cookieconsentplus_statisticscondition, tx_cookieconsentplus_marketingcondition',
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;;cookiesdependent',
    '',
    'after:hidden'
);
$GLOBALS['TCA']['tt_content']['ctrl']['enablecolumns']['cookiesdependent_iscookiesdependent'] = 'tx_cookieconsentplus_iscookiesdependent';
$GLOBALS['TCA']['tt_content']['ctrl']['enablecolumns']['cookiesdependent_conditiontype'] = 'tx_cookieconsentplus_conditiontype';
$GLOBALS['TCA']['tt_content']['ctrl']['enablecolumns']['cookiesdependent_statisticscondition'] = 'tx_cookieconsentplus_statisticscondition';
$GLOBALS['TCA']['tt_content']['ctrl']['enablecolumns']['cookiesdependent_marketingcondition'] = 'tx_cookieconsentplus_marketingcondition';
