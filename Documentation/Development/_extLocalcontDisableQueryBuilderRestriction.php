<?php

declare(strict_types=1);

defined('TYPO3') or die();

// ...
// ...

// use PAD\CookieconsentPlus\Database\Query\Restriction\CookieRestriction;
$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions'][CookieRestriction::class]['disabled'] = true;
