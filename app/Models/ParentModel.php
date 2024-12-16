<?php

namespace App\Models;

use App\Entities\Address;
use App\Entities\ParentStudent;
use App\Models\Basic\AppModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ParentModel extends AppModel
{
    protected $table            = 'parents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ParentStudent::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'address_id',
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

    public function store(ParentStudent $parent, Address $address): bool
    {

        try {

            // Iniciamos a transaction
            $this->db->transException(true)->transStart();


            model(AddressModel::class)->save($address);
            $parent->address_id = $address->id ?? model(AddressModel::class)->getInsertID();

            $this->save($parent);



            // Finalizamos a transaction
            $this->db->transComplete();

            // Retorna o status da transaction: true or false
            return $this->db->transStatus();
        } catch (\Throwable $th) {
            log_message('error', "Erro ao salvar o responsável: {$th->getMessage()}");

            return false;
        }
    }


    public function getByCode(string $code, bool $withAddress = false, bool $withStudents = false, bool $withSubscriptions = false): ParentStudent
    {


        $parent = $this->where(['code' => $code])->first();

        if ($parent === null) {

            throw new PageNotFoundException("Responsável não encontrado. Code: {$code}");
        }

        if ($withAddress) {

            $parent->address = model(AddressModel::class)->find($parent->address_id);
        }

        if($withStudents){

            $parent->students = model(StudentModel::class)
            ->where('parent_id', $parent->id)
            ->orderBy('name', 'ASC')
            ->findAll();

        }

        return $parent;
    }

    public function destroy(ParentStudent $parent): bool {

        try {

            // Iniciamos a transaction
            $this->db->transException(true)->transStart();
           

            $this->delete($parent->id);

            model(AddressModel::class)->delete($parent->address_id);


            // Finalizamos a transaction
            $this->db->transComplete();

            // Retorna o status da transaction: true or false
            return $this->db->transStatus();
        } catch (\Throwable $th) {
            log_message('error', "Erro ao excluir o responsável: {$th->getMessage()}");

            return false;
        }
    }
}
