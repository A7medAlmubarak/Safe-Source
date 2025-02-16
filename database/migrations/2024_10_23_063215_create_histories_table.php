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
        Schema::create('histories', function (Blueprint $table) {
            $table->comment('Table Many To Many Between User And File ');
            $table->id('id');

            $table->bigInteger('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')->cascadeOnDelete();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->cascadeOnDelete();

            $table->enum('status', ['reserve', 'create', 'cancle', 'edit']);
            $table->json('changes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
