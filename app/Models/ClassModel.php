<?php

namespace App\Models;

use App\Entities\SchoolClass;
use App\Models\Basic\AppModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

class ClassModel extends AppModel
{
    protected $table            = 'classes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = SchoolClass::class;
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


    public function getByCode(string $code, bool $withSchedules = false, bool $withStudents = false): SchoolClass
    {

        $class = $this->where(['code' => $code])->first();

        if ($class === null) {

            throw new PageNotFoundException("Turma não encontrada. Code: {$code}");
        }

        if ($withSchedules) {

            $class->schedules = model(ScheduleModel::class)->getByClassId($class->id);
        }

        if ($withStudents) {

            $this->associateStudents(class: $class, year: Time::now()->getYear()); //Ano atual
        }

        return $class;
    }


    private function associateStudents(SchoolClass &$class, int|string $year): void
    {

        // Recuperamos as matrículas da turma em questão
        $enrollments = model(EnrollmentModel::class)->getByClassIdAndAcademicYear(
            classId: $class->id,
            year: $year
        );

        // preciso dos ids dos estudantes associados as matriculas
        $studentsIds = array_column($enrollments, 'student_id');

        // Preciso buscar apenas os estudantes presente nas matrículas
        $students = empty($studentsIds) ? [] : model(StudentModel::class)->whereIn('id', $studentsIds)->findAll();

        // Preciso percorrer as minhas matrículas
        foreach($enrollments as $enrollment){

            // Preciso percorrer os estudantes
            foreach($students as $student){

                // Preciso comprar os dados
                if((int) $enrollment->student_id === (int) $student->id){

                    // Associamos ao estudante a sua matricula
                    $student->enrollment = $enrollment;
                    break;
                }

            }
        }

        // Criamos a propriedade 'students' que pode ou não ter valor
        $class->students = $students;
    }
}
