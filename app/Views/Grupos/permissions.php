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

    <div class="col-lg-8">

    </div>

    <div class="col-lg-4">

        <!-- div block -->
        <div class="grupo-block block">

            <?php if (empty($grupo->permissions)) : ?>

                <p class="contributions mt-0">Não existem permissões de acesso para este grupo</p>

            <?php else : ?>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Permissão</th>
                                <th>Ação</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($grupo->permissions as $permission) : ?>
                                <tr>
                                    <td><?= esc($permission->name) ?></td>
                                    <td> <a class="btn btn-sm btn-danger" href="#">Excluir</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </div>
        <!-- fim div block -->

    </div>

</div>

<?= $this->endSection() ?>

<!-- Aqui eu coloco os scripts da página -->
<?= $this->section('scripts') ?>

<?= $this->endSection() ?>