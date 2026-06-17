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
       Schema::create('settings', function (Blueprint $table) {

        $table->id();

        $table->string('site_name')->default('News');

        $table->string('theme_color')->default('#8b5cf6');

        $table->integer('sidebar_width')->default(260);

        $table->timestamps();

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
