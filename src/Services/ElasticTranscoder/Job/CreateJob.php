<?php

namespace Programic\Aws\Services\ElasticTranscoder\Job;

use Aws\ElasticTranscoder\ElasticTranscoderClient;

class CreateJob
{
    private array $job = [];

    public function __construct(private ElasticTranscoderClient $client) {
        //
    }

    /**
     * @param string $pipelineId
     * @return $this
     */
    public function pipeline(string $pipelineId): self
    {
        $this->job['PipelineId'] = $pipelineId;

        return $this;
    }

    /**
     * @param array $input
     * @return $this
     */
    public function inputs(array $input): self
    {
        if (array_key_first($input) === 0) {
            $this->job['Inputs'] = $input;
        } else {
            $this->job['Input'] = $input;
        }

        return $this;
    }

    /**
     * @param array $output
     * @return $this
     */
    public function outputs(array $output): self
    {
        if (array_key_first($output) === 0) {
            $this->job['Outputs'] = $output;
        } else {
            $this->job['Output'] = $output;
        }

        return $this;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function outputKeyPrefix(string $prefix): self
    {
        $this->job['OutputKeyPrefix'] = $prefix;

        return $this;
    }

    /**
     * @param array $playlist
     * @return $this
     */
    public function playlists(array $playlist): self
    {
        if (array_key_first($playlist) === 0) {
            $this->job['Playlists'] = $playlist;
        } else {
            $this->job['Playlist'] = $playlist;
        }

        return $this;
    }

    /**
     * @param array $metadata
     * @return $this
     */
    public function metadata(array $metadata): self
    {
        $this->job['UserMetadata'] = $metadata;

        return $this;
    }

    /**
     * @return Result
     */
    public function create(): Result
    {
        return new Result($this->client->createJob($this->job));
    }
}
