<?php

namespace Programic\Aws;

use Aws\S3\S3Client;
use Illuminate\Contracts\Foundation\Application;

class Aws
{
    protected $client;

    public function __construct(
        private array $config
    ) {
        //
    }

}
