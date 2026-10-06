<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Fecha y hora exacta de caducidad de la publicación
            $table->timestamp('expires_at')->nullable()->after('published_at');
            
            // Marca para publicaciones perpetuas (Actividades comunitarias o Reglamentos)
            $table->boolean('is_permanent')->default(false)->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['expires_at', 'is_permanent']);
        });
    }
};