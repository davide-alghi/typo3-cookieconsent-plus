.. include:: ../Includes.txt


.. _changelog:

=====
Changelog
=====

All notable changes will be documented in this file.

[0.1.0] - 2022-01-03
########

Added
**********************
* Added compatibility with last versions of dp_cookieconset extension (== 1.2.1 OR >= 11.4.0)

Removed
**********************
* | Removed "Mandatory" cookies condition.
  | To clean up database, due to the previous installation of 0.0.1 version,
    go in the BE module "Maintenace::Analyze Database Structure" and
    remove pages.tx_cookieconsentplus_mandatorycondition and
    tt_content.tx_cookieconsentplus_mandatorycondition fields

Fixed
**********************
* Removed PHP keyword 'use', from ext_table.php, pages.php (override), tt_content.php (override)
