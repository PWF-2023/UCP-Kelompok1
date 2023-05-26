<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            // Menambahkan kolom 'category_id' sebagai foreign key yang dapat bernilai null pada tabel 'todos'.
            // Kolom ini akan dikaitkan (constrained) ke tabel 'categories' dan akan melakukan cascade delete.
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            // Metode ini digunakan untuk mengembalikan skema database ke kondisi sebelum migrasi dijalankan.
            // Dalam contoh ini, tidak ada perubahan yang dibutuhkan untuk mengembalikan skema.
        });
    }
};
