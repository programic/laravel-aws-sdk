<?php

namespace Programic\Aws\Services;

use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Aws\S3\S3Client;
use Aws\Sqs\SqsClient;
use Illuminate\Contracts\Foundation\Application;
use Programic\Aws\Aws;
use Programic\Aws\Exceptions\ConfigNotFoundException;
use Programic\Aws\Services\ElasticTranscoder\ElasticTranscoder;
use Programic\Aws\Services\ElasticTranscoder\Job\Job;
use Programic\Aws\Services\S3\S3;
use Programic\Aws\Services\SQS\SQS;

class Service
{
    public const S3 = 's3';
    public const ElasticTranscoder = 'elastic-transcoder';
    public const SQS = 'sqs';

    public static function register(Application $app)
    {
        $config = $app->make('config')->get('aws');
        if ($config === null) {
            return;
        }

        $app->singleton(Aws::class, function (Application $app) use ($config) {
            return new Aws($config);
        });
        $app->alias(Aws::class, 'aws');

        /**
         *  AWS S3 injection
         */
        $s3Client = new S3Client([
            'version' => '2006-03-01',
            'key' => $config['settings']['key'],
            'secret' => $config['settings']['secret'],
            'profile' => $config['settings']['profile'],
            'region' => $config['settings']['region'],
        ]);
        $app->singleton(S3::class, fn() => new S3($s3Client));
        $app->alias(S3::class, 's3');

        /**
         *  AWS ElasticTranscoder injection
         */
        $elasticTranscoderClient = new ElasticTranscoderClient([
            'version' => 'latest',
            'key' => $config['settings']['key'],
            'secret' => $config['settings']['secret'],
            'region' => $config['settings']['region'],
            'timeout' => 3,
        ]);

        $app->singleton(ElasticTranscoder::class, fn() => new ElasticTranscoder($elasticTranscoderClient));
        $app->alias(ElasticTranscoder::class, 'ElasticTranscoder');


        /**
         *  AWS SQS injection
         */
        $sqsClient = new SqsClient([
            'version' => 'latest',
            'key' => $config['settings']['key'],
            'secret' => $config['settings']['secret'],
            'region' => $config['settings']['region'],
            'timeout' => 3,
        ]);

        $app->singleton(Sqs::class, fn() => new Sqs($sqsClient));
        $app->alias(Sqs::class, 'Sqs');
    }
}
