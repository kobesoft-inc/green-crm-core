<?php

use Green\CrmCore\Enums\EmailType;
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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->morphs('emailable');
            $table->string('email');
            $table->enum('type', EmailType::values())->default(EmailType::WORK->value);
            $table->string('label')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_opted_in')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
