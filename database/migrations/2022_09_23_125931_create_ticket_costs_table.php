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
        Schema::create('ticket_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arrival_id')->constrained('provinces')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('destination_id')->constrained('provinces')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('cost');
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
        Schema::dropIfExists('ticket_costs');
    }
};
