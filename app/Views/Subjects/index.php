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
        <a href="<?php echo route_to('subjects.new'); ?>" class="btn bg-gradient-dark mb-0"><i class="fas fa-plus"></i>&nbsp;&nbsp;Nova Disciplina</a>
      </div>
      <div class="card-body pb-2">
        <div class="table-responsive">
          <table id="table" class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">Ações</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">Nome</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">Descrição</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">Criada</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100 ps-2">Editada</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($subjects as $subject) : ?>

                <tr>
                  <td class="align-middle pb0">

                    <a class="btn btn-sm bg-gradient-info" href="<?php echo route_to('subjects.edit', $subject->code) ?>">Editar</a>

                    <?php echo form_open(
                      action: route_to('subjects.destroy', $subject->code),
                      attributes: ['class' => 'form-floating d-inline', 'onsubmit' => 'return confirm("Deseja realmente excluir a disciplina?")'],
                      hidden: ['_method' => 'DELETE']
                    ); ?>

                    <button class="btn btn-sm bg-gradient-danger" type="submit">Excluir</button>



                    <?php echo form_close(); ?>

                  </td>

                  <td>
                    <div class="d-flex>                      
                      <div>
                        <h6 class=" mb-0 text-sm"><?php echo $subject->name; ?></h6>
                    </div>
        </div>
        </td>

        <td>
          <div class="d-flex>                      
                      <div>
                        <h6 class=" mb-0 text-sm"><?php echo $subject->description; ?></h6>
          </div>
      </div>
      </td>



      <td>
        <div class="d-flex>                      
                      <div>
                        <h6 class=" mb-0 text-sm"><?php echo $subject->created_at->humanize(); ?></h6>
        </div>
    </div>
    </td>

    <td>
      <div class="d-flex>                      
                      <div>
                        <h6 class=" mb-0 text-sm"><?php echo $subject->updated_at->humanize(); ?></h6>
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
    columns: [{
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
        field: 'description',
        title: 'Descrição',
        sortable: true,
      },
      {
        field: 'created_at',
        title: 'Criada',
        sortable: true,
      },
      {
        field: 'updated_at',
        title: 'Atualizada',
        sortable: true,
      },
    ],
  })
</script>

<?= $this->endSection() ?>