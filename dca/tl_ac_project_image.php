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
 * Table tl_ac_project_image
 */
$GLOBALS['TL_DCA']['tl_ac_project_image'] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_ac_project',
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid' => 'index'
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
            'headerFields'            => array('name', 'alias', 'published'),
            'panelLayout'             => 'search,limit',
            'child_record_callback'   => array('tl_ac_project_image', 'generateLabel')
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
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ac_project_image']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ac_project_image']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_ac_project_image']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ac_project_image']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ac_project_image']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ac_project_image']['toggle'],
                'icon'                => 'visible.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'     => array('tl_ac_project_image', 'toggleIcon')
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'                     => '{headline_legend},headline,subheadline,singleSRC,published'
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
        'headline' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ac_project_image']['headline'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'subheadline' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ac_project_image']['subheadline'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'singleSRC' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ac_project_image']['singleSRC'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('mandatory'=>true, 'filesOnly'=>true, 'fieldType'=>'radio', 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes'], 'tl_class'=>'clr'),
            'sql'                     => "binary(16) NULL"
        ),
        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ac_project_image']['published'],
            'exclude'                 => true,
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
    )
);


/**
 * Class tl_ac_project_image
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_ac_project_image extends Backend
{

    /**
     * Generate label and return it as HTML string
     * @param array
     * @return string
     */
    public function generateLabel($arrRow)
    {
        return '<div>
<div style="float:left;margin-right:20px;">' .
\Image::getHtml(\Image::get(\FilesModel::findByPk($arrRow['singleSRC'])->path, 200, 140, 'center_center')) .
'</div>
<div style="padding-top:50px;">
<span style="font-size:14px;">' . $arrRow['headline'] . '</span><br><br>
' . $arrRow['subheadline'] . '
</div>
</div>';
    }


    /**
     * Return the "toggle visibility" button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
    }


    /**
     * Publish/unpublish an item
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        $objVersions = new Versions('tl_ac_project_image', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_ac_project_image']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_ac_project_image']['fields']['published']['save_callback'] as $callback)
            {
                $this->import($callback[0]);
                $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_ac_project_image SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
                       ->execute($intId);

        $objVersions->create();
        $this->log('A new version of record "tl_ac_project_image.id='.$intId.'" has been created'.$this->getParentEntries('tl_ac_project_image', $intId), __METHOD__, TL_GENERAL);
    }
}
