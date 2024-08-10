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
        if (Schema::hasTable(config('table.users'))) {
            Schema::table(config('table.users'), function ($table) {
                $table->boolean(config('table.is_super_admin'))->nullable();
                $table->boolean(config('table.is_admin'))->nullable();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasTable(config('table.users'))) {
            Schema::table(config('table.users'), function ($table) {
                $table->dropColumn(config('table.is_admin'));
                $table->dropColumn(config('table.is_super_admin'));
            });
        }
    }
};
