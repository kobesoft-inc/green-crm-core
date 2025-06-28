<?php

use Green\CrmCore\Models\Company;
use Green\CrmCore\Models\Contact;
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
        Schema::create('contact_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Company::class)->constrained()->onDelete('cascade');
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();

            $table->unique(['contact_id', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_companies');
    }
};
