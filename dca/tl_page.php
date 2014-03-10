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
 * Add the child table to tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['config']['ctable'][] = 'tl_page_ac_project';


/**
 * Adjust the data container configuration
 */
if (\Input::get('do') == 'ac_projects')
{
    // Display the info message
    \Message::addInfo($GLOBALS['TL_LANG']['tl_page']['ac_projects_sorting_help']);

    // Close the table
    $GLOBALS['TL_DCA']['tl_page']['config']['closed'] = true;
    $GLOBALS['TL_DCA']['tl_page']['config']['notEditable'] = true;
    $GLOBALS['TL_DCA']['tl_page']['config']['notDeletable'] = true;
    $GLOBALS['TL_DCA']['tl_page']['config']['notCopyable'] = true;
    $GLOBALS['TL_DCA']['tl_page']['config']['notCreatable'] = true;

    // Preserve the "toggle" global opreation
    $arrToggle = $GLOBALS['TL_DCA']['tl_page']['list']['global_operations']['toggleNodes'];

    // Remove all global operations
    unset($GLOBALS['TL_DCA']['tl_page']['list']['global_operations']);

    // Add the "projects" button
    $GLOBALS['TL_DCA']['tl_page']['list']['global_operations']['ac_projects'] = array
    (
        'label'               => &$GLOBALS['TL_LANG']['MOD']['ac_projects'],
        'href'                => 'table=tl_ac_project',
        'icon'                => 'system/modules/artists_catalog/assets/icon.png'
    );

    // Restore the "toggle nodes" global operation
    $GLOBALS['TL_DCA']['tl_page']['list']['global_operations']['toggleNodes'] = $arrToggle;

    // Replace all operations with one element
    $GLOBALS['TL_DCA']['tl_page']['list']['operations'] = array
    (
        'ac_projects_sorting' => array
        (
            'label'               => &$GLOBALS['TL_LANG']['tl_page']['ac_projects_sorting'],
            'href'                => 'table=tl_page_ac_project',
            'icon'                => 'system/modules/artists_catalog/assets/sorting.png',
            'button_callback'     => array('tl_page_ac', 'sortProjects')
        )
    );
}


/**
 * Class tl_page_ac
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_page_ac extends Backend
{

    /**
     * Return the sort projects button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function sortProjects($row, $href, $label, $title, $icon, $attributes, $table)
    {
        if ($row['type'] == 'root')
        {
            return '';
        }

        return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
    }
}

