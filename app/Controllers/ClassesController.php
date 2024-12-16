<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\SchoolClass;
use App\Models\ClassModel;
use App\Validation\ClassValidation;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class ClassesController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Classes/';

    private ClassModel $classModel;

    public function __construct()
    {
        $this->classModel = model(ClassModel::class);
    }

    public function index(): string
    {
        $this->dataToView['title'] = 'Gerenciar as turmas';
        $this->dataToView['classes'] = $this->classModel->orderBy('name', 'ASC')->findAll();

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function new(): string
    {
        $this->dataToView['title'] = 'Nova turma';
        $this->dataToView['class'] = new SchoolClass();

        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }

    public function create(): RedirectResponse
    {        

        $rules = (new ClassValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Instanciamos a turma com os dados validados
        $class = new SchoolClass($this->validator->getValidated());

        $success = $this->classModel->save($class);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na criação da turma');
        }

        $createdClass = $this->classModel->find($this->classModel->getInsertID());

        return redirect()->route('classes.show', [$createdClass->code])->with('success', 'Turma criada com Sucesso!');
    }

    public function show(string $code): string
    {
        $this->dataToView['title'] = 'Detalhes da turma';
        $this->dataToView['class'] = $this->classModel->getByCode(code: $code, withSchedules: true, withStudents: true);
        
        return view(self::VIEWS_DIRECTORY . 'show', $this->dataToView);
    }


    public function edit(string $code): string
    {
        $this->dataToView['title'] = 'Editar a turma';
        $this->dataToView['class'] = $this->classModel->getByCode(code: $code);
        
        return view(self::VIEWS_DIRECTORY . 'edit', $this->dataToView);
    }


    public function update(string $code): RedirectResponse
    {

        $class = $this->classModel->getByCode(code: $code);

        $rules = (new ClassValidation)->getRules($class->id);

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Populo a turma com os dados validados
        $class->fill($this->validator->getValidated());

        $success = $this->classModel->save($class);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na atualização da turma');
        }
        
        return redirect()->route('classes.show', [$class->code])->with('success', 'Turma criada com Sucesso!');
    }


    public function destroy(string $code): RedirectResponse
    {

        $class = $this->classModel->getByCode(code: $code);

        $this->classModel->delete($class->id);

        return redirect()->route('classes')->with('success', 'Turma excluido com Sucesso!');
    }


}
