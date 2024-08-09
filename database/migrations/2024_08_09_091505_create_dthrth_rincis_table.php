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
            $table->bigInteger('ppn')->nullable();
            $table->bigInteger('pph21')->nullable();
            $table->bigInteger('pph22')->nullable();
            $table->bigInteger('pph23')->nullable();
            $table->bigInteger('pph4_2')->nullable();
            $table->bigInteger('jumlah')->nullable();
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
