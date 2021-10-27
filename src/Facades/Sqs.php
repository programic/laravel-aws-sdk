<?php

namespace Programic\Aws\Facades;

use Illuminate\Support\Facades\Facade;
use Programic\Aws\Services\SQS\Sqs as SqsService;

/**
 * @mixin SqsService
 */
class Sqs extends Facade
{
    /**
     * Get a task builder instance.
     *
     * @return SqsService
     */
    protected static function getFacadeAccessor()
    {
        return 'Sqs';
    }
}
