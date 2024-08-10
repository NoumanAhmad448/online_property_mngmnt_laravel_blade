<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Health\Models\HealthCheckResultHistoryItem;
use Spatie\Health\ResultStores\EloquentHealthResultStore;

return new class extends Migration {
    private $tableName = '';

    public function __construct() {
        $this->tableName = EloquentHealthResultStore::getHistoryItemInstance()->getTable();
    }

    public function up() {
        $connection = (new HealthCheckResultHistoryItem)->getConnectionName();
        if (! Schema::hasTable($this->tableName)) {

            Schema::connection($connection)->create($this->tableName, function (Blueprint $table) {
                $table->increments(config('table.primary_key'))->comment('Primary Key');

                $table->string('check_name');
                $table->string('check_label');
                $table->string('status');
                $table->text('notification_message')->nullable();
                $table->string('short_summary')->nullable();
                $table->json('meta');
                $table->timestamp('ended_at');
                $table->uuid('batch');

                $table->timestamps();
            });

            Schema::connection($connection)->table($this->tableName, function (Blueprint $table) {
                $table->index('created_at');
                $table->index('batch');
            });
        }
    }

    public function down() {
        Schema::dropIfExists($this->tableName);
    }
};
