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
        Schema::create('visualizations', function (Blueprint $table) {
            $table->id();

            //* apartment_id
            $table->foreignId('apartment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->datetime('date');
            $table->string('ip', 15);

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
        Schema::dropIfExists('visualizations');
    }
};
