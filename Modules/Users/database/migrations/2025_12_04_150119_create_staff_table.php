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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('employee_code')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', array_column(\Modules\Users\Enums\Gender::cases(), 'value'))->nullable();
            $table->string('nationality')->nullable();
            $table->string('national_id')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->date('hire_date')->nullable();
            $table->enum('position', array_column(\Modules\Users\Enums\StaffPosition::cases(), 'value'))->nullable();
            $table->string('department')->nullable();
            $table->string('qualification')->nullable();
            $table->string('specialization')->nullable();
            $table->integer('experience_years')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->enum('contract_type', array_column(\Modules\Users\Enums\ContractType::cases(), 'value'))->nullable();
            $table->enum('status', array_column(\Modules\Users\Enums\StaffStatus::cases(), 'value'))->nullable();
            $table->string('profile_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
