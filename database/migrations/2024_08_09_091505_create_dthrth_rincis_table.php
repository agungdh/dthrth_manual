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
        Schema::create('dthrth_rincis', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('dthrth_id')->constrained();
            $table->integer('no')->nullable();
            $table->string('no_spm')->nullable();
            $table->bigInteger('nilai_spm')->nullable();
            $table->date('tanggal_spm')->nullable();
            $table->string('no_sp2d')->nullable();
            $table->bigInteger('nilai_sp2d')->nullable();
            $table->date('tanggal_sp2d')->nullable();
            $table->string('kode_akun_belanja')->nullable();
            $table->string('kode_akun_pajak')->nullable();
            $table->decimal('ppn', total: 20, places: 2)->nullable();
            $table->decimal('pph21', total: 20, places: 2)->nullable();
            $table->decimal('pph22', total: 20, places: 2)->nullable();
            $table->decimal('pph23', total: 20, places: 2)->nullable();
            $table->decimal('pph4_2', total: 20, places: 2)->nullable();
            $table->decimal('jumlah', total: 20, places: 2)->nullable();
            $table->string('npwp')->nullable();
            $table->string('nama')->nullable();
            $table->string('kode_billing')->nullable();
            $table->string('ntpn')->nullable();
            $table->text('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dthrth_rincis');
    }
};
