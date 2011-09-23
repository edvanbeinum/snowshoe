<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 21/09/2011
 * @package Date
 */
namespace Snowshoe\Helper\Sort;

/**
 *
 * @package Date
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class Date extends ASort
{
    /**
     * Sorts splFileInfo classes based on the order they were created
     * 
     * Returns:
     * 1 is $a is greater than $b
     * 0 is $a is the same as $b
     * -1 if $a is less than $b
     *
     * @param splFileInfo $a
     * @param splFileInfo $b
     * @return int
     */
    public static  function sortAsc($a, $b)
    {
        $aDate = $a->getCTime();
        $bDate = $b->getCTime();

        if ($aDate === $bDate) {
            return 0;
        } else if ($aDate > $bDate) {
            return 1;
        } else {
            return -1;
        }
    }

}
