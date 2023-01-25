<!-- View Usuarios -->

<?= $this->extend('Layout/principal') ?>

<!-- Aqui eu coloco o titulo da página -->
<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<!-- Aqui eu coloco os estilos da página -->
<?= $this->section('styles') ?>

<?= $this->endSection() ?>

<!-- Aqui eu coloco o conteúdo da página -->
<?= $this->section('content') ?>

<div class="row">

    <div class="col-lg-4">

        <!-- div block -->
        <div class="block">

            <div class="text-center">

                <!-- imagem do usuario -->
                <?php if ($user->image == null) : ?>

                    <img src="<?= site_url('features/img/no-image.png') ?>" class="card-img-top" style="width: 90%;" alt="Usuário sem imagem" />

                <?php else : ?>

                    <img src="<?= site_url("users/image/{$user->image}") ?>" class="card-img-top" style="width: 90%;" alt="<?= esc($user->name) ?>" />

                <?php endif; ?>

                <a href="<?= site_url("users/viewImage/{$user->id}") ?>" class="btn btn-sm btn-outline-primary mt-3">
                    Alterar Imagem
                </a>

                <hr class="border-secondary" />

            </div>

            <!-- nome do usuario -->
            <h5 class="card-text"><?= esc($user->name) ?></h5>
            <!-- email do usuario -->
            <p class="card-text"><?= esc($user->email) ?></p>
            <!-- situação do usuario -->
            <p class="card-text"><?= $user->active == '1' ? 'Usuário ativo' : 'Usuário inativo' ?></p>
            <!-- data da criação -->
            <p class="card-text">Criado em: <?= $user->created_at->humanize() ?></p>
            <!-- data da alteração -->
            <p class="card-text">Atualizado em: <?= $user->updated_at->humanize() ?></p>

            <!-- dropdown bootstrap -->
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= site_url("users/edit/{$user->id}") ?>">Editar Usuário</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>

            <a href="<?= site_url('users') ?>" class="btn btn-secondary ml-2">Voltar</a>

        </div>
        <!-- fim div block -->

    </div>

</div>

<?= $this->endSection() ?>

<!-- Aqui eu coloco os scripts da página -->
<?= $this->section('scripts') ?>

<?= $this->endSection() ?>