<?= $this->extend('Layouts/main') ?>

<?= $this->section('title') ?>
<?php echo $title; ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>



<?= $this->endSection() ?>


<?= $this->section('content') ?>


<div class="col-8">
    <div class="card h-100">
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <h6 class="mb-0"><?php echo $title; ?></h6>
                </div>
                <div class="col-md-4 text-end">
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('parents.edit', $parent->code); ?>">
                        <i class="fas fa-arrow-left text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"></i>
                    </a>
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('parents.edit', $parent->code); ?>">
                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></i>
                    </a>

                    <?php echo form_open(
                        action: route_to('parents.destroy', $parent->code),
                        attributes: ['class' => 'form-floating d-inline', 'onsubmit' => 'return confirm("Deseja realmente excluir o Responsável?")'],
                        hidden: ['_method' => 'DELETE']
                    ); ?>

                    <button class="btn btn-sm" type="submit"><i class="fa fas-trash text-danger text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"></i></button>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <hr class="horizontal gray-light my-4">
            <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nome completo:</strong> &nbsp; <?php echo $parent->name; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Telefone:</strong> &nbsp; <?php echo $parent->phone; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">E-mail:</strong> &nbsp; <?php echo $parent->email; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">CPF:</strong> &nbsp; <?php echo $parent->cpf; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Criado:</strong> &nbsp; <?php echo $parent->created_at->humanize(); ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Atualizado:</strong> &nbsp; <?php echo $parent->updated_at->humanize(); ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Endereço:</strong> &nbsp; <?php echo $parent->address->getFullAddress(); ?></li>

            </ul>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>



<?= $this->endSection() ?>