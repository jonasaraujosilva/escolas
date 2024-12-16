<?php


declare(strict_types=1);

namespace App\Libraries\Attendance;

class StudentOptionsService
{

    public function renderCheckboxOptions(array $students): string|null
    {

        if (empty($students)) {

            return null; //Usaremos esse valor no front para não exibir a funcionalidade de geração de presença, pois a turma não tem alunos
        }

        $table = new \CodeIgniter\View\Table();

        $table->setTemplate([
            'table_open' => '<table class="table table-bordered">'
        ]);

        $table->setHeading(['Status', 'Matrícula', 'Estudante']);

        foreach ($students as $student) {

            $table->addRow([
                $this->getCheckboxOption(studentId: (int) $student->id),
                $student->enrollment->code,
                $student->name,
            ]);
        }

        return $table->generate();
    }

    private function getCheckboxOption(int $studentId): string
    {

        return "

        <div class='form-check form-switch'>
            <input class='form-check-input student-option' name='students[]' data-id='{$studentId}' type='checkbox' id='student-{$studentId}'>
            <label class='form-check-label text-body ms-3 text-truncate w-80 mb-0' for='student-{$studentId}>Faltou</label>
        </div>
        
        ";
    }
}
