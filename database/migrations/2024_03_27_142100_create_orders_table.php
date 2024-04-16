<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('purchased_on');
            $table->integer('user_id');
            $table->timestamp('shipped_on')->nullable();
            $table->boolean('has_shipped')->nullable();
            $table->string('tracking')->nullable();
            $table->timestamp('delivered')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
