<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Address;
use App\Entities\ParentStudent;
use App\Models\ParentModel;
use App\Validation\AddressValidation;
use App\Validation\ParentValidation;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class ParentsController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Parents/';

    private ParentModel $parentModel;

    public function __construct()
    {
        $this->parentModel = model(ParentModel::class);
    }

    public function index(): string
    {
        $this->dataToView['title'] = 'Gerenciar os resposáveis';
        $this->dataToView['parents'] = $this->parentModel->orderBy('name', 'ASC')->findAll();

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function new(): string
    {
        $this->dataToView['title'] = 'Novo responsável';
        $this->dataToView['parent'] = new ParentStudent([
            'address' => new Address()
        ]);

        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }

    public function create(): RedirectResponse
    {

        $rules = (new ParentValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Instanciamos o responsável com os dados validados
        $parent = new ParentStudent($this->validator->getValidated());

        $rules = (new AddressValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Instanciamos o endereço com os dados validados
        $address = new Address($this->validator->getValidated());

        $success = $this->parentModel->store(parent: $parent, address: $address);

        if (!$success) {

            return redirect()
                ->back()                
                ->with('danger', 'Ocorreu um erro na criação do responsável');
        }

        return redirect()->route('parents')->with('success', 'Responsável criado com Sucesso!');

    }

    public function show(string $code): string
    {

        $parent = $this->parentModel->getByCode(code: $code, withAddress: true);
       
        $this->dataToView['title'] = 'Detalhes do responsável';
        $this->dataToView['parent'] = $parent;
        
        return view(self::VIEWS_DIRECTORY . 'show', $this->dataToView);
    }

    public function edit(string $code): string
    {

        $parent = $this->parentModel->getByCode(code: $code, withAddress: true);
       
        $this->dataToView['title'] = 'Editar o responsável';
        $this->dataToView['parent'] = $parent;
        
        return view(self::VIEWS_DIRECTORY . 'edit', $this->dataToView);
    }

    public function update(string $code): RedirectResponse
    {

        $parent = $this->parentModel->getByCode(code: $code, withAddress: true);

        $rules = (new ParentValidation)->getRules($parent->id);

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Populamos o responsável com os dados validados
        $parent->fill($this->validator->getValidated());

        $rules = (new AddressValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        //Recuperamos o endereço associado
        $address = $parent->address;

        $address->fill($this->validator->getValidated());

        $success = $this->parentModel->store(parent: $parent, address: $address);

        if (!$success) {

            return redirect()
                ->back()                
                ->with('danger', 'Ocorreu um erro na atualização do responsável');
        }

        return redirect()->route('parents.show', [$parent->code])->with('success', 'Responsável Atualizado com Sucesso!');

    }

    public function destroy(string $code): RedirectResponse {

        $parent = $this->parentModel->getByCode(code: $code);

        $success = $this->parentModel->destroy($parent);

        if (!$success) {

            return redirect()
                ->back()                
                ->with('danger', 'Ocorreu um erro na exclusão do responsável');
        }

        return redirect()->route('parents')->with('success', 'Responsável excluido com Sucesso!');

    }
}
