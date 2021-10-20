.. include:: ../../Includes.txt


.. _page-setup:

==========
Page Setup
==========

Here, step by step, how to enable cookies dependency and conditions setting.


Steps
=====

#. Edit the Page you have to set as cookie-dependent
#. Go to 'Access' tab
#. Click on 'Is cookie-dependent' checkbox

   .. image:: ../../Images/setup_001.png
      :class: with-shadow
      :width: 400px
      :alt: setup
#. A 'Refresh required' confirmation is showed: click 'OK'

   .. image:: ../../Images/setup_002.png
      :class: with-shadow
      :width: 400px
      :alt: setup
#. Select 'Conditions evaluation type':

   * *show if ALL conditions*
   * *show if AT LEAST ONE condition*
#. Set show-conditions on Mandatory, Statistics, Marketing cookies status

   * *any value*
   * *denied*
   * *accepted*

   .. image:: ../../Images/setup_003.png
      :class: with-shadow
      :width: 400px
      :alt: setup


Conditions evaluation type
==========================

Here you have two options:

* **show if ALL conditions** is an AND evaluation: if all conditions are true, the Page is visible, else not
* **show if AT LEAST ONE condition** is an OR evaluation: if at least one condition is true, the Page is visible; the Page is hidden if all conditions are false

.. note: line is more than 80 chars because otherwise it's wrong rendered


Conditions
==========

In condition menus (Mandatory, Statistics, Marketing)
three options are available:

* **any value** means that condition is always true
* **denied** means that condition is true when cookies are denied
* **accepted** means that condition is true when chookies are accepted
