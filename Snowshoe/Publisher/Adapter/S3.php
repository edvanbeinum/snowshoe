<?php
/**
 *
 * @author Ed van Beinum <edwin@sessiondigital.com>
 * @version $Id$
 * @copyright Ibuildings 16/10/2011
 * @package Snowshoe
 */
namespace Snowshoe\Publisher\Adapter;

/**
 * Adapater Class to interact with Zend_Service_Amazonn_S3
 *
 * @package Snowshoe
 * @author Ed van Beinum <edwin@sessiondigital.com>
 */
class S3 implements \Snowshoe\Publisher\IAdapter
{

    /**
     * @var \Zend_Service_Amazon_S3
     */
    protected $_s3Service;

    /**
     * @var \Snowshoe\Config\AConfig
     */
    protected $_config;

    public function __construct(\Snowshoe\Config\AConfig $config)
    {
        $this->_config = $config;
        require_once  APPLICATION_PATH . 'Snowshoe/Vendor/Zend/Service/Amazon/S3.php';
        $this->_s3Service = new \Zend_Service_Amazon_S3(
            $this->_config->getS3Key(),
            $this->_config->getS3SecretKey()
        );
    }

    /**
     * Set the S3Service object
     *
     * @param   \Zend_Service_Amazon_S3   $s3
     * @return void
     */
    public function setS3Service(\Zend_Service_Amazon_S3 $s3)
    {
        $this->_s3Service = $s3;
    }

    /**
     * Returns s3Service Object
     *
     * @return Zend_Service_Amazon_S3|\Zend_Service_Amazon_S3
     */
    public function getS3Service()
    {
        return $this->_s3Service;
    }


    /**
     * Creates a bucket on S3 with the given name if it doesn't already exist
     *
     * @param   string  $bucketName
     * @return  bool
     */
    public function createBucket($bucketName)
    {
        if ( ! $this->_s3Service->isBucketAvailable($bucketName)) {
            $this->_s3Service->createBucket($bucketName);
        }
        return TRUE;
    }

    /**
     * Uploads a file to S3
     *
     * @param \SplFileInfo $fileInfo
     * @param string $relativePath
     * @return void
     */
    public function putFile(\SplFileInfo $fileInfo, $relativePath)
    {
        $s3Path = $this->_getS3Path($relativePath);
        $this->_s3Service->putFile(
            $fileInfo->getPathname(),
            $s3Path,
            array(\Zend_Service_Amazon_S3::S3_ACL_HEADER => \Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ)
        );
    }

    /**
     * Deletes a file from the S3 bucket with the filename of the SplFileInfo
     *
     * @param string $relativePath
     * @return bool
     */
    public function deleteFile($relativePath)
    {
        $s3Path = $this->_getS3Path($relativePath);
        $this->getS3Service()->removeObject($s3Path);
        return TRUE;
    }

    /**
     * Returns a string formatted to locate an object on S3
     * Prepends the Bucket name to begining of the relative file path
     *
     * @param string $relativePath
     * @return string
     */
    protected function _getS3Path($relativePath)
    {
        return $this->_config->getS3BucketName() . DIRECTORY_SEPARATOR . ltrim($relativePath, DIRECTORY_SEPARATOR);

    }
}
