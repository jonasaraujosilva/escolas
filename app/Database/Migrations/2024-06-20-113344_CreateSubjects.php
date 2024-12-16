<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubjects extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' =>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            
            'code' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 10,                
            ],

            'name' =>[
                'type'              => 'VARCHAR',
                'constraint'        => 128,                
            ], 
            
            'description' =>[
                'type'              => 'TEXT',
                'constraint'        => 2000,                
            ],

            'created_at' =>[
                'type'              => 'DATETIME',                
                'null'              => true,
                'default'           => null,
            ],

            'updated_at' =>[
                'type'              => 'DATETIME',                
                'null'              => true,
                'default'           => null,
            ],
        ]);

        $this->forge->addKey('id', true);        
        $this->forge->addKey('code');
        $this->forge->addKey('name');

        $this->forge->createTable('subjects');
    }

    public function down()
    {
        $this->forge->dropTable('subjects');
    }
}
