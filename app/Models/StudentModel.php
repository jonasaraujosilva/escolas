<?php

namespace App\Models;

use App\Entities\ParentStudent;
use App\Entities\Student;
use App\Models\Basic\AppModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class StudentModel extends AppModel
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Student::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'parent_id',
        'name',
        'email',
        'cpf',
        'phone',
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

    public function getByCode(string $code, bool $withParent = false): Student {


        $student = $this->where(['code' => $code])->first();

        if ($student === null) {

            throw new PageNotFoundException("Estudante não encontrado. Code: {$code}");
        }

        if ($withParent) {

            $student->parent = model(ParentModel::class)->find($student->parent_id);
        }

        return $student;
    }
}
