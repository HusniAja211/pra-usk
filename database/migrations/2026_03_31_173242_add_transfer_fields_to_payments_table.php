<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
   public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('proof')->nullable();
            $table->string('payment_method')->default('transfer');
            $table->enum('status', ['pending','verified','rejected'])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['proof','payment_method','status']);
        });
    }
};
