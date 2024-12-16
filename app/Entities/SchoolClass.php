<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SchoolClass extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function schedules(): string
    {

        if (empty($this->schedules)) {

            return 'Não há dados para exibir';
        }

        $table = new \CodeIgniter\View\Table();

        $table->setTemplate([
            'table_open' => '<table class="table table-bordered">'
        ]);

        $table->setHeading(['Dia', 'Início', 'Término', 'Disciplina', 'Professor', 'Ano letivo']);

        foreach($this->schedules as $schedule){

            $table->addRow([
                $schedule->dayOfWeek(),
                $schedule->startAt(),
                $schedule->endAt(),
                $schedule->subject,
                $schedule->teacher,
                $schedule->academicYear(),
            ]);

        }

        return $table->generate();
    }


    public function students(): string
    {

        return 'Não há dados para exibir';
    }
}
