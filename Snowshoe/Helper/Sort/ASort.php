<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 21/09/2011
 * @package Snowshoe
 */

namespace Snowshoe\Helper\Sort;

/**
 * Interface for the Sort classes. The sort function is used as a usort() callback
 *
 * @package Snowshoe
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
abstract class ASort
{
    /**
     * Sorts the values given in ascending order.
     * Returns:
     * 1 is $a is greater than $b
     * 0 is $a is the same as $b
     * -1 if $a is less than $b
     *
     * @abstract
     * @param $a
     * @param $b
     * @return int
     */
    abstract static public function sortAsc($a, $b);

    /**
     * Sorts the values given in descending order.
     * This just returns the inverted sign on the result of $this->sortAsc()
     *
     * @param $a
     * @param $b
     * @return int
     */
    public static function sortDesc($a, $b)
    {
        return (static::sortAsc($a, $b) * -1);
    }
}
