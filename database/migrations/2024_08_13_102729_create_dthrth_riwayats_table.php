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
        Schema::create('dthrth_riwayats', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('skpd_id')->constrained();
            $table->date('bulan_tahun');
            $table->dateTime('uploaded_at');
            $table->dateTime('archieved_at');
            $table->string('archieved_for');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dthrth_riwayats');
    }
};
