<?php
/**
 *
 * @author Ed van Beinum <e@edvanbeinum.com>
 * @version $Id$
 * @package Snowshoe
 */

namespace Snowshoe\Publisher;
/**
 * Abstract Adapter for creating concrete Publisher classes from
 *
 * @package Snowshoe
 * @author Ed van Beinum <e@edvanbeinum.com>
 */
interface Adapter {

    /**
     * Publishes the files in the public/ folder to a external location
     *
     * @abstract
     * @return boolean
     */
    public function publish();

    /**
     * Deletes the files from an external location
     *
     * @abstract
     * @return boolean
     */
    public function delete();

}
