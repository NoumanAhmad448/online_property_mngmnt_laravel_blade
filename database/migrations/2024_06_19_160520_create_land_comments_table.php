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
        if (! Schema::hasTable(config('table.land_comments'))) {
            Schema::create(config('table.land_comments'), function (Blueprint $table) {
                $table->increments(config('table.primary_key'));
                $table->foreignId(config('table.land_create_id'))
                    ->references(config('table.primary_key'))
                    ->on(config('table.land_create'))
                    ->constrained()
                    ->onDelete('cascade');
                $table->string(config('table.created_by'), 255)->comment('Created By which Admin');
                $table->boolean(config('table.is_admin_approved'))->default(false)->comment('Has admin approved from the system');
                $table->text(config('table.comment'))->comment('Admin Comment')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists(config('table.land_comments'));
    }
};
