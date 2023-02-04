<!-- sucessso -->
<?php if (session()->has('sucesso')) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Tudo Certo!</strong> <?= session('sucesso') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>

<!-- info -->
<?php if (session()->has('info')) : ?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Informação</strong> <?= session('info') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>

<!-- atenção -->
<?php if (session()->has('atencao')) : ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Informação</strong> <?= session('atencao') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>

<!-- erros_model -->
<?php if (session()->has('erros_model')) : ?>


    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <ul>
            <?php foreach ($erros_model as $erro) : ?>

                <li>
                    <strong>Erro:</strong> <?= $erro ?>
                </li>

            <?php endforeach; ?>
        </ul>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>

<!-- error -->
<?php if (session()->has('error')) : ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> <?= session('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>