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
       // 1. Core About Information Settings Table
        Schema::create('about_settings', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->nullable()->default('About Mind Share Connect');
            $table->string('title')->default('Who We Are & What We Do');
            $table->longText('description_one');
            $table->longText('description_two')->nullable();

            // Legal / Footnote Registry Meta Blocks
            $table->string('registration_number')->nullable();
            $table->string('registration_date_text')->nullable(); // e.g., "Est. 20 March 2011"
            $table->string('pan_vat_number')->nullable();
            $table->string('pan_vat_date_text')->nullable(); // e.g., "Registered 2067 B.S."

            // Statistics Counter Badge
            $table->string('stats_count')->nullable()->default('16+');
            $table->string('stats_label')->nullable()->default('Partner Organisations');

            $table->string('button_text')->default('Explore Services');
            $table->string('button_url')->default('#');
            $table->timestamps();
        });

        // 2. Highlights / Core Strengths sub-collection blocks
        Schema::create('about_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_highlights');
        Schema::dropIfExists('about_settings');
    }
};
