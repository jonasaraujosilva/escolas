<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSchedules extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],

            'class_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],

            'subject_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],

            'teacher_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],

            'day_of_week' => [
                'type'              => 'TINYINT',
                'constraint'        => 1,
                'COMMENT'           => 'Dia da semana que terá disciplina',
            ],

            'start_at' => [
                'type'              => 'TIME',               
            ],

            'end_at' => [
                'type'              => 'TIME',               
            ],

            'created_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
                'default'           => null,
            ],

            'updated_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
                'default'           => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('class_id');
        $this->forge->addKey('subject_id');
        $this->forge->addKey('teacher_id');
        $this->forge->addKey('day_of_week');
        $this->forge->addKey('start_at');
        $this->forge->addKey('end_at');
        $this->forge->addKey('created_at');
        $this->forge->addKey('updated_at');

        $this->forge->addForeignKey(
            fieldName: 'class_id',
            tableName: 'classes',
            tableField: 'id',
            onUpdate: 'CASCADE',
            onDelete: 'CASCADE',
        );

        $this->forge->addForeignKey(
            fieldName: 'subject_id',
            tableName: 'subjects',
            tableField: 'id',
            onUpdate: 'CASCADE',
            onDelete: 'CASCADE',
        );

        $this->forge->addForeignKey(
            fieldName: 'teacher_id',
            tableName: 'teachers',
            tableField: 'id',
            onUpdate: 'CASCADE',
            onDelete: 'CASCADE',
        );

        $this->forge->createTable('schedules');
    }

    public function down()
    {
        $this->forge->dropTable('schedules');
    }
}
