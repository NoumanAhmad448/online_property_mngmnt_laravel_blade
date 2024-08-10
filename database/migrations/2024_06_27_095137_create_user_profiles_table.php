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
        if (! Schema::hasTable(config('table.user_profiles'))) {
            Schema::create(config('table.user_profiles'), function (Blueprint $table) {
                $table->increments(config('table.primary_key'));
                $table->foreignId(config('table.user_id'))
                    ->references(config('table.primary_key'))
                    ->on(config('table.users'))
                    ->constrained()
                    ->onDelete('cascade');
                // nullable in foregin key always comes first from constrained
                $table->foreignId(config('table.job_id'))
                    ->references(config('table.primary_key'))
                    ->on(config('table.jobs'))
                    ->nullable()
                    ->constrained()
                    ->onDelete('cascade');

                $table->string(config('table.mobile'), 255)->nullable()->comment('mobile number');
                $table->string(config('table.age'), 255)->comment('user age');
                $table->string(config('table.address'), 255)->comment('user permanent address');
                $table->enum(config('table.gender'), [
                    'male', 'female', 'others',
                ])->comment('user gender');

                $table->timestamp(config('table.created_at'))->useCurrent();
                $table->timestamp(config('table.updated_at'))->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(config('table.user_profiles'));
    }
};
