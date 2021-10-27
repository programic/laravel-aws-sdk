<?php

namespace Programic\Aws\Services\ElasticTranscoder\Job;

/**
 * @mixin \Aws\Result
 */
class Result
{
    public function __construct(public \Aws\Result $result)
    {
        //
    }

    public function __call($method, $args)
    {
        return $this->result->{$method}(...$args);
    }
}
