<?php

// database/migrations/YYYY_MM_DD_create_categories_table.php

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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // شناسه منحصر به فرد دسته‌بندی
            $table->string('name')->unique(); // نام دسته‌بندی (مثلاً 'Programming')
            $table->string('slug')->unique(); // Slug برای URLهای دوستانه (مثلاً 'programming')
            $table->text('description')->nullable(); // توضیحات دسته‌بندی
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};