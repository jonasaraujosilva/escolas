<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendances extends Migration
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

            'class_id' =>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,               
            ],

            'student_id' =>[
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,               
            ],

             'date' =>[
                'type'              => 'DATE',                
                'null'              => true,
                'default'           => null,
            ],     
            
            'status' =>[
                'type'              => 'TINYINT',                
                'constraint'        => 1,
                'COMMENT'           => '0 => Ausent, 1 => presente',
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
        $this->forge->addKey('class_id');
        $this->forge->addKey('student_id');
        $this->forge->addKey('date'); 
        $this->forge->addKey('status'); 
        $this->forge->addKey('created_at'); 
        $this->forge->addKey('updated_at'); 

        $this->forge->addForeignKey(
            fieldName:'class_id',
            tableName:'classes',
            tableField:'id',
            onUpdate:'CASCADE',
            onDelete:'CASCADE',
        );

        $this->forge->addForeignKey(
            fieldName:'student_id',
            tableName:'students',
            tableField:'id',
            onUpdate:'CASCADE',
            onDelete:'CASCADE',
        );

        $this->forge->createTable('attendances');
    }

    public function down()
    {
        $this->forge->dropTable('attendances');
    }
}
