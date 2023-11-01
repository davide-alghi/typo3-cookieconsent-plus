.. include:: ../Includes.txt


.. _cache:

====
Cache
====

| Page content is updated when the page cache expires.
When the frontend user changes the status of the cookies,
page contents (included navigation menu) are not immediately updated until the cache expires.
The page is immediately unavailable (HTML error 404),
but any navigation menu and CE will continue to show them, due to cache.

.. note:: It is suggested to define a very small page :guilabel:`Cache Lifetime`, so that the menus and page contents are updated as quickly as possible.


