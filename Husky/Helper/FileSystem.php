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
     * will try to create the file path ifit doesn't exist
     *
     * @param string $filePath
     * @param string $content
     * @return void
     */
    public function createFile($filePath, $content)
    {
        if ($this->createDirectory(pathinfo($filePath, PATHINFO_DIRNAME))) {
            file_put_contents($filePath, $content);
        }
    }

    /**
     * Wrapper for the file_get_contents function
     *
     * @param $filePath
     * @return string
     */
    public function getFile($filePath)
    {
        return file_get_contents($filePath);
    }

    /**
     * Creates a given directory if it doesn't already exist
     *
     * @throws \ErrorException
     * @param string $directoryPath
     * @return bool
     */
    public function createDirectory($directoryPath)
    {
        if (is_file($directoryPath)) {
            throw new \ErrorException("$directoryPath is not a Directory");
        }

        if (is_writeable($directoryPath)) {
            return TRUE;
        }
        else {

            // suppress errors on mkdir: we'll throw our own exception if it fails
            if (@mkdir($directoryPath, 0777)) {
                return TRUE;
            }

            $processUser = posix_getpwuid(posix_geteuid());
            throw new \ErrorException(
                $directoryPath . " is not writable and couldn't be created. \nMake sure the user " .
                "{$processUser['name']} has write permissions on the directory: $directoryPath"
            );
        }
    }

    /**
     * Returns array of all paths to sub directories in a given path
     *
     * @param string $path path the directory to scan
     * @return array
     */
    public function getSubDirectories($path)
    {
        $contents = $this->_getRecursiveIteratorIterator($path);
        $parsedContents = array();

        /* @var $fileInfo SplFileInfo */
        foreach ($contents as $filePath => $fileInfo) {


            // Skip over 'hidden' files and directories. That is, any with a name that begins with a period.
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
     * @param string $directoryPath
     * @param string $fileExtension (without preceeding period))
     * @return array of splFileInfo objects
     */
    public function getFilesInDirectory($directoryPath, $fileExtension = 'html')
    {
        // This is a recoverable error so we should strip off a filename if given rather than throwing an exception
        if (!is_dir($directoryPath)) {
            throw new Exception("$directoryPath is not a directory");
        }
        $contents = $this->_getRecursiveIteratorIterator($directoryPath);
        $parsedContents = array();

        /* @var $fileInfo SplFileInfo */
        foreach ($contents as $filePath => $fileInfo) {

            // Skip over 'hidden' files and directories. That is, any with a name that begins with a period.
            if (substr($fileInfo->getFileName(), 0, 1) !== '.') {

                // If current file is not a directory AND has the requested file extension, add it to the returned array
                // as of 5.3.6 this should use $fileInfo->getExtension() instead of pathinfo()
                if (!$fileInfo->isDir() && pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION) == ltrim($fileExtension, '.')) {
                    $parsedContents[] = $fileInfo;
                }
            }
        }
        return $parsedContents;
    }

    /**
     * Helper method that instantiates and returns a RecursiveIteratorIterator for the given directory path
     *
     * @param string $path
     * @return \RecursiveIteratorIterator
     */
    protected function _getRecursiveIteratorIterator($path)
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    }
}