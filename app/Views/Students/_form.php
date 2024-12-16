<div class="row">

    <h6>Dados pessoais</h6>

    <?php echo form_hidden('parent_code', $student->parent->code); ?>

    <div class="col-md-12">

        <div class="form-floating mb-3">
            <input type="text" disabled class="form-control" value="<?php echo $student->parent->name. ' CPF '. $student->parent->cpf; ?>">
            <label for="name">Responsável</label>
        </div>

    </div>

    <div class="col-md-6">

<div class="form-floating mb-3">
    <input type="text" class="form-control" placeholder="Nome Completo" name="name" value="<?php echo old('name', $student->name); ?>" id="name">
    <label for="name">Nome completo</label>
</div>

</div>

    <div class="col-md-6">

        <div class="form-floating mb-3">
            <input type="email" class="form-control" placeholder="E-mail" name="email" value="<?php echo old('email', $student->email); ?>" id="email">
            <label for="email">E-mail</label>
        </div>

    </div>

    <div class="col-md-6">

        <div class="form-floating mb-3">
            <input type="tel" class="form-control phone" placeholder="Telefone" name="phone" value="<?php echo old('phone', $student->phone); ?>" id="phone">
            <label for="phone">Telefone</label>
        </div>

    </div>

    <div class="col-md-6">

        <div class="form-floating mb-3">
            <input type="text" class="form-control cpf" placeholder="CPF" name="cpf" value="<?php echo old('cpf', $student->cpf); ?>" id="cpf">
            <label for="cpf">CPF</label>
        </div>

    </div>

</div>



<div class="row mt-3">

    <div class="col-md-12">

        <button type="submit" class="btn mb-0 bg-gradient-info">Salvar</button>

    </div>

</div>


<?= $this->section('js') ?>


<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

<script src="<?php echo base_url('assets/mask/jquery.mask.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/mask/app.js'); ?>"></script>


<?= $this->endSection() ?>