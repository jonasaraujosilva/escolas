<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Attendance extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'status' => 'boolean'
    ];

    public function isPresent(): bool {

       return $this->status;
    }
}
