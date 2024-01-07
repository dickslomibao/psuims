<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->unsignedBigInteger('type');
            $table->char('user_id', 36);
            $table->text('original_name');
            $table->text('path');
            $table->unsignedBigInteger('matrices_id')->default(0);
            $table->smallInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repos');
    }
};
