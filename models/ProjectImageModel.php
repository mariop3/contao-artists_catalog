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
 * Class ProjectImageModel
 *
 * Reads and writes project images
 */
class ProjectImageModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_ac_project_image';


    /**
     * Find the images by parent ID
     * @param integer
     * @return \Model|null
     */
    public static function findByPid($intPid)
    {
        $t = static::$strTable;
        $arrColumns[] = "$t.pid=?";

        if (!BE_USER_LOGGED_IN)
        {
            $arrColumns[] = "$t.published=1";
        }

        return static::findBy($arrColumns, $intPid, array('order'=>"$t.sorting"));
    }
}
