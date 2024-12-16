<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ParentModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

class ApiParentsController extends BaseController
{
    public function getByCpf(): Response
    {
        $cpf = esc($this->request->getGet('cpf'));

        /** @var ParentStudent|null */
        $parent = null;

        if(!empty($cpf)){

            $parent = model(ParentModel::class)->select('code')->where(['cpf' => $cpf])->first();   
        }

        return $this->response->setJSON(['parent' => $parent]);
    }
}
