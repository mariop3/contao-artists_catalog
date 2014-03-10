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

namespace ArtistsCatalog;

/**
 * Class ModuleProjectNavigation
 *
 * Front end module "project navigation".
 */
class ModuleProjectNavigation extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_ac_project_navigation';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['ac_project_navigation'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        // Set the item from the auto_item parameter
        if (!isset($_GET['items']) && $GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
        {
            \Input::setGet('items', \Input::get('auto_item'));
        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        global $objPage;
        $objProjects = ProjectModel::findByPage($objPage->id);

        if ($objProjects === null)
        {
            return;
        }

        $count = 0;
        $limit = $objProjects->count();
        $strHref = $this->generateFrontendUrl($objPage->row(), ($GLOBALS['TL_CONFIG']['useAutoItem'] ? '/%s' : '/items/%s'));
        $arrProjects = array();

        while ($objProjects->next())
        {
            $blnActive = false;

            // Check if the project is active
            if (\Input::get('items') == $objProjects->alias)
            {
                $blnActive = true;
            }

            $arrProjects[$objProjects->id] = $objProjects->row();
            $arrProjects[$objProjects->id]['isActive'] = $blnActive;
            $arrProjects[$objProjects->id]['subitems'] = '';
            $arrProjects[$objProjects->id]['class'] = trim(((++$count == 1) ? ' first' : '') . (($count == $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even') . ($blnActive ? ' active' : ''));
            $arrProjects[$objProjects->id]['title'] = specialchars($objProjects->name, true);
            $arrProjects[$objProjects->id]['pageTitle'] = specialchars($objProjects->name, true);
            $arrProjects[$objProjects->id]['link'] = $objProjects->name;
            $arrProjects[$objProjects->id]['href'] = sprintf($strHref, $objProjects->alias);
            $arrProjects[$objProjects->id]['nofollow'] = false;
            $arrProjects[$objProjects->id]['target'] = '';
            $arrProjects[$objProjects->id]['description'] = str_replace(array("\n", "\r"), array(' ' , ''), $objProjects->description);
        }

        $objTemplate = new \FrontendTemplate($this->navigationTpl);
        $objTemplate->type = get_class($this);
        $objTemplate->cssID = $this->cssID;
        $objTemplate->level = 'level_1';
        $objTemplate->items = $arrProjects;

        $this->Template->buffer = $objTemplate->parse();
    }
}

