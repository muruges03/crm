<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaxesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('taxes')->delete();
        
        \DB::table('taxes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tax_name' => 'GST',
                'tax_type' => 'Sales',
                'tax_amount' => '10.00',
                'account_id' => NULL,
                'parent_id' => NULL,
                'tax_group' => 'GST',
                'entity_id' => 1,
                'created' => '2022-05-31 05:41:30',
                'created_by' => 3,
                'modified' => NULL,
                'modified_by' => NULL,
                'status' => 0,
                'visibility' => 1,
                'deleted' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'tax_name' => 'SGST',
                'tax_type' => 'Sales',
                'tax_amount' => '5.00',
                'account_id' => NULL,
                'parent_id' => 1,
                'tax_group' => 'SGST',
                'entity_id' => 1,
                'created' => '2022-05-31 05:41:46',
                'created_by' => 3,
                'modified' => NULL,
                'modified_by' => NULL,
                'status' => 0,
                'visibility' => 1,
                'deleted' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'tax_name' => 'CGST',
                'tax_type' => 'Sales',
                'tax_amount' => '5.00',
                'account_id' => NULL,
                'parent_id' => 1,
                'tax_group' => 'CGST',
                'entity_id' => 1,
                'created' => '2022-05-31 05:42:05',
                'created_by' => 3,
                'modified' => NULL,
                'modified_by' => NULL,
                'status' => 0,
                'visibility' => 1,
                'deleted' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'tax_name' => 'GST',
                'tax_type' => 'Sales',
                'tax_amount' => '12.00',
                'account_id' => NULL,
                'parent_id' => NULL,
                'tax_group' => 'GST',
                'entity_id' => 1,
                'created' => '2022-05-31 05:42:18',
                'created_by' => 3,
                'modified' => NULL,
                'modified_by' => NULL,
                'status' => 0,
                'visibility' => 1,
                'deleted' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'tax_name' => 'CGST',
                'tax_type' => 'Sales',
                'tax_amount' => '6.00',
                'account_id' => NULL,
                'parent_id' => 4,
                'tax_group' => 'CGST',
                'entity_id' => 1,
                'created' => '2022-05-31 05:42:31',
                'created_by' => 3,
                'modified' => NULL,
                'modified_by' => NULL,
                'status' => 0,
                'visibility' => 1,
                'deleted' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'tax_name' => 'SGST',
                'tax_type' => 'Sales',
                'tax_amount' => '6.00',
                'account_id' => NULL,
                'parent_id' => 4,
                'tax_group' => 'SGST',
                'entity_id' => 1,
                'created' => '2022-05-31 05:42:43',
                'created_by' => 3,
                'modified' => NULL,
                'modified_by' => NULL,
                'status' => 0,
                'visibility' => 1,
                'deleted' => 0,
            ),
        ));
        
        
    }
}