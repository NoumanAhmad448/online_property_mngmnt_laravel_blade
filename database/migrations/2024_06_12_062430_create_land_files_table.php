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
        if (! Schema::hasTable(config('table.land_files'))) {
            Schema::create(config('table.land_files'), function (Blueprint $table) {
                $table->id();
                $table->foreignId(config('table.land_create').'_id')
                    ->constrained()
                    ->onDelete('cascade');
                $table->text(config('table.f_name'))->nullable();
                $table->text(config('table.link'))->nullable();
                $table->string(config('table.f_mimetype'), 255)->nullable();
                $table->timestamp(config('table.created_at'))->useCurrent();
                $table->timestamp(config('table.updated_at'))->useCurrent();
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
        Schema::dropIfExists(config('table.land_files'));
    }
};
