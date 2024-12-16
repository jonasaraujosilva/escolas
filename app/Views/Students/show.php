<?= $this->extend('Layouts/main') ?>

<?= $this->section('title') ?>
<?php echo $title; ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>



<?= $this->endSection() ?>


<?= $this->section('content') ?>


<div class="col-12">
    <div class="card h-100">
        <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <h6 class="mb-0"><?php echo $title; ?></h6>
                </div>
                <div class="col-md-4 text-end">
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('students.edit', $student->code); ?>">
                        <i class="fas fa-arrow-left text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"></i>
                    </a>
                    <a class="me-1 btn btn-sm" href="<?php echo route_to('students.edit', $student->code); ?>">
                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></i>
                    </a>

                    <?php echo form_open(
                        action: route_to('students.destroy', $student->code),
                        attributes: ['class' => 'form-floating d-inline', 'onsubmit' => 'return confirm("Deseja realmente excluir o Aluno?")'],
                        hidden: ['_method' => 'DELETE']
                    ); ?>

                    <button class="btn btn-sm" type="submit"><i class="fas fa-trash text-danger text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"></i></button>



                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <hr class="horizontal gray-light my-4">
            <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nome completo:</strong> &nbsp; <?php echo $student->name; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Telefone:</strong> &nbsp; <?php echo $student->phone; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">E-mail:</strong> &nbsp; <?php echo $student->email; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">CPF:</strong> &nbsp; <?php echo $student->cpf; ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Criado:</strong> &nbsp; <?php echo $student->created_at->humanize(); ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Atualizado:</strong> &nbsp; <?php echo $student->updated_at->humanize(); ?></li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Responsável:</strong> &nbsp;

                    <a target="_blank" class="btn btn-link mb-0 ms-0" href="<?php echo route_to('parents.show', $student->parent->code); ?>">
                        <i class="fas fa-eye text-secondary text-sm"></i>&nbsp;&nbsp; <?php echo $student->parent->name; ?> - CPF: <?php echo $student->parent->cpf; ?>
                    </a>

                </li>
            </ul>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('js') ?>



<?= $this->endSection() ?>