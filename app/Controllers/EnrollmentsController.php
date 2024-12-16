<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Enrollment;
use App\Models\ClassModel;
use App\Models\EnrollmentModel;
use App\Models\ParentModel;
use App\Validation\EnrollmentValidation;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class EnrollmentsController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Enrollments/';

    private EnrollmentModel $enrollmentModel;

    public function __construct()
    {
        $this->enrollmentModel = model(EnrollmentModel::class);
    }

    public function index(): string
    {
        $this->dataToView['title'] = 'Gerenciar as matrículas';
        $this->dataToView['enrollments'] = $this->enrollmentModel->all();

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function new(): string
    {
        $parentCode = esc($this->request->getGet('parent_code'));

        // Buscamos o responsável
        $parent = model(ParentModel::class)->getByCode(
            code: $parentCode, 
            withStudents: true //faremos a crição de um dropdown no front-end
        );       

        $this->dataToView['title'] = 'Novo matrícula';
        $this->dataToView['enrollment'] = new Enrollment();
        $this->dataToView['parent'] = $parent;
        $this->dataToView['classes'] = model(ClassModel::class)->orderBy('name', 'ASC')->findAll();

        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }

    public function create(): RedirectResponse
    {

        $rules = (new EnrollmentValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Instanciamos a matrícula com os dados validados
        $enrollment = new Enrollment($this->validator->getValidated());

        $success = $this->enrollmentModel->save($enrollment);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na criação da matrícula');
        } 
        
        $createdEnrollment = $this->enrollmentModel->find($this->enrollmentModel->getInsertID());

        return redirect()->route('enrollments.show', [$createdEnrollment->code])->with('success', 'Matrícula criada com Sucesso!');
    }

    public function show(string $code): string
    {        

        $this->dataToView['title'] = 'Detalhes da matrícula';
        $this->dataToView['enrollment'] = $this->enrollmentModel->getByCode(code: $code);
        
        return view(self::VIEWS_DIRECTORY . 'show', $this->dataToView);
    }

    public function renew(string $code): string
    {        

        $enrollment = $this->enrollmentModel->getByCode(code: $code);
        $parent = $enrollment->parent;
        $parent->students = [$enrollment->student]; //que é o estudante associado à matrícula
                           

        $this->dataToView['title'] = 'Renovar a matrícula';
        $this->dataToView['enrollment'] = $enrollment;
        $this->dataToView['parent'] = $parent;
        $this->dataToView['classes'] = model(ClassModel::class)->orderBy('name', 'ASC')->findAll();

        //Chamamos novamente a view new
        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }
}
