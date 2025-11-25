<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_id');
            $table->unsignedBigInteger('question_id');
            $table->string('given_answer')->nullable();
            $table->string('correct_answer');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->foreign('result_id')->references('id')->on('test_results')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('test_answers');
    }
};
