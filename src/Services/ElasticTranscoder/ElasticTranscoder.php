<?php

namespace Programic\Aws\Services\ElasticTranscoder;

use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Aws\Result;

use Programic\Aws\Exceptions\MethodNotFoundException;
use Programic\Aws\Services\ElasticTranscoder\Job\CreateJob;
use Programic\Aws\Services\ElasticTranscoder\Job\Job;
use Programic\Aws\Services\ElasticTranscoder\Job\Result as JobResult;

class ElasticTranscoder
{
    public function __construct(private ElasticTranscoderClient $client) {
        //
    }

    /**
     * @return CreateJob
     */
    public function createJob(): CreateJob
    {
        return new CreateJob($this->client);
    }

    public function getJob(string $jobId): JobResult
    {
        return Job::find($jobId, $this->client);
    }

    public function __call($method, $args): Result
    {
        return $this->client->{$method}(...$args);
    }

    public function listJobsByStatus(string $status): Result
    {
        return $this->client->listJobsByStatus([
            'Status' => $status,
        ]);
    }

    public function listJobsByPipeline(string $pipelineId): Result
    {
        return $this->client->listJobsByPipeline([
            'PipelineId' => $pipelineId,
        ]);
    }

    /**
     * @return ElasticTranscoderClient
     */
    public function client(): ElasticTranscoderClient
    {
        return $this->client;
    }
}
