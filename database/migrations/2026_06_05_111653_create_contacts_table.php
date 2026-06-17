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
      Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            
            // Тип звернення з обмеженими значеннями
            $table->enum('topic', [
                'general',      // Загальне питання
                'advertising',  // Реклама та партнерство
                'cooperation',  // Співпраця
                'news_tip',     // Новина або порада
                'bug',          // Помилка на сайті
                'other'         // Інше
            ])->default('general');
            
            $table->text('message');
            
            // Статус обробки повідомлення
            $table->enum('status', [
                'new',      // Нове
                'read',     // Прочитано
                'replied'   // Відповіли
            ])->default('new');
            
            $table->timestamps();
            
            // Додаємо індекси для швидкого пошуку
            $table->index('topic');
            $table->index('status');
            $table->index('created_at');
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
