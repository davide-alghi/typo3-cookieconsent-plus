<?php

declare(strict_types=1);

// ...

use PAD\CookieconsentPlus\Database\Query\Restriction\CookieRestriction;

// ...

class MyClass
{
    // ...

    public function myFunction(): void
    {
        // ...

        $connection = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connection->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeByType(CookieRestriction::class);

        // ...
    }
}
