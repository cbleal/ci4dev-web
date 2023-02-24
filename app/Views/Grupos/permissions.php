<!-- View Usuarios -->

<?= $this->extend('Layout/principal') ?>

<!-- Aqui eu coloco o titulo da página -->
<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<!-- Aqui eu coloco os estilos da página -->
<?= $this->section('styles') ?>
<link rel="stylesheet" type="text/css" href="<?= site_url('features/vendor/selectize/selectize.bootstrap4.css') ?>" />
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
                            <select class="selectize" name="permission_id[]" multiple>
                                <option value="">Selecione...</option>
                                <?php foreach ($permissionsAvailables as $permission) : ?>
                                    <option value="<?= $permission->id ?>"><?= esc($permission->name) ?></option>
                                <?php endforeach; ?>
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
                                    <?php
                                        $atributos = [
                                            'onSubmit' => "return confirm('Tem certeza da exclusão da permissão ?');",
                                        ];
                                    ?>
                                    <?= form_open("grupos/removePermission/$permission->grupo_permission_id", $atributos) ?>
                                    <td><?= esc($permission->name) ?></td>
                                    <td><button type="submit" class="btn btn-sm btn-danger">Excluir</button></td>
                                    <?= form_close() ?>
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
<script type="text/javascript" src="<?= site_url('features/vendor/selectize/selectize.min.js') ?>"></script>

<script>
    $(".selectize").selectize({
        delimiter: ",",
        persist: false,
        maxItems: null,
        create: function(input) {
            return {
                value: input,
                text: input,
            };
        }
    });

    // submisssão do formulário
    $('#form').on('submit', function(e) {

        // evita o envio do formulario
        e.preventDefault();

        // ajax
        $.ajax({
            // tipo de requisição do formulario
            type: "post",
            // url para qual a requisição será enviada
            url: "<?= site_url('grupos/createPermission') ?>",
            // dados do formulario
            data: new FormData(this),
            // tipo de dados que serão retornados
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            // antes do envio
            beforeSend: function() {
                // limpa o html do elemento response da página
                $('#response').html('');
                // muda o valor do elemento bnt-salvar
                $('#btn-salvar').val('Processando dados...');
            },
            // retorno
            success: function(response) {
                // muda o valor do elemento bnt-salvar
                $('#btn-salvar').val('Salvar');
                // remove atributo do elemento bnt-salvar
                $('#btn-salvar').removeAttr("disabled");
                // atualiza o codigo csrf
                $('[name=csrf_ordem]').val(response.token)
                // verificar se veio erro na resposta, se não tiver erro
                if (!response.erro) {
                    // se tiver info na resposta, exibe no elemento response
                    if (response.info) {
                        $('#response').html('<div class="alert alert-info">' + response.info + '</div>');
                    } else {
                        window.location = "<?= site_url("grupos/permissions/$grupo->id") ?>";
                    }
                }

                if (response.erro) {
                    // erros de validação
                    $('#response').html('<div class="alert alert-danger">' + response.erro + '</div>');
                    if (response.erros_model) {
                        $.each(response.erros_model, function(key, value) {
                            $('#response').append('<ul class="list-unstyled"><li class="alert alert-danger">' + value + '</li></ul>')
                        });
                    }
                }
            },
            error: function() {
                alert('Não foi possível processar a informação.')
                $('#btn-salvar').val('Salvar')
                $('#btn-salvar').removeAttr('disabled')
            }
        });
    });

    // desabilitar o clique duplo do formulario
    $('#form').submit(function() {
        $(this).find(':submit').attr('disabled', 'disabled')
    });
</script>
<?= $this->endSection() ?>