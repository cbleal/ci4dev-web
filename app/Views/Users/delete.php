<!-- Edit Usuarios -->

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

    <div class="col-lg-6">

        <!-- div block -->
        <div class="block">
      
            <!-- montamos a tag form -->
            <div class="body-block">

                <?= form_open("users/delete/{$user->id}") ?>

                <div class="alert alert-warning" role="alert">
                    Tem certeza que deseja excluir o registro ?
                </div>

                <div class="form-group mt-5 mb-4">

                    <input type="submit" id="btn-salvar" class="btn btn-primary" value="Sim, pode excluir" />
    
                    <a href="<?= site_url("users/view/{$user->id}") ?>" class="btn btn-secondary ml-2">Voltar</a>

                </div>
             
                <?= form_close() ?>
            
            </div>

        </div>
        <!-- fim div block -->

    </div>

</div>

<?= $this->endSection() ?>

<!-- Aqui eu coloco os scripts da página -->
<?= $this->section('scripts') ?>

<script>

    // jquery
    $(document).ready(function() {

        // submisssão do formulário
        $('#form').on('submit', function(e) {
                        
            // evita o envio do formulario
            e.preventDefault();

            // ajax
            $.ajax({

                // tipo de requisição do formulario
                type: "post",
                // url para qual a requisição será enviada
                url: "<?= site_url('users/update') ?>",
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
                    if (! response.erro) {

                         // se tiver info na resposta, exibe no elemento response
                        if (response.info) {
                            
                            $('#response').html('<div class="alert alert-info">' + response.info + '</div>');

                        } else {

                            window.location = "<?= site_url("users/view/{$user->id}") ?>";
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
    });

</script>

<?= $this->endSection() ?>