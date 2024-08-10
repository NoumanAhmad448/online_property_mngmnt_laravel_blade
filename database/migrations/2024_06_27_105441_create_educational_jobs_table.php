<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationalJobsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (! Schema::hasTable(config('table.jobs'))) {

            Schema::create(config('table.jobs'), function (Blueprint $table) {
                $table->increments(config('table.primary_key'))->comment('Primary Key');
                $table->string(config('table.title'))->comment('Job Title');
                $table->text(config('table.description'))->nullable()->comment('Job Description');
                $table->timestamp(config('table.created_at'))->useCurrent()->comment('Creation Timestamp');
                $table->timestamp(config('table.updated_at'))->useCurrent()->comment('Update Timestamp');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(config('table.jobs'));
    }
}
