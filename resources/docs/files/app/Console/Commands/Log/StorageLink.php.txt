<?php

namespace App\Console\Commands\Log;

use App\Models\CronJobs;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class StorageLink extends Command {
    // Command name
    protected $signature = 'strge:ln
            ';

    // Description
    protected $description = 'Link storage folder and change the permission of storage folder';

    public function handle() {
        $cron_id = CronJobs::create_job([
            config('table.name') => $this->signature,
            config('table.status') => config('constants.idle'),
        ]);

        try {

            exec('pwd');

            $unlink_storage = 'unlink '.config('app.server_path').'public/storage';
            $storage = 'ln -s '.config('app.server_path').'storage/app/public '.config('app.server_path').'public/storage';
            $change_permission = 'chmod -R 777 '.config('app.server_path').'storage/';
            $show_public_dir = 'ls '.config('app.server_path').'public -l';

            debug_logs($unlink_storage);
            debug_logs($storage);
            debug_logs($change_permission);

            exec($unlink_storage);
            exec($storage);
            exec($change_permission);
            $this->info(__('messages.cnsl_msg', ['msg' => 'storage folder has been linked']));
            exec($show_public_dir);

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
