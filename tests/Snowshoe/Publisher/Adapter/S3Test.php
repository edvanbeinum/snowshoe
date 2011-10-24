<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 16/10/2011
 * @package PublisherTest
 */

require_once dirname(__FILE__) . '/../../../../Snowshoe/bootstrap.php';

/**
 *
 * @package PublisherTest
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class S3Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Snowshoe\Publisher\Adapter\S3
     */
    protected $_s3;

    /**
     * is the S3Credentials.php file present?
     *
     * @var bool
     */
    protected $_isTestS3OnlineEnabled = FALSE;

    /**
     * AWS Config values form ../S3Credentials.php
     *
     * @var array
     */
    protected $_s3TestConfig;

    /**
     * The filename of the file to be uploaded to S3
     *
     * @var String
     */
    protected $_filename;


    /**
     * Setup Fixture
     * If ../S3Credentials.php file is present then assume that it has AWS credentials in to make a API call
     *
     * @return void
     */
    public function setUp()
    {
        $configPath = dirname(__FILE__) . '/../S3Credentials.php';
        
        if (is_readable($configPath)) {

            $this->_isTestS3OnlineEnabled = TRUE;
            $this->_filename = 'test.txt';

            require_once $configPath;
            $s3Credentials = new S3Credentials;
            $this->_s3TestConfig = $s3Credentials->getCredentials();

            $this->_s3 = new \Snowshoe\Publisher\Adapter\S3($this->_getMockConfig());
        }
    }

    /**
     * Helper menthod that returns a mock \Snowshoe\Config\App obkect that returns the
     * credentials in ../S3Credentials.php
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function _getMockConfig()
    {
        $config = $this->getMock('\Snowshoe\Config\App', array('getS3Key', 'getS3SecretKey', 'getS3BucketName'));
        $config->expects($this->any())
                ->method('getS3Key')
                ->will($this->returnValue($this->_s3TestConfig['s3Key']));
        $config->expects($this->any())
                ->method('getS3SecretKey')
                ->will($this->returnValue($this->_s3TestConfig['s3SecretKey']));
        $config->expects($this->any())
                ->method('getS3BucketName')
                ->will($this->returnValue($this->_s3TestConfig['s3BucketName']));

        return $config;
    }

    /**
     * helper method that returns a mock SplFileInfo object
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function _getMockSplFileInfo()
    {
        $mockBuilder = $this->getMockBuilder('\splFileInfo')->disableOriginalConstructor();
        $mockSplFileInfo = $mockBuilder->getMock();

        $mockSplFileInfo->expects($this->any())
                ->method('getPathname')
                ->will($this->returnValue(APPLICATION_PATH . '/public/index.html'));
        return $mockSplFileInfo;
    }

    /**
     * @test
     */
    public function setS3Service_sets_the_class_var()
    {
        $builder = $this->getMockBuilder('\Zend_Service_Amazon_S3')->disableOriginalConstructor();
        $mockS3Service = $builder->getMock();
        $this->_s3->setS3Service($mockS3Service);
        $this->assertEquals($mockS3Service, $this->_s3->getS3Service());
    }

    /**
     * @test
     */
    public function createBucket_creates_bucket_on_s3()
    {
        $bucketName = 'unique.getsnowshoe.com';
        $this->_s3->createBucket($bucketName);
        $this->_s3->getS3Service()->isBucketAvailable($bucketName);
    }

    /**
     * @test
     */
    public function putFile_uploads_file()
    {
        if (!$this->_isTestS3OnlineEnabled) {
            $this->markTestSkipped('No Test configuration for Amazon API credentials found.');
        }

        $mockSplFileInfo = $this->_getMockSplFileInfo();

        $this->_s3->putFile($mockSplFileInfo, $this->_filename);

        $this->assertArrayHasKey(
            'type',
            $this->_s3->getS3Service()->getInfo(
                $this->_s3TestConfig['s3BucketName'] . DIRECTORY_SEPARATOR . $this->_filename
            )
        );
    }

    /**
     * @test
     */
    public function deleteFile_removes_file()
    {
        if (!$this->_isTestS3OnlineEnabled) {
            $this->markTestSkipped('No Test configuration for Amazon API credentials found.');
        }
        $mockSplFileInfo = $this->_getMockSplFileInfo();

        $this->_s3->deleteFile($this->_filename);

        $this->assertFalse(
            $this->_s3->getS3Service()->getInfo(
                $this->_s3TestConfig['s3BucketName'] . DIRECTORY_SEPARATOR . $this->_filename
            )
        );
    }
}