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
 * Table tl_page_ac_project
 */
$GLOBALS['TL_DCA']['tl_page_ac_project'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_page',
        'doNotCopyRecords'            => true,
        'closed'                      => true,
        'notEditable'                 => true,
        'notDeletable'                => true,
        'notCopyable'                 => true,
        'notCreatable'                => true,
        'onload_callback' => array
        (
            array('tl_page_ac_project', 'updateSortingTable')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid' => 'index',
                'project' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('sorting'),
            'headerFields'            => array('title', 'alias', 'published'),
            'panelLayout'             => 'limit',
            'child_record_callback'   => array('tl_page_ac_project', 'generateLabel')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_page_ac_project']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
        )
    ),


    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'project' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
    )
);


/**
 * Class tl_page_ac_project
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_page_ac_project extends Backend
{

    /**
     * Update the sorting table
     */
    public function updateSortingTable()
    {
        if (!\Input::get('id'))
        {
            return;
        }

        \ArtistsCatalog\ArtistsCatalog::updateSortingTable(\Input::get('id'));
    }


    /**
     * Generate label and return it as HTML string
     * @param array
     * @return string
     */
    public function generateLabel($arrRow)
    {
        $objProject = \ArtistsCatalog\ProjectModel::findByPk($arrRow['project']);
        return '<div>' . $objProject->name . '</div>';
    }
}
