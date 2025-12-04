<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Users\Enums\Gender;
use Modules\Users\Enums\StudentStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('student_code')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender',array_column(Gender::cases(),'value'));
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('medical_notes')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->enum('status', array_column(StudentStatus::cases(),'value'))->default(StudentStatus::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
