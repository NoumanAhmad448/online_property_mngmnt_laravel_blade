<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (Schema::hasTable(config('table.land_create_logs'))) {
            Schema::table(config('table.land_create_logs'), function (Blueprint $table) {
                $table->uuid(config('table.uuid'));
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasTable(config('table.land_create_logs'))) {
            Schema::table(config('table.land_create_logs'), function (Blueprint $table) {
                $table->removeColumn(config('table.uuid'));
            });
        }
    }
};
