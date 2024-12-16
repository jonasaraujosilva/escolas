<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Address;
use App\Entities\Teacher;
use App\Models\TeacherModel;
use App\Validation\AddressValidation;
use App\Validation\TeacherValidation;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class TeachersController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Teachers/';

    private TeacherModel $TeacherModel;

    public function __construct()
    {
        $this->TeacherModel = model(TeacherModel::class);
    }

    public function index(): string
    {
        $this->dataToView['title'] = 'Gerenciar os Professores';
        $this->dataToView['teachers'] = $this->TeacherModel->orderBy('name', 'ASC')->findAll();

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function new(): string
    {
        $this->dataToView['title'] = 'Novo professor';
        $this->dataToView['teacher'] = new Teacher([
            'address' => new Address()
        ]);

        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }

    public function create(): RedirectResponse
    {

        $rules = (new TeacherValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Instanciamos o professor com os dados validados
        $teacher = new Teacher($this->validator->getValidated());

        $rules = (new AddressValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Instanciamos o endereço com os dados validados
        $address = new Address($this->validator->getValidated());

        $success = $this->TeacherModel->store(teacher: $teacher, address: $address);

        if (!$success) {

            return redirect()
                ->back()                
                ->with('danger', 'Ocorreu um erro na criação do professor');
        }

        return redirect()->route('Teacher')->with('success', 'Professor criado com Sucesso!');

    }

    public function show(string $code): string
    {

        $teacher = $this->TeacherModel->getByCode(code: $code, withAddress: true);
       
        $this->dataToView['title'] = 'Detalhes do professor';
        $this->dataToView['teacher'] = $teacher;
        
        return view(self::VIEWS_DIRECTORY . 'show', $this->dataToView);
    }

    public function edit(string $code): string
    {

        $teacher = $this->TeacherModel->getByCode(code: $code, withAddress: true);
       
        $this->dataToView['title'] = 'Editar o professor';
        $this->dataToView['teacher'] = $teacher;
        
        return view(self::VIEWS_DIRECTORY . 'edit', $this->dataToView);
    }

    public function update(string $code): RedirectResponse
    {

        $teacher = $this->TeacherModel->getByCode(code: $code, withAddress: true);

        $rules = (new TeacherValidation)->getRules($teacher->id);

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Populamos o professor com os dados validados
        $teacher->fill($this->validator->getValidated());

        $rules = (new AddressValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Recuperamos o endereço associado
        $address = $teacher->address;

        $address->fill($this->validator->getValidated());

        $success = $this->TeacherModel->store(teacher: $teacher, address: $address);

        if (!$success) {

            return redirect()
                ->back()                
                ->with('danger', 'Ocorreu um erro na atualização do professor');
        }

        return redirect()->route('teachers.show', [$teacher->code])->with('success', 'Professor Atualizado com Sucesso!');

    }

    public function destroy(string $code): RedirectResponse {

        $teacher = $this->TeacherModel->getByCode(code: $code);

        $success = $this->TeacherModel->destroy($teacher);

        if (!$success) {

            return redirect()
                ->back()                
                ->with('danger', 'Ocorreu um erro na exclusão do professor');
        }

        return redirect()->route('teachers')->with('success', 'Professor excluido com Sucesso!');

    }
}
