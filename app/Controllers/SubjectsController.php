<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Subject;
use App\Models\SubjectModel;
use App\Validation\SubjectValidation;
use CodeIgniter\HTTP\RedirectResponse;

class SubjectsController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Subjects/';

    private SubjectModel $subjectModel;

    public function __construct()
    {
        $this->subjectModel = model(SubjectModel::class);
    }

    public function index(): string
    {
        $this->dataToView['title'] = 'Gerenciar as disciplinas';
        $this->dataToView['subjects'] = $this->subjectModel->orderBy('name', 'ASC')->findAll();

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function new(): string
    {
        $this->dataToView['title'] = 'Nova disciplinas';
        $this->dataToView['subject'] = new Subject();

        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }

    public function create(): RedirectResponse
    {

        $rules = (new SubjectValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Instanciamos as disciplinas com os dados validados
        $subject = new Subject($this->validator->getValidated());

        $success = $this->subjectModel->save($subject);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na criação da disciplina');
        }        

        return redirect()->route('subjects')->with('success', 'Disciplina criada com Sucesso!');
    }


    public function edit(string $code): string
    {
        $this->dataToView['title'] = 'Editar a disciplina';
        $this->dataToView['subject'] = $this->subjectModel->getByCode(code: $code);
        
        return view(self::VIEWS_DIRECTORY . 'edit', $this->dataToView);
    }


    public function update(string $code): RedirectResponse
    {

        $subject = $this->subjectModel->getByCode(code: $code);

        $rules = (new SubjectValidation)->getRules($subject->id);

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Populo a disciplina com os dados validados
        $subject->fill($this->validator->getValidated());

        $success = $this->subjectModel->save($subject);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na atualização da disciplina');
        }
        
        return redirect()->route('subjects')->with('success', 'Disciplina editada com Sucesso!');
    }


    public function destroy(string $code): RedirectResponse
    {

        $subject = $this->subjectModel->getByCode(code: $code);

        $this->subjectModel->delete($subject->id);

        return redirect()->route('subjects')->with('success', 'Disciplina excluida com Sucesso!');
    }


}
