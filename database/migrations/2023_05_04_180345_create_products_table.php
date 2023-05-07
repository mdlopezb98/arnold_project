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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);

            $table->float('cant'); //la cantidad y debajo la unidad de medida
            $table->unsignedBigInteger('weights_id');
            $table->foreign('weights_id')->references('id')->on('weights');

            $table->float('price');//el precio inicial y debajo la unidad monetaria
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');

            //para saber en donde esta este producto
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');

            $table->string('description', 150);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
