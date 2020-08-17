<?php


namespace App\Http\Services;


use Aws\CloudFront\CloudFrontClient;
use Aws\Exception\AwsException;

class S3CloudFrontService
{
    private $cloudFrontClient;
    private $path;

    public function __construct($key)
    {
        $this->path = $key;
        $this->cloudFrontClient = new CloudFrontClient([
            'profile' => 'default',
            'version' => 'latest',
            'region' => config('filesystems.disks.s3.region'),
        ]);
    }

    function signPrivateDistribution()
    {
        $resourceKey = config('filesystems.disks.s3.url') .'/' . $this->path;
        $expires = now()->addHours(4); // 4 hours from now.
        $privateKey = env('AWS_CLOUDFRONT_PRIVATE_KEY');
        $keyPairId = env('AWS_CLOUDFRONT_ACCESS_KEY_ID');

        try {
            $result = $this->cloudFrontClient->getSignedUrl([
                'url' => $resourceKey,
                'expires' => $expires->getTimestamp(),
                'private_key' => $privateKey,
                'key_pair_id' => $keyPairId
            ]);

            return $result;

        } catch (AwsException $e) {
            return $e->getMessage();
        }
    }
}
