<?php

namespace Programic\Aws\Facades;

use Illuminate\Support\Facades\Facade;
use Programic\Aws\Services\S3\S3 as S3Service;

/**
 * @mixin ElasticTranscoderService
 */
class S3 extends Facade
{
    /**
     * Get a task builder instance.
     *
     * @return ElasticTranscoderService
     */
    protected static function getFacadeAccessor()
    {
        return 'S3';
    }
}
