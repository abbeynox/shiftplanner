<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftTable extends Migration
{
    /**
     * Run the migrations.
     * Add or modify shift table
     *
     * @return void
     */
    public function up()
    {
        // Update existing shift tables
        // rename shift to shifts
        // add timestamps to existing table
        if (Schema::hasTable('shifts')) {
            Schema::table('shifts', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('shifts')) {
            Schema::create('shifts', function (Blueprint $table) {
                $table->id();
                // the typo is in the origin repo
                $table->char('typ', 60);
                $table->string('title', 200);
                $table->string('description', 500)->nullable(true);
                $table->dateTime('start');
                $table->dateTime('end');
                $table->integer('team_size', false, true);
                $table->integer('group');
                $table->foreignIdFor(\App\Models\Plan::class)
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->timestamps();
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     * Drop shift table
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('shift');
    }
}
