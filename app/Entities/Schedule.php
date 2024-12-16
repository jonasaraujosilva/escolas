<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Schedule extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'day_of_week' => '?integer'
    ];

    public function dayOfWeek(): string
    {

        return match ($this->day_of_week) {

            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sabado-feira',
            7 => 'Domingo-feira',
            default => "Dia {$this->day_of_week} é desconhecido",
        };
    }

    public function startAt(): string
    {

        return Time::parse($this->start_at)->format('H:i');
    }

    public function endAt(): string
    {

        return Time::parse($this->end_at)->format('H:i');
    }

    public function academicYear(): string
    {

        return $this->created_at->format('Y');
    }
}
