<?php

namespace Programic\Aws\Commands\ElasticTranscoder;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Programic\Aws\Facades\ElasticTranscoder;

class GetJobList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aws:transcoder:list {--status=} {--pipeline=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get List of Elastic Transcoder jobs';


    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $pipeline = $this->option('pipeline');
        $status = $this->option('status');

        if ($pipeline) {
            $jobs = ElasticTranscoder::listJobsByPipeline($pipeline);
        } else {
            $jobs = ElasticTranscoder::listJobsByStatus($status);
        }

        $jobOutput = collect($jobs->get('Jobs'))->map(function ($job) {
            return [
                'id' => $job['Id'],
                'status' => $job['Status'],
            ];
        });

        $this->table(
            ['ID', 'Status'],
            $jobOutput,
        );
    }
}
