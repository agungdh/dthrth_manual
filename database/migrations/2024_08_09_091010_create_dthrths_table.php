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
        Schema::create('dthrths', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('skpd_id')->constrained();
            $table->date('bulan_tahun');
            $table->date('uploaded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dthrths');
    }
};
