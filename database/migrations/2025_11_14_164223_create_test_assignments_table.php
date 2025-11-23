<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('test_assignments', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('test_id');
        $table->unsignedBigInteger('student_id');

        $table->timestamp('assigned_at')->nullable();
        $table->string('status')->default('pending'); 
        $table->integer('score')->nullable();

        $table->timestamps();

        $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_assignments');
    }
};
