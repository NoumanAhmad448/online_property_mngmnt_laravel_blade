<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (Schema::hasTable(config('table.user_profiles'))) {
            Schema::table(config('table.user_profiles'), function ($table) {
                $table->foreignId(config('table.job_id'))->nullable()->comment('jobs table')->change();
                $table->string(config('table.mobile'), 255)->nullable()->comment('mobile number')->change();
                $table->string(config('table.age'), 255)->nullable()->comment('user age')->change();
                $table->string(config('table.address'), 255)->nullable()->comment('user permanent address')->change();
                $table->enum(config('table.gender'), ['male', 'female', 'others',
                ])->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
};
