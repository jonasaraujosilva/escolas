<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Enrollment extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function createdAT(): string
    {

        return $this->created_at->format('d/m/Y H:i');
    }
}
