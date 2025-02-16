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
        Schema::create('backup_files', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('path');
            $table->string('type');
            $table->bigInteger('size');
            $table->bigInteger('version_number');
            $table->bigInteger('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')->cascadeOnDelete();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_files');

    }
};
