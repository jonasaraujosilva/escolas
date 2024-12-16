<?php

namespace App\Models;

use App\Entities\Enrollment;
use App\Models\Basic\AppModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EnrollmentModel extends AppModel
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Enrollment::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [        
        'class_id',
        'student_id',                
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


    public function all(): array {

        $this->select([
            'enrollments.*',
            'students.name AS student',
            'students.code AS student_code',
            'classes.name AS class',
            'classes.code AS class_code',
        ]);

        $this->join('students', 'students.id = enrollments.student_id');
        $this->join('classes', 'classes.id = enrollments.class_id');

        return $this->findAll();

    }

   
    public function getByCode(string $code): Enrollment 
    {

        $enrollment = $this->where(['code' => $code])->first();

        if ($enrollment === null) {

            throw new PageNotFoundException("Matrícula não encontrada. Code: {$code}");
        }

        $enrollment->student = model(StudentModel::class)->find($enrollment->student_id);
        $enrollment->parent = model(ParentModel::class)->find($enrollment->student->parent_id);
        $enrollment->class = model(ClassModel::class)->find($enrollment->class_id);

        return $enrollment;
    }

    // Recupera as matrículas da turma informada
    public function getByClassIdAndAcademicYear(int $classId, int|string $year): array {

        $where = [
            'class_id'          => $classId,
            'YEAR(created_at)'  => $year,
        ];

        $this->where($where);

        return $this->findAll();

    } 
    
}
