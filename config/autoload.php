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
 * Register the namespace
 */
ClassLoader::addNamespace('ArtistsCatalog');


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Classes
    'ArtistsCatalog\ArtistsCatalog' => 'system/modules/artists_catalog/classes/ArtistsCatalog.php',

    // Models
    'ArtistsCatalog\ProjectModel'      => 'system/modules/artists_catalog/models/ProjectModel.php',
    'ArtistsCatalog\ProjectImageModel' => 'system/modules/artists_catalog/models/ProjectImageModel.php',

    // Modules
    'ArtistsCatalog\ModuleProjectNavigation' => 'system/modules/artists_catalog/modules/ModuleProjectNavigation.php',
    'ArtistsCatalog\ModuleProjectList'       => 'system/modules/artists_catalog/modules/ModuleProjectList.php',
    'ArtistsCatalog\ModuleProjectReader'     => 'system/modules/artists_catalog/modules/ModuleProjectReader.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'mod_ac_project_navigation' => 'system/modules/artists_catalog/templates/modules',
    'mod_ac_project_list'       => 'system/modules/artists_catalog/templates/modules',
    'mod_ac_project_reader'     => 'system/modules/artists_catalog/templates/modules',
));

