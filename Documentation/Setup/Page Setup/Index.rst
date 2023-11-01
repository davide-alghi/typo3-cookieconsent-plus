.. include:: ../../Includes.txt


.. _page-setup:

====
Page Setup
====

Here, step by step, how to enable cookies dependency and conditions setting.

Steps
====

.. rst-class:: bignums

#. Edit the page you have to set as cookie-dependent

#. Go to :guilabel:`Access` tab

#. Tick the :guilabel:`Is cookie-dependent` checkbox

   .. image:: ../../Images/setup_001.png
      :class: with-shadow
      :width: 400px
      :alt: setup
   |
#. A :guilabel:`Refresh required` confirmation is showed: click :guilabel:`OK`

   .. image:: ../../Images/setup_002.png
      :class: with-shadow
      :width: 400px
      :alt: setup
   |
#. Select :guilabel:`Conditions evaluation type`:

   * | :guilabel:`show if ALL conditions`
     | :superscript:`makes the page visible if all conditions are verified: statistics and marketing`
   * | :guilabel:`show if AT LEAST ONE condition`
     | :superscript:`makes the page visible if at least one of conditions is verified: statistics or marketing`
   |
#. Set conditions on statistics/marketing cookies status

   * | :guilabel:`any value`
     | :superscript:`always true`
   * | :guilabel:`denied`
     | :superscript:`true if statistics/marketing cookies are denied`
   * | :guilabel:`accepted`
     | :superscript:`true if statistics/marketing cookies are accepted`
   |

   .. image:: ../../Images/setup_003.png
      :class: with-shadow
      :width: 400px
      :alt: setup
   |

Conditions evaluation type
====

Here you have two options:

* :guilabel:`show if ALL conditions` is an AND evaluation: if all conditions are true,
  the page is visible, else not
* :guilabel:`show if AT LEAST ONE condition` is an OR evaluation: if at least one
  condition is true, the page is visible; the page is hidden if all conditions
  are false

Conditions
====

In condition menus (Statistics, Marketing)
three options are available:

* :guilabel:`any value` the condition is always true
* :guilabel:`denied` the condition is true when cookies are denied
* :guilabel:`accepted` the condition is true when chookies are accepted
