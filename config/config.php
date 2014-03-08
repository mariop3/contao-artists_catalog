<?php

/**
 * artists_catalog extension for Contao Open Source CMS
 *
 * Copyright (C) 2014 Codefog
 *
 * @package artists_catalog
 * @author  Valentin Ruhry <http://ruhry.at>
 * @author  Codefog <http://codefog.pl>
 * @author  Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @license LGPL
 */


/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['content']['artists_catalog'] = array
(
    'tables' => array('tl_ac_project', 'tl_ac_project_image'),
    'icon'   => 'system/modules/artists_catalog/assets/icon.png'
);
