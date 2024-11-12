<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     * Create the table plan
     *
     * @return void
     */
    public function up()
    {
        // Table doesn't exist. We need to create it
        if (!Schema::hasTable('plans')) {
            Schema::create('plans', function (Blueprint $table) {
                $table->id();
                $table->string('edit_id', 40)->unique();
                $table->string('view_id', 40)->unique();
                $table->string('title', 200);
                $table->string('description', 500);
                $table->string('contact', 200)->nullable(true);
                $table->string('owner_email', 200);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     * Drop te table plan
     *
     * @return void
     */
    public function down()
    {
        // just drop table
        Schema::dropIfExists('plans');
    }
}
