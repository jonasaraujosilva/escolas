<?php if (isset($errors) && $errors !== []) : ?>
    <div class="errors" role="alert">
        <ul class="list-group">
            <?php foreach ($errors as $error) : ?>
                <li class="list-group-item alert-danger text-white"><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>