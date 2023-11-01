.. include:: ../Includes.txt


.. _development:


====
Development
====

The extension adds four custom enable fields:

* :php:`cookiesdependent_iscookiesdependent`: :guilabel:`Is cookie-dependent` [tx_cookieconsentplus_iscookiesdependent]
* :php:`cookiesdependent_conditiontype`: :guilabel:`Conditions evaluation type` [tx_cookieconsentplus_conditiontype]
* :php:`cookiesdependent_statisticscondition`: :guilabel:`Statistics cookies are` [tx_cookieconsentplus_statisticscondition]
* :php:`cookiesdependent_marketingcondition`: :guilabel:`Marketing cookies are` [tx_cookieconsentplus_marketingcondition]

| Current version of extension adds *cookies-dependent enable fields* only to pages (pages) and content element (tt_content) tables.
| *Cookies-dependent enable fields* can be added to each other table (record).
| The extension provides cookies-dependent restriction in QueryBuilder. Restriction can be disabled.


.. _development-core-table-cookies-dependent-enable-fields:

Add cookies-dependent enable fields in core table
====

To add, for example, the *cookies-dependent enable fields* to category record (sys_category table), in your extension,
add a new file :file:`Configuration/TCA/Override/sys_category.php`

..  literalinclude:: _TCAOverrideSysCategory.php
    :language: php
    :caption: EXT:my_extension/Classes/Configuration/TCA/Override/sys_category.php

Then add fields to table in the database. In :file:`ext_tables.php` append

..  literalinclude:: _extTableSysCategory.sql
    :language: sql
    :caption: EXT:my_extension/ext_tables.sql


Add cookies-dependent enable fields in custom table
====

Just like in core table
:ref:`development-core-table-cookies-dependent-enable-fields`:
simply change 'sys_category' table name with your table name.



Disable QueryBuilder cookies-dependent restriction, overall system
====

To disable QueryBuilder cookies-dependent restriction, you have to append in your :file:`ext_localconf.php` this line

..  literalinclude:: _extLocalcontDisableQueryBuilderRestriction.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php


How to remove cookies-dependent restriction in QueryBuilder
====

Cookies-dependent restriction can be removed just like built-in restrictions

..  literalinclude:: _removeRestrictionQueryBuilder.php
    :language: php
    :caption: EXT:my_extension/Classes/.../MyClass.php

