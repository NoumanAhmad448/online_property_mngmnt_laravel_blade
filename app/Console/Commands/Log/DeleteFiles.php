<?php

namespace App\Console\Commands\Log;

use App\Models\CronJobs;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class DeleteFiles extends Command {
    // Command name
    protected $signature = 'files:clear
                {disable_js=0}
                {disable_css=0}
                {disable_php=0}
            ';

    // Description
    protected $description = 'Clear js/css/php files';

    public function handle() {

        $cron_id = CronJobs::create_job([
            config('table.name') => $this->signature,
            config('table.status') => config('constants.idle'),
        ]);

        try {

            $path = base_path();
            $js_files = " -o -name '*.js*' ";
            $css_files = " -o -name '*.css*' ";
            $php_files = "-o -name '*.php*'";
            debug_logs('disable_js');
            debug_logs((bool) $this->argument('disable_js'));

            if ($this->argument('disable_js')) {
                $js_files = '';
            }
            if ($this->argument('disable_css')) {
                $css_files = '';
            }
            if ($this->argument('disable_php')) {
                $php_files = '';
            }

            debug_logs($path);
            exec('pwd');

            $command = 'find '.$path." -type f -name '*.txt' {$js_files} {$css_files} {$php_files}
                        -execdir rm -- '{}' \;";

            debug_logs($command);

            exec($command);
            $this->info(__('messages.cnsl_msg', ['msg' => 'files have been deleted!']));

            CronJobs::update_job($cron_id, [
                config('table.status') => config('constants.successed'),
                config('table.ends_at') => Carbon::now(),
            ]);
        } catch (Exception $e) {
            CronJobs::update_job($cron_id, [
                config('table.status') => config('constants.error'),
                config('table.message') => $e->getMessage(),
                config('table.ends_at') => Carbon::now(),
            ]);
        }
    }
}
