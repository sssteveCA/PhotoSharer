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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->bigIncrements('author_id');
            $table->bigIncrements('photo_id');
            $table->string('comment_text');
            $table->boolean('reported')->default(0);
            $table->boolean('approved')->default(1);
            $table->dateTime('creation_date')->useCurrent();
            $table->index(['author_id','photo_id']);
            $table->foreignId('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
            $table->foreignId('photo_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('restrict');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
