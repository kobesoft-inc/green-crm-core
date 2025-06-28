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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('corporate_number', 13)->nullable();
            $table->date('established_date')->nullable();
            $table->string('representative_title')->nullable();
            $table->string('representative_family_name')->nullable();
            $table->string('representative_given_name')->nullable();
            $table->string('representative_family_name_kana')->nullable();
            $table->string('representative_given_name_kana')->nullable();
            $table->text('description')->nullable();
            $table->string('industry')->nullable();
            $table->integer('employee_count')->nullable();
            $table->unsignedBigInteger('capital')->nullable();
            $table->unsignedBigInteger('annual_revenue')->nullable();
            $table->set('relationship_types', RelationshipType::values())->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
