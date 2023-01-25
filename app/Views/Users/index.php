<?= $this->extend('Layout/principal') ?>

<!-- Aqui eu coloco o titulo da página -->
<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<!-- Aqui eu coloco os estilos da página -->
<?= $this->section('styles') ?>

<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/r-2.4.0/datatables.min.css" />

<?= $this->endSection() ?>

<!-- Aqui eu coloco o conteúdo da página -->
<?= $this->section('content') ?>

<div class="row">

    <div class="col-lg-12">

        <div class="block">

            <a class="btn btn-danger mb-5" href="<?= site_url('users/create') ?>">Criar Novo Usuário</a>

            <div class="table-responsive">
                <table id="ajaxTable" class="table table-striped table-sm" style="width: 100%;">

                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Situação</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!-- Aqui eu coloco os scripts da página -->
<?= $this->section('scripts') ?>

<!-- DataTable JS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/r-2.4.0/datatables.min.js"></script>

<script>

    const DATATABLE_PTBR = {
        "sEmptyTable": "Nenhum registro encontrado",
        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "_MENU_ resultados por página",
        "sLoadingRecords": "Carregando...",
        "sProcessing": "Processando...",
        "sZeroRecords": "Nenhum registro encontrado",
        "sSearch": "Pesquisar",
        "oPaginate": {
            "sNext": "Próximo",
            "sPrevious": "Anterior",
            "sFirst": "Primeiro",
            "sLast": "Último"
        },
        "oAria": {
            "sSortAscending": ": Ordenar colunas de forma ascendente",
            "sSortDescending": ": Ordenar colunas de forma descendente"
        },
        "select": {
            "rows": {
                "_": "Selecionado %d linhas",
                "0": "Nenhuma linha selecionada",
                "1": "Selecionado 1 linha"
            }
        }
    }

    $(document).ready(function() {

        $('#ajaxTable').DataTable({

            oLanguage: DATATABLE_PTBR,

            ajax: "<?= site_url('users/getUsers') ?>",
            columns: [{
                    data: 'image'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'active'
                },                
            ],
            deferRender: true,
            processing: true,
            language: {                
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
            },
            responsive: true,
            pagingType: $(window).width() < 768 ? "simple" : "simple_numbers",

        });
    });
</script>

<?= $this->endSection() ?>