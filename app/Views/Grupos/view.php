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

    <?php if ($grupo->id < 3) : ?>
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Importante!</h4>
                <p>Este grupo não poderá ser editado ou excluído pois o mesmo já é padrão do sistema.</p>
                <hr>
                <p class="mb-0">No entanto, os demais grupos poderão ser manipulados conforme a necessidade do usuário.</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-lg-4">

        <!-- div block -->
        <div class="grupo-block block">

            <h5 class="card-text"><?= esc($grupo->name) ?></h5>

            <p class="contributions mt-0">

                <?= $grupo->viewSituation() ?>

                <?php if ($grupo->deleted_at === null) : ?>

                    <a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover" data-trigger="focus" title="Importante" data-content="Esse grupo <?= $grupo->view === true ? 'será' : 'não será' ?> exibido na hora da definição do <strong>Responsável Técnico</strong> pela Ordem de Serviço">&nbsp;&nbsp;<i class="fa fa-question-circle"></i></a>
                    
                <?php endif; ?>

            </p>

            <p class="card-text"><?= esc($grupo->description) ?></p>

            <p class="card-text">Criado em: <?= $grupo->created_at->humanize() ?></p>

            <p class="card-text">Atualizado em: <?= $grupo->updated_at->humanize() ?></p>

            <?php if ($grupo->id > 2) : ?>

                <div class="btn-group mr-2">

                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>

                    <div class="dropdown-menu">

                        <a class="dropdown-item" href="<?= site_url("grupos/edit/{$grupo->id}") ?>">Editar Grupo</a>

                        <div class="dropdown-divider"></div>


                        <?php if ($grupo->id > 2) : ?>
                            <a class="dropdown-item" href="<?= site_url("grupos/permissions/{$grupo->id}") ?>">Gerenciar Permissões</a>
                        <?php endif; ?>
                        
                        <div class="dropdown-divider"></div>

                        <?php if ($grupo->deleted_at != null) : ?>
                            <a class="dropdown-item" href="<?= site_url("grupos/restoregrupo/{$grupo->id}") ?>">Restaurar Grupo</a>
                        <?php else : ?>
                            <a class="dropdown-item" href="<?= site_url("grupos/delete/{$grupo->id}") ?>">Excluir Grupo</a>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>

            <a href="<?= site_url('grupos') ?>" class="btn btn-secondary">Voltar</a>

        </div>
        <!-- fim div block -->

    </div>

</div>

<?= $this->endSection() ?>

<!-- Aqui eu coloco os scripts da página -->
<?= $this->section('scripts') ?>

<?= $this->endSection() ?>