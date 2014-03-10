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
