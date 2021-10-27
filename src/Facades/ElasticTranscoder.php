<?php

namespace Programic\Aws\Facades;

use Illuminate\Support\Facades\Facade;
use Programic\Aws\Services\ElasticTranscoder\ElasticTranscoder as ElasticTranscoderService;

/**
 * @mixin ElasticTranscoderService
 */
class ElasticTranscoder extends Facade
{

    const STATUS_SUBMITTED = 'Submitted';
    const STATUS_PROGRESSING = 'Progressing';
    const STATUS_COMPLETE = 'Complete';
    const STATUS_CANCELED = 'Canceled';
    const STATUS_ERROR = 'Error';

    /**
     * Get a task builder instance.
     *
     * @return ElasticTranscoderService
     */
    protected static function getFacadeAccessor()
    {
        return 'ElasticTranscoder';
    }
}
