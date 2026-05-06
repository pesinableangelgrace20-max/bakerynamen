<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUnitPriceAndCashierToSales extends Migration
{
    public function up()
    {
        $fields = [
            'unit_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'quantity',
            ],
            'cashier_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'total_price',
            ],
        ];

        $this->forge->addColumn('sales', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('sales', ['unit_price', 'cashier_id']);
    }
}
