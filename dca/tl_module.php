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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['ac_project_navigation'] = '{title_legend},name,headline,type;{config_legend},ac_openFirst;{template_legend},navigationTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['ac_project_list']       = '{title_legend},name,headline,type;{template_legend},imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['ac_project_reader']     = '{title_legend},name,headline,type;{config_legend},fullsize;{template_legend},imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['ac_openFirst'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['ac_openFirst'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "char(1) NOT NULL default ''"
);
