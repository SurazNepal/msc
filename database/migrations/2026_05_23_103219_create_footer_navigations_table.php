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
        Schema::create('footer_navigations', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->string('type')->nullable(); // custom_page, service_page, static, etc.
            $table->json('related_id')->nullable(); // Holds the ['type:id'] structure securely
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_navigations');
    }
};
