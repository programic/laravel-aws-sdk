<?php

namespace Programic\Aws\Services\ElasticTranscoder\Job;

use Aws\ElasticTranscoder\ElasticTranscoderClient;

class Job
{
    public Result $aws;

    public function __construct(private ElasticTranscoderClient $client) {
        //
    }

    public static function find(string $id, ElasticTranscoderClient $client): Result
    {
        $instance = new static($client);

        return new Result($instance->client->readJob([
            'Id' => $id,
        ]));
    }
}
