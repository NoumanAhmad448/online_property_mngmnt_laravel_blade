<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder {
    public function __construct(
        protected CountriesStatesCities $serves
    ) {}

    public function run(): void {
        try {
            $this->createJobs();
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }

    }

    protected function createJobs(): void {
        $jobs = $this->serves->getJobs();
        $chunkLength = $this->serves->getCountriesChunkLength();

        $this->command->info('Starting Seed jobs Data ...');
        $this->command->getOutput()->progressStart(count($jobs));

        foreach (array_chunk($jobs, $chunkLength) as $chunk) {
            foreach ($chunk as $job) {
                Job::create([
                    config('table.primary_key') => $job->id,
                    config('table.title') => $job->title,
                    config('table.description') => $job->description,
                ]);
            }
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info(__('messages.cnsl_msg', ['msg' => 'jobs Data Seeded has successful']));
        $this->command->line('');

    }
}
