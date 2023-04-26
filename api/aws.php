<?php
/**
 * Amazon S3 services Comonent.
 */
  
require 'aws/aws-autoloader.php';
use Aws\Common\Exception\RuntimeException;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\Model\MultipartUpload\UploadBuilder;
use Aws\S3\S3Client;
 
class AwsComponent extends Component
{

/**
 * @var : name of bucket in which we are going to operate
 */
    public $bucket = '';

/**
 * @var : Amazon S3Client object
 */
    private $s3 = null;
    
    
    function bucketUpload($filename)
    {
        if (empty($filename)) {
            return -1;
        }

        $path = "./marc_records";
        $bucket = "libraryreporting";
        // $credentials = new Credentials( 'AKIAJZ26HT6APHTZHRXA', 'pSGueTUnZFNb+pKtwtWjdOSeLwL80Z+QMgujplmn' );

        // Instantiate the S3 client with your AWS credentials
        $s3Client = S3Client::factory(array(
        'key' => Configure::read('App.AWS_S3_Key'),
        'secret' => Configure::read('App.AWS_S3_SECRET'),
        'region' => 'us-east-1'
        ));
        $result = $s3Client->putObject(array(
            'Bucket' => $bucket,
            'Key' => $filename,
            'SourceFile' => $path . "/" . $filename,
            'Metadata' => array(
            'LI' => 'reporting',
            'TST' => '123'
        )
        ));
        if ($result[ '@metadata' ][ 'statusCode' ] == 200) {
            return $result[ 'ObjectURL' ];
        } else {
            return -1;
        }
    }
    
    
/**
 * @desc : to upload file on bucket with specified path
 * @param : keyname > path of file which need to be uploaded
 * @return : uploaded file object
 * @created on : 14.03.2014
 */

    public function upload($keyname = null)
    {
        try {
            $uploader = UploadBuilder::newInstance()
                        ->setClient($this->s3)
                        ->setSource($keyname)
                        ->setBucket($this->bucket)
                        ->setKey($keyname)
                        ->build();
                        
            return  $uploader->upload();
        } catch (MultipartUploadException $e) {
            if (Configure::read('debug')) {
                echo 'S3 Exception :'.$e->getMessage() ;
            }
            $uploader->abort();
        } catch (Exception $e) {
            if (Configure::read('debug')) {
                echo 'Exception :'.$e->getMessage() ;
            }
        }
        
        return false;
    }
    
    
/**
 * @desc : to delete multiple objects from bucket
 * @param : array(
                array('Key' => $keyname1),
                array('Key' => $keyname2),
                array('Key' => $keyname3),
            )
 * @return : boolean
 * @created on : 14.03.2014
 */
    public function delete($objects = array())
    {
        try {
            return $this->s3->deleteObjects(array(
                'Bucket' => $this->bucket,
                'Objects' => $objects
            ));
        } catch (RuntimeException $e) {
            if (Configure::read('debug')) {
                echo 'RuntimeException Exception :'.$e->getMessage() ;
            }
        } catch (Exception $e) {
            if (Configure::read('debug')) {
                echo 'Exception :'.$e->getMessage() ;
            }
        }
        return false ;
    }
    
    
 /**
 * @desc : to empty specified folder
 * @param : folder to which you want to empty
 * @return : deleted file count
 * @created on :14.03.2014
 */
    public function emptyFolder($folder = null, $regexp = '/\.[0-9a-z]+$/')
    {
        try {
            return $this->s3->deleteMatchingObjects($this->bucket, $folder, $regexp);
        } catch (RuntimeException $e) {
            if (Configure::read('debug')) {
                echo 'RuntimeException Exception :'.$e->getMessage() ;
            }
        } catch (Exception $e) {
            if (Configure::read('debug')) {
                echo 'Exception :'.$e->getMessage() ;
            }
        }
        return false ;
    }
}
