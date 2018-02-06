<?php

namespace App\Http;

use Auth;
use Carbon\Carbon;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Support\Facades\Log;

class S3Helper {

    protected $bucketName = 'wurafleet';
    protected $s3upload = 'https://s3-eu-west-1.amazonaws.com/wurafleet/upload.png';
    protected $s3uploadImage = 'https://s3-eu-west-1.amazonaws.com/wurafleet/upload_image.png';

    private function SetupS3() {
        // Read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
        $IAM_KEY = getenv('AWS_ACCESS_KEY_ID');
        $IAM_SECRET = getenv('AWS_SECRET_ACCESS_KEY');

        // Set Amazon S3 Credentials and Instantiate the client.
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => $IAM_KEY,
                    'secret' => $IAM_SECRET
                ),
                'version' => 'latest',
                'region'  => 'eu-west-1'
            )
        );

        return $s3;
    }

    public function gets3upload() {
        return $this->s3upload;
    }

    public function gets3uploadImage() {
        return $this->s3uploadImage;
    }
    
    public function UploadImage($fileName, $tmpName) {
        try {
            //$filePath = $request->file('file')->getClientOriginalName();
            //$keyName = basename($filePath);
            //$bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

            $s3 = $this->SetupS3();
            $upload = $s3->upload($this->bucketName, $fileName, fopen($tmpName, 'rb'), 'public-read');
            return $upload->get('ObjectURL');
        } catch (S3Exception $e) {
            log::info('S3 Exception: ' . $e->getMessage());
            return $this->s3upload;
        } catch (Exception $e) {
            log::info('Generic Exception: ' . $e->getMessage());
            return $this->s3upload;
        }
    }
 }