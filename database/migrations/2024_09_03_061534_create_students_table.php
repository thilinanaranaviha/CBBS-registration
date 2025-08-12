<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key

            $table->string('student_id')->unique(); // Optional: Make this unique if needed
            $table->string('name')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('nic_number')->nullable();
            $table->string('certificate_name')->nullable();
            $table->string('gender')->nullable();
            $table->text('contact_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();

            // $table->unsignedBigInteger('course_id')->nullable();
            // $table->unsignedBigInteger('branch_id')->nullable();
            // $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branches');
            $table->string('batch_id');
            $table->foreign('batch_id')->references('batch_id')->on('batches');
            $table->string('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->string('status')->default('registered');
            $table->boolean('isFastTrack')->default(0);
            $table->boolean('isActive')->default(1);

            $table->timestamps();

            // Indexes
            // $table->index('course_id');
            // $table->index('branch_id');
            // $table->index('batch_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
