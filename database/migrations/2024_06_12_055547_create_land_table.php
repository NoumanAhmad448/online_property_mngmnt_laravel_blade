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
        if (! Schema::hasTable(config('table.land_create'))) {
            Schema::create(config('table.land_create'), function (Blueprint $table) {
                $table->id();
                $table->foreignId(config('table.user').'_id')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->text(config('table.title'));
                $table->text(config('table.description'));
                $table->text(config('table.location'))->nullable();
                $table->text(config('table.size'))->nullable();
                $table->foreignId(config('table.city').'_id')->nullable();
                $table->boolean(config('table.is_admin_approved'))->default(false);
                $table->boolean(config('table.is_active'))->index()->default(true);
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
        Schema::dropIfExists(config('table.land_create'));
    }
};
