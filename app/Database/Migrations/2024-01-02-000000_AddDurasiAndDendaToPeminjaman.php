<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDurasiAndDendaToPeminjaman extends Migration
{
    public function up()
    {
        $fields = [
            'durasi_pinjam' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'comment'    => 'Durasi peminjaman dalam hari'
            ],
            'tanggal_jatuh_tempo' => [
                'type' => 'DATE',
                'null' => true,
                'comment' => 'Tanggal jatuh tempo pengembalian'
            ],
            'denda' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'null'       => false,
                'comment'    => 'Denda keterlambatan'
            ],
        ];

        $this->forge->addColumn('peminjaman', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('peminjaman', ['durasi_pinjam', 'tanggal_jatuh_tempo', 'denda']);
    }
}
