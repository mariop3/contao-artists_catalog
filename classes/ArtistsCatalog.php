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
 * Class ArtistsCatalog
 *
 * Provide miscellaneous methods that are used by Artists Catalog system.
 */
class ArtistsCatalog
{

    /**
     * Update the sorting table
     * @param integer
     */
    public static function updateSortingTable($intPage)
    {
        $objProjects = \Database::getInstance()->prepare("SELECT * FROM tl_ac_project WHERE page=?")
                                               ->execute($intPage);

        // Delete old records in sorting table
        \Database::getInstance()->prepare("DELETE FROM tl_page_ac_project WHERE pid=? AND project NOT IN (SELECT id FROM tl_ac_project WHERE page=?)")
                                ->execute($intPage, $intPage);

        if (!$objProjects->numRows)
        {
            return;
        }

        $time = time();
        $intSortingMax = \Database::getInstance()->prepare("SELECT MAX(sorting) AS sorting FROM tl_page_ac_project WHERE pid=?")
                                                 ->execute($intPage)
                                                 ->sorting;

        // Create records that do not exist
        while ($objProjects->next())
        {
            $objExists = \Database::getInstance()->prepare("SELECT * FROM tl_page_ac_project WHERE project=? AND pid=?")
                                                 ->limit(1)
                                                 ->execute($objProjects->id, $intPage);

            if (!$objExists->numRows)
            {
                $intSortingMax = intval($intSortingMax) + 16;

                $arrSet = array
                (
                    'tstamp' => $time,
                    'pid' => $intPage,
                    'sorting' => $intSortingMax,
                    'project' => $objProjects->id
                );

                \Database::getInstance()->prepare("INSERT INTO tl_page_ac_project %s")
                                        ->set($arrSet)
                                        ->execute();
            }
        }
    }
}
