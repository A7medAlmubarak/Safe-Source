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
        Schema::create('files', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->unique();
            $table->string('path');
            $table->string('type');
            $table->bigInteger('size');
            $table->boolean('isFree')->default(true);

            $table->bigInteger('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();

            $table->bigInteger('checked_by')->unsigned()->nullable();
            $table->foreign('checked_by')->references('id')->on('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
