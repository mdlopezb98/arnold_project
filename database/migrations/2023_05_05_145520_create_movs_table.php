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
        Schema::create('movs', function (Blueprint $table) {
        
            $table->id();

            $table->boolean('mov_type')->default(1);

            $table->unsignedBigInteger('id_prod');
            $table->foreign('id_prod')->references('id')->on('products');

            $table->float('cant');

            $table->unsignedBigInteger('weight_id');
            $table->foreign('weight_id')->references('id')->on('weights');

            $table->float('sales_price');

            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');

            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movs');
    }
};
