<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parent_student', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_primary_contact')->default(false);
            $table->boolean('can_pickup')->default(false);

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('parent_id');

            $table->enum('relationship', array_column(
                \Modules\Users\Enums\ParentRelationship::cases(),
                'value'
            ));

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('student')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('parent')->onDelete('cascade');

            // Each student can only have one (father/mother/guardian/other)
            $table->unique(['student_id', 'relationship']);

            // Prevent duplicate linking of same parent to same student
            $table->unique(['student_id', 'parent_id']);
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_student');
    }
};
