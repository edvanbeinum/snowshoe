<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package FileSystem
 */

namespace Husky\Helper;
/**
 * Collection of wrapper functions around PHP's filesystem operations
 *
 * @package Husky
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class FileSystem
{

    /**
     * Returns  array of all paths to sub folders in a given path
     *
     * @static
     * @param string $path path the directory to scan
     * @param string $fileExtension file extension of files to return. exclude the . in the extension
     * @return \RecursiveIteratorIterator
     */
    public static function getDirectoryTree($path)
    {
        $contents = self::_getRecursiveIteratorIterator($path);
        $parsedContents = array();

        /* @var $fileInfo SplFileInfo */
        foreach ($contents as $filePath => $fileInfo) {

            if (substr($fileInfo->getFileName(), 0, 1) !== '.') {

                if($fileInfo->isDir()) {
                    $parsedContents[] = $filePath;
                }
            }
        }
        return $parsedContents;

    }

    /**
     * Returns array of paths to all folders and files of given extension in a give folder
     *
     * @static
     * @param $path
     * @param string $fileExtension
     * @return void
     */
    public static function getFileTree($path, $fileExtension = 'html')
    {
        $contents = self::_getRecursiveIteratorIterator($path);
        $parsedContents = array();

        /* @var $fileInfo SplFileInfo */
        foreach ($contents as $filePath => $fileInfo) {

            if (substr($fileInfo->getFileName(), 0, 1) !== '.') {

                if($fileInfo->isDir()) {
                    $parsedContents[] = $filePath;
                }
                // as of 5.3.6 we should use $fileInfo->getExtension()
                else if ($fileExtension && pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION) == $fileExtension) {
                    $parsedContents[] = $filePath;
                }
            }
        }
        return $parsedContents;
    }

    /**
     * @static
     * @param $path
     * @return \RecursiveIteratorIterator
     */
    protected static function _getRecursiveIteratorIterator($path) {
                // make sure the directoryPath given has a trailing slash
        $path = rtrim($path, '/') . '/';

        $path = realpath($path);

        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    }
}