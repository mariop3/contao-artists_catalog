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
$GLOBALS['BE_MOD']['content']['ac_projects'] = array
(
    'tables' => array('tl_ac_project', 'tl_ac_project_image', 'tl_page', 'tl_page_ac_project'),
    'icon'   => 'system/modules/artists_catalog/assets/icon.png'
);


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['artists_catalog'] = array
(
    'ac_project_navigation' => 'ArtistsCatalog\ModuleProjectNavigation',
    'ac_project_reader'     => 'ArtistsCatalog\ModuleProjectReader',
);


/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_ac_project']       = 'ArtistsCatalog\ProjectModel';
$GLOBALS['TL_MODELS']['tl_ac_project_image'] = 'ArtistsCatalog\ProjectImageModel';
