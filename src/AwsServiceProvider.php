<?php

namespace Programic\Aws;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Programic\Aws\Commands\ElasticTranscoder\CheckJobStatus;
use Programic\Aws\Commands\ElasticTranscoder\GetJobList;
use Programic\Aws\Exceptions\SqsJobNotFoundException;
use Programic\Aws\Facades\Sqs;
use Programic\Aws\Jobs\S3\ObjectCreated;
use Programic\Aws\Jobs\UnknownJob;
use Programic\Aws\Services\Service;

class AwsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishConfig();

        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }

        if (File::exists(__DIR__ . '/helpers.php')) {
            require __DIR__ . '/helpers.php';
        }

        Queue::before(function (JobProcessing $event) {
            if ($event->connectionName === 'sqs') {
                try {
                    $payload = $event->job->payload();
                    $record = $payload['Records'][0];
                    $eventSource = str_replace('aws:', '', $record['eventSource']);
                    $eventName = explode(':', $record['eventName'])[0];
                    $eventInstanceKey = $eventSource . '.' . $eventName;

                    $jobInstance = Sqs::jobs()[$eventInstanceKey] ?? null;

                    if ($jobInstance && class_exists($jobInstance)) {
                        $jobInstance::dispatch($record)->onConnection(config('aws.queue.connection'));
                    } else {
                        throw new SqsJobNotFoundException($eventInstanceKey . ' not configured');
                    }
                } catch (\Throwable $e) {
                    dump('throwable');
//                    event(new UnknownJob($event->job));
                } finally {
                    dump('delete');
                    dump($event->job->delete());
                }
            } else {
                dump($event->connectionName);
            }
        });
    }

    private function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/aws.php' => config_path('aws.php'),
        ]);
    }

    private function registerCommands()
    {
        $this->commands([
            CheckJobStatus::class,
            GetJobList::class,
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Service::register($this->app);
    }
}
