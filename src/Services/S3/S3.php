<?php

namespace Programic\Aws\Services\S3;

use Aws\Result;
use Aws\S3\S3Client;

class S3
{
    public function __construct(private S3Client $client) {
        //
    }

    /**
     * @param string|array $bucket
     * @param null $key
     * @return \Aws\Result
     */
    public function getObject(string|array $bucket, $key = null): \Aws\Result
    {
        $args = is_array($bucket)
            ? $bucket
            : [
                'Bucket' => $bucket,
                'Key' => $key,
            ];

        return $this->client->getObject($args);
    }

    public function __call($method, $args): Result
    {
        return $this->client->{$method}(...$args);
    }

    /**
     * @return S3Client
     */
    public function client(): S3Client
    {
        return $this->client;
    }
}
