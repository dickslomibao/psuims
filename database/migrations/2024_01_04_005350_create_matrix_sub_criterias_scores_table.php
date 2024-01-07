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
        Schema::create('matrix_sub_criterias_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('matrix_criterias_scores_id');
            $table->string('title');
            $table->float('percentage');
            $table->float('score')->nullable()->default(null);
            $table->char('scored_by', 36)->nullable()->default(null);;
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
        Schema::dropIfExists('matrix_sub_criterias_scores');
    }
};
