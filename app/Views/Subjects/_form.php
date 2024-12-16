<div class="row">

    <div class="col-md-12">

        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Nome" name="name" value="<?php echo old('name', $subject->name); ?>" id="name">
            <label for="name">Nome</label>
        </div>

    </div>

    <div class="col-md-12">

        <div class="form-floating mb-3">
            <textarea name="description" id="description" style="min-height: 150px !important;" class="form-control"><?php echo old('description', $subject->description); ?></textarea>
            <label for="email">Descrição</label>
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