<?php

namespace App\Models;

use App\Entities\Subject;
use App\Models\Basic\AppModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class SubjectModel extends AppModel
{
    protected $table            = 'subjects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Subject::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [        
        'name',
        'description',        
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData', 'setCode'];
    protected $beforeUpdate   = ['escapeData'];

   
    public function getByCode(string $code): Subject 
    {

        $subject = $this->where(['code' => $code])->first();

        if ($subject === null) {

            throw new PageNotFoundException("Disciplina não encontrada. Code: {$code}");
        }

        return $subject;
    }
    
}
