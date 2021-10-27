<?php

namespace Programic\Aws\Commands\ElasticTranscoder;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Programic\Aws\Facades\ElasticTranscoder;

class CheckJobStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:transcoder:status {jobId} {--wait}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the status of the Elastic Transcoder job';


    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $jobId = $this->argument('jobId');

        $status = $this->getJobStatus($jobId);


        if ($this->option('wait')) {
            if ($status !== ElasticTranscoder::STATUS_COMPLETE) {
                sleep(2);
                $this->handle();
            }
        }

        match($status) {
            ElasticTranscoder::STATUS_COMPLETE => $this->info($status),
            ElasticTranscoder::STATUS_ERROR, ElasticTranscoder::STATUS_CANCELED => $this->error($status),
            ElasticTranscoder::STATUS_PROGRESSING, ElasticTranscoder::STATUS_SUBMITTED => $this->line($status),
            default => $this->warn($status),
        };
    }

    private function getJobStatus(string $jobId): string
    {
        $job = ElasticTranscoder::getJob($jobId);

        $jobObject = $job->get('Job');

        return $jobObject['Status'];
    }
}
