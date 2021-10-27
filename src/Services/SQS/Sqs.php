<?php

namespace Programic\Aws\Services\SQS;

use Aws\Result;
use Aws\Sqs\SqsClient;
use Programic\Aws\Jobs\S3\ObjectCreated;

class Sqs
{
    public array $jobs = [
        's3.ObjectCreated' => ObjectCreated::class,
    ];

    public function __construct(private SqsClient $client) {
        //
    }

    public function __call($method, $args): Result
    {
        return $this->client->{$method}(...$args);
    }

    /**
     * @return array
     */
    public function jobs(): array
    {
        return $this->jobs;
    }

    /**
     * @return SqsClient
     */
    public function client(): SqsClient
    {
        return $this->client;
    }
}
