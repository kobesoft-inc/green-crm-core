<?php

use Green\CrmCore\Enums\AddressType;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->string('postal_code', 8);
            $table->string('prefecture');
            $table->string('city');
            $table->string('town')->nullable();
            $table->string('building')->nullable();
            $table->enum('type', AddressType::values())->default(AddressType::OFFICE->value);
            $table->string('label')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
