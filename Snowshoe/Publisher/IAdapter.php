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
interface IAdapter {

    /**
     * Publishes a file to an external location
     *
     * @abstract
     * @param \SplFileInfo $fileInfo
     * @param $relativePath  relative path to public file (some services (S3), need this)
     * @return void
     */
    public function putFile(\SplFileInfo $fileInfo, $relativePath);

    /**
     * Deletes a file from an external location
     *
     * @abstract
     * @param string $realativePath
     * @return bool
     */
    public function deleteFile($realativePath);

}
