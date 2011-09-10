<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 07/08/2011
 * @package HuskyTest
 */

require_once '../../Husky/bootstrap.php';
require_once 'vfsStream/vfsStream.php';

/**
 * Test class for FileSystem.
 * Generated by PHPUnit on 2011-08-07 at 21:53:52.
 */
class FileSystemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Husky\Helper\FileSystem
     */
    protected $_fileSystem;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_fileSystem = new \Husky\Helper\FileSystem;

        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('testDir'));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->_fileSystem);
    }

    /**
     * @test
     */
    public function createDirectory_creates_new_directory()
    {
        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild('newDir'));

        $this->_fileSystem->createDirectory(vfsStream::url('testDir/newDir'));
        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('newDir'));
    }

    /**
     * @test
     */
    public function createDirectory_returns_true_with_existing_directory()
    {
        vfsStream::newDirectory('testDir/newDir', 0755);
        $this->_fileSystem->createDirectory(vfsStream::url('testDir/newDir'));
        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('newDir'));
    }

    /**
     * @return void
     * @expectedException Exception
     * @test
     */
    public function createDirectory_throws_exception_if_directory_is_unwritable()
    {
        $newDir = new vfsStreamDirectory('testDir/newDir', 0400);
        $this->_fileSystem->createDirectory(vfsStream::url('testDir/newDir'));

    }

    /**
     * @return void
     * @test
     */
    public function getDirectoryTree_returns_array_of_subdirs()
    {

        $dirStructure = array('base' => array('subOne' => array(), 'subTwo' => array(), 'fileOne' => 'test content'));
        vfsStream::create($dirStructure, 'testDir');

        // since vfsStream is a wrapper around a stream, the returned directories will be prepended with 'vfs://'
        $expectedResult = array('vfs://testDir/base', 'vfs://testDir/base/subOne', 'vfs://testDir/base/subTwo');
        $this->assertSame($expectedResult, $this->_fileSystem->getDirectoryTree(vfsStream::url('testDir')));
    }

    /**
     * @return void
     * @test
     */
    public function getDirectoryTree_returns_empty_when_passed_only_files()
    {
        $dirStructure = array(
            'fileOne' => 'some content',
            'fileTwo' => 'some content',
            'fileThree' => 'some content'
        );
        vfsStream::create($dirStructure, 'testDir');

        $this->assertEmpty($this->_fileSystem->getDirectoryTree(vfsStream::url('testDir')));
    }

    /**
     * @return void
     * @test
     */
    public function getFileTree_returns_array_of_filenames()
    {
        $dirStructure = array(
            'fileOne.html' => 'some content',
            'fileTwo.html' => 'some content',
            'fileThree.txt' => 'some content'
        );
        vfsStream::create($dirStructure, 'testDir');

        $returnedArray = $this->_fileSystem->getFileTree(vfsStream::url('testDir'));

        $this->assertInstanceOf(
            'splFileInfo',
            $returnedArray[0],
            'getFileTree() not returning expected array of object of type: splFileInfo'
        );

        // Filesystem::getFileTree() returns and array of splFileInfo objects so we create a new array of just filenames
        $fileArray = array();
        foreach ($returnedArray as $fileInfo) {
            $fileArray[] = $fileInfo->getFilename();
        }

        $expected = array(
            'fileOne.html',
            'fileTwo.html'
        );


        $this->assertSame($expected, $fileArray, 'array of filenames not retruned as expected');
    }

    /**
     * @return void
     * @test
     */
    public function getFileTree_returns_array_of_filenames_with_given_extension()
    {
        $dirStructure = array(
            'fileOne.txt' => 'some content',
            'fileTwo.html' => 'some content',
            'fileThree.txt' => 'some content'
        );
        vfsStream::create($dirStructure, 'testDir');

        $returnedArray = $this->_fileSystem->getFileTree(vfsStream::url('testDir'), 'txt');

        $this->assertInstanceOf(
            'splFileInfo',
            $returnedArray[0],
            'getFileTree() not returning expected array of object of type: splFileInfo'
        );

        // Filesystem::getFileTree() returns and array of splFileInfo objects so we create a new array of just filenames
        $fileArray = array();
        foreach ($returnedArray as $fileInfo) {
            $fileArray[] = $fileInfo->getFilename();
        }

        $expected = array(
            'fileOne.txt',
            'fileThree.txt'
        );


        $this->assertSame($expected, $fileArray, 'array of filenames not retruned as expected');
    }

    /**
     * @return void
     * @test
     */
    public function getFileTree_returns_empty_when_passed_only_files()
    {
        $dirStructure = array(
            'fileOne' => array(),
            'fileTwo' => array(),
            'fileThree' => array()
        );
        vfsStream::create($dirStructure, 'testDir');

        $this->assertEmpty($this->_fileSystem->getFileTree(vfsStream::url('testDir')));
    }
}

?>
