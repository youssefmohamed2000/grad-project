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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('drugs')->nullable(); // save like this "drug1,drug2,drug3"
            $table->boolean('blood_transfusion')->default(0);
            $table->text('allergy')->nullable();
            $table->integer('children_no')->default(0);
            $table->integer('last_child_age')->nullable();
            $table->boolean('booked_before')->default(0);
            $table->text('booked_reason')->nullable();
            $table->string('booked_duration', 100)->nullable();
            $table->enum('blood_type', ['a+', 'a-' , 'b+', 'b-', 'o+', 'o-', 'ab+', 'ab-']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
