<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->string('author')->nullable();
            $table->string('cover_photo')->nullable();
            $table->integer('price]')->unsigned();
            $table->timestamps();
        });
    }
};
