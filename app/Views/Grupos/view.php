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

    <div class="col-lg-3">

        <!-- div block -->
        <div class="grupo-block block">           

            <!-- nome do usuario -->
            <h5 class="card-text"><?= esc($grupo->name) ?></h5>
            <!-- email do usuario -->
            <p class="card-text"><?= esc($grupo->description) ?></p>
            <!-- situação do usuario -->
            <p class="contributions mt-0"><?= $grupo->viewSituation() ?></p>
            <!-- data da criação -->
            <p class="card-text">Criado em: <?= $grupo->created_at->humanize() ?></p>
            <!-- data da alteração -->
            <p class="card-text">Atualizado em: <?= $grupo->updated_at->humanize() ?></p>

            <!-- dropdown bootstrap -->
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">                    

                    <a class="dropdown-item" href="<?= site_url("grupos/edit/{$grupo->id}") ?>">Editar Grupo</a>

                    <div class="dropdown-divider"></div>

                    <?php if($grupo->deleted_at != null): ?>
                        <a class="dropdown-item" href="<?= site_url("grupos/restoregrupo/{$grupo->id}") ?>">Restaurar Grupo</a>
                    <?php else: ?>
                        <a class="dropdown-item" href="<?= site_url("grupos/delete/{$grupo->id}") ?>">Excluir Grupo</a>
                    <?php endif; ?>

                </div>
            </div>

            <a href="<?= site_url('grupos') ?>" class="btn btn-secondary ml-2">Voltar</a>

        </div>
        <!-- fim div block -->

    </div>

</div>

<?= $this->endSection() ?>

<!-- Aqui eu coloco os scripts da página -->
<?= $this->section('scripts') ?>

<?= $this->endSection() ?>