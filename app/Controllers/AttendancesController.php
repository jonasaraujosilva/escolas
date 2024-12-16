<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Attendance\StudentOptionsService;
use App\Models\ClassModel;
use CodeIgniter\HTTP\ResponseInterface;

class AttendancesController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Attendances/';

    private ClassModel $classModel;

    public function __construct()
    {
        $this->classModel = model(ClassModel::class);
    }

    public function index(string $classCode)
    {

        // Buscamos as turmas com estudantes, pois criaremos as opções para geração da frequencia
        $class = $this->classModel->getByCode(code: $classCode, withStudents: true);

        $studentOptionsService = new StudentOptionsService();

        $this->dataToView['title']           = "Gerenciar a frequência da turma: {$class->name}";
        $this->dataToView['class']           = $class;
        $this->dataToView['studentsOptions'] = $studentOptionsService->renderCheckboxOptions(
            students: empty($class->students) ? [] : $class->students
        );               

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }
}
