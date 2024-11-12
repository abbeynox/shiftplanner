<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterShiftTable extends Migration
{
    /**
     * Run the migrations.
     * In the origin schichtplan the column was named typ instead of type
     * Just rename the column to type
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('shifts', 'typ') && !Schema::hasColumn('shift', 'type')) {
            Schema::table('shifts', function (Blueprint $table) {
                $table->renameColumn('typ', 'type');
            });
        }

    }

    /**
     * Reverse the migrations.
     * Rename the column back to typ (sic)
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->renameColumn('type', 'typ');
        });
    }
}
