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
     * Writes a given string to a file.
     * will try to create the file if it doesn't exist
     *
     * @static
     * @param string $filePath
     * @param string $content
     * @return void
     */
    public static function writeFile($filePath, $content)
    {
        $directoryPath = pathinfo($filePath, PATHINFO_DIRNAME);

        if (self::createDirectory($directoryPath)) {
            file_put_contents($filePath, $content);
        }

    }

    /**
     * Creates a given directory if it doesn't already exist
     *
     * @static
     * @throws \Exception
     * @param string $directoryPath
     * @return bool
     */
    public static function createDirectory($directoryPath)
    {
        if (is_writeable($directoryPath)) {
            return TRUE;
        }
        else {

            // suppress errors on mkdir: we'll throw our own exception if it fails
            if (@mkdir($directoryPath, 0777)) {
                return TRUE;
            }
            
            $processUser = posix_getpwuid(posix_geteuid());
            throw new \Exception(
                $directoryPath . " is not writable and couldn't be created. \nMake sure the user " .
                "{$processUser['name']} has write permissions on the directory: $directoryPath"
            );
        }
        return FALSE;
    }

    /**
     * Returns  array of all paths to sub directories in a given path
     *
     * @static
     * @param string $path path the directory to scan
     * @return array
     */
    public static function getDirectoryTree($path)
    {
        $contents = self::_getRecursiveIteratorIterator($path);
        $parsedContents = array();

        /* @var $fileInfo SplFileInfo */
        foreach ($contents as $filePath => $fileInfo) {

            if (substr($fileInfo->getFileName(), 0, 1) !== '.') {

                if ($fileInfo->isDir()) {
                    $parsedContents[] = $filePath;
                }
            }
        }
        return $parsedContents;

    }

    /**
     * Returns array of paths to all directories and files of given extension in a given directory
     *
     * @static
     * @param string $directoryPath
     * @param string $fileExtension (without preceeding period))
     * @return array of splFileInfo objects
     */
    public static function getFileTree($directoryPath, $fileExtension = 'html')
    {
        // This is a recoverable error so we should strip off a filename if given rather than throwing an exception
        if (!is_dir($directoryPath)) {
            throw new Exception("$directoryPath is not a directory");
        }
        $contents = self::_getRecursiveIteratorIterator($directoryPath);
        $parsedContents = array();

        /* @var $fileInfo SplFileInfo */
        foreach ($contents as $filePath => $fileInfo) {

            // Skip over 'hidden' files and directories. That is, any with a name that begins with a  period.
            if (substr($fileInfo->getFileName(), 0, 1) !== '.') {

                // If current file is not a directory and has the expected file extension, add it to the returned array
                // as of 5.3.6 we should use $fileInfo->getExtension() instead of pathinfo()
                if (!$fileInfo->isDir() && pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION) == $fileExtension) {
                    $parsedContents[] = $fileInfo;
                }
            }
        }
        return $parsedContents;
    }

    /**
     * Helper method that instantiates and returns a RecursiveIteratorIterator for the given directory path
     *
     * @static
     * @param $path
     * @return \RecursiveIteratorIterator
     */
    protected static function _getRecursiveIteratorIterator($path)
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    }
}