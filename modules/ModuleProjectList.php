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
 * Class ModuleProjectList
 *
 * Front end module "project list".
 */
class ModuleProjectList extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_ac_project_list';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['ac_project_list'][0]) . ' ###';
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

        // Hide the list module if there is item specified
        if (\Input::get('items'))
        {
            return '';
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
        $imgSize = deserialize($this->imgSize, true);
        $strHref = $this->generateFrontendUrl($objPage->row(), ($GLOBALS['TL_CONFIG']['useAutoItem'] ? '/%s' : '/items/%s'));
        $arrProjects = array();

        while ($objProjects->next())
        {
            $arrProjects[$objProjects->id] = $objProjects->row();
            $arrProjects[$objProjects->id]['class'] = trim(((++$count == 1) ? ' first' : '') . (($count == $limit) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'));
            $arrProjects[$objProjects->id]['linkTitle'] = specialchars($objProjects->name, true);
            $arrProjects[$objProjects->id]['href'] = sprintf($strHref, $objProjects->alias);
            $arrProjects[$objProjects->id]['description'] = \String::toHtml5($objProjects->description);
            $arrProjects[$objProjects->id]['singleSRC'] = '';

            // Add the cover image
            if (($objImage = \FilesModel::findByPk($objProjects->singleSRC)) !== null && is_file(TL_ROOT . '/' . $objImage->path))
            {
                $arrProjects[$objProjects->id]['singleSRC'] = \Image::getHtml(\Image::get($objImage->path, $imgSize[0], $imgSize[1], $imgSize[2]), $objProjects->name);
            }
        }

        $this->Template->projects = $arrProjects;
    }
}

