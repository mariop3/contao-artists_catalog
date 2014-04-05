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
 * Class ProjectModel
 *
 * Reads and writes projects
 */
class ProjectModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_ac_project';


    /**
     * Get the previous project
     * @return \Model|null
     */
    public function getPrevious()
    {
        $objPrevious = \Database::getInstance()->prepare("SELECT project FROM tl_page_ac_project WHERE pid=? AND sorting<(SELECT sorting FROM tl_page_ac_project WHERE project=?) ORDER BY sorting DESC")
                                               ->limit(1)
                                               ->execute($this->page, $this->id);

        if (!$objPrevious->numRows)
        {
            return null;
        }

        $t = static::$strTable;
        $arrColumns[] = "$t.id=?";

        if (!BE_USER_LOGGED_IN)
        {
            $arrColumns[] = "$t.published=1";
        }

        return static::findOneBy($arrColumns, $objPrevious->project);
    }


    /**
     * Get the next project
     * @return \Model|null
     */
    public function getNext()
    {
        $objNext = \Database::getInstance()->prepare("SELECT project FROM tl_page_ac_project WHERE pid=? AND sorting>(SELECT sorting FROM tl_page_ac_project WHERE project=?) ORDER BY sorting")
                                           ->limit(1)
                                           ->execute($this->page, $this->id);

        if (!$objNext->numRows)
        {
            return null;
        }

        $t = static::$strTable;
        $arrColumns[] = "$t.id=?";

        if (!BE_USER_LOGGED_IN)
        {
            $arrColumns[] = "$t.published=1";
        }

        return static::findOneBy($arrColumns, $objNext->project);
    }


    /**
     * Find the projects by page
     * @param integer
     * @return \Model|null
     */
    public static function findByPage($intPage)
    {
        $t = static::$strTable;
        $arrColumns[] = "$t.page=?";

        if (!BE_USER_LOGGED_IN)
        {
            $arrColumns[] = "$t.published=1";
        }

        $arrOptions['order'] = "$t.name";
        $objSorting = \Database::getInstance()->prepare("SELECT project FROM tl_page_ac_project WHERE pid=? ORDER BY sorting")
                                              ->execute($intPage);

        // Sort records
        if ($objSorting->numRows)
        {
            $arrOptions['order'] = \Database::getInstance()->findInSet("$t.id", $objSorting->fetchEach('project'));
        }

        return static::findBy($arrColumns, $intPage, $arrOptions);
    }


    /**
     * Find project by alias and page
     * @param mixed
     * @param integer
     * @return \Model|null
     */
    public static function findByAliasAndPage($varAlias, $intPage)
    {
        $t = static::$strTable;
        $arrColumns[] = "$t.alias=? AND $t.page=?";

        if (!BE_USER_LOGGED_IN)
        {
            $arrColumns[] = "$t.published=1";
        }

        return static::findOneBy($arrColumns, array($varAlias, $intPage));
    }
}
