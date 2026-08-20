<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUniqueIndexToTSibaKomoditasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Bersihkan baris duplikat (komoditas_id, pasar_id, detail_tgl) yang sama persis
        // akibat bug double-submit di fitur "Ambil Data" / "Salin dari Kemarin", supaya
        // unique index di bawah bisa dibuat. Untuk tiap grup duplikat, sisakan satu baris
        // (yang punya ctid terbesar) dan hapus sisanya.
        DB::statement(<<<SQL
            DELETE FROM t_siba_komoditas a
            USING t_siba_komoditas b
            WHERE a.ctid < b.ctid
              AND a.komoditas_id = b.komoditas_id
              AND a.pasar_id = b.pasar_id
              AND a.detail_tgl = b.detail_tgl
        SQL);

        Schema::table('t_siba_komoditas', function (Blueprint $table) {
            $table->unique(
                ['komoditas_id', 'pasar_id', 'detail_tgl'],
                't_siba_komoditas_komoditas_pasar_tgl_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_siba_komoditas', function (Blueprint $table) {
            $table->dropUnique('t_siba_komoditas_komoditas_pasar_tgl_unique');
        });
    }
}
