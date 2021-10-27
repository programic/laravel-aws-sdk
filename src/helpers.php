<?php

use Programic\Aws\Facades\ElasticTranscoder;

if (!function_exists('elasticTranscoder')) {
    function elasticTranscoder() {
        return new ElasticTranscoder;
    }
}
