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
 * Add palettes to tl_settings
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('indexProtected;', 'indexProtected;{ac_legend},ac_defaultPage;', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);


/**
 * Add fields to tl_settings
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['ac_defaultPage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ac_defaultPage'],
    'exclude'                 => true,
    'inputType'               => 'pageTree',
    'eval'                    => array('fieldType'=>'radio')
);
