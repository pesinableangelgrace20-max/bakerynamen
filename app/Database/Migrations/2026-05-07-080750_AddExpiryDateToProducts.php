<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExpiryDateToProducts extends Migration
{
    public function up()
    {
        $fields = [
            'expiry_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'stock',
            ],
        ];
        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'expiry_date');
    }
}
