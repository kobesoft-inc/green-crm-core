<?php

use Green\CrmCore\Enums\RelationshipType;
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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('family_name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('family_name_kana')->nullable();
            $table->string('given_name_kana')->nullable();
            $table->string('title')->nullable();
            $table->string('company_name')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->set('relationship_types', RelationshipType::values())->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
