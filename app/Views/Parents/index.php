<?= $this->extend('Layouts/main') ?>

<?= $this->section('title') ?>
<?php echo $title; ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>

<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">


<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6><?php echo $title; ?></h6>
        <a href="<?php echo route_to('parents.new'); ?>" class="btn bg-gradient-dark mb-0"><i class="fas fa-plus"></i>&nbsp;&nbsp;Novo Responsável</a>
      </div>
      <div class="card-body pb-2">
        <div class="table-responsive">
          <table id="table" class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">Ações</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">Nome</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">E-mail</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">CPF</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">Telefone</th>                
              </tr>
            </thead>
            <tbody>

              <?php foreach ($parents as $parent) : ?>

                <tr>
                  <td class="align-middle pb0">

                    <a class="btn btn-sm bg-gradient-info" href="<?php echo route_to('parents.show', $parent->code) ?>">Detalhes</a>

                  </td>
                 
                  <td>
                    <div class="d-flex>                      
                      <div>
                        <h6 class="mb-0 text-sm"><?php echo $parent->name; ?></h6>
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex>                      
                      <div>
                        <h6 class="mb-0 text-sm"><?php echo $parent->email; ?></h6>
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex>                      
                      <div>
                        <h6 class="mb-0 text-sm"><?php echo $parent->cpf; ?></h6>
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex>                      
                      <div>
                        <h6 class="mb-0 text-sm"><?php echo $parent->phone; ?></h6>
                      </div>
                    </div>
                  </td>

                  
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>

<script>
  $('#table').bootstrapTable({
    search: true,
    pagination: true,
    pageSize: 20,
    paginationHalign: 'left',
    paginationParts: ['pageList'],
    columns: [
      {
        field: 'actions',
        title: 'Ações',
        sortable: false,
      },
      {
        field: 'name',
        title: 'Nome',
        sortable: true,
      },
      {
        field: 'email',
        title: 'E-mail',
        sortable: true,
      },
      {
        field: 'cpf',
        title: 'CPF',
        sortable: true,
      },
      {
        field: 'phone',
        title: 'Telefone',
        sortable: true,
      },
    ],
  })
</script>

<?= $this->endSection() ?>