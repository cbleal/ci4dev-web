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
        <!-- div block -->
        <div class="user-block block">
            <?php if (empty($permissionsAvailables)) : ?>
                <p class="contributions mt-0">Esse grupos já possui todas as permissões disponíveis.</p>
            <?php else : ?>
                <div id="response">

                </div>
                <div class="body-block">
                    <?= form_open('/', ['id' => 'form'], ['id' => $grupo->id]) ?>
                    <div class="form-group">
                        <label class="form-control-label">Escolha uma ou mais permissões:</label>
                        <select class="form-control" name="permission_id[]" multiple>
                            <option value="">Selecione...</option>
                            <?php foreach($permissionsAvailables as $permission) : ?>
                                <option value="<?= $permission->id ?>"><?= esc($permission->name) ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group mt-5 mb-4">
                        <input type="submit" id="btn-salvar" class="btn btn-primary" value="Salvar" />
                        <a href="<?= site_url("grupos/view/{$grupo->id}") ?>" class="btn btn-secondary ml-2">Voltar</a>
                    </div>

                    <?= form_close() ?>

                </div>

            <?php endif; ?>

        </div>
        <!-- fim div block -->

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
                            <?php foreach ($grupo->permissions as $permission) : ?>
                                <tr>
                                    <td><?= esc($permission->name) ?></td>
                                    <td> <a class="btn btn-sm btn-danger" href="#">Excluir</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="mt-4 ml-2">
                        <?= $grupo->pager->links(); ?>
                    </div>
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