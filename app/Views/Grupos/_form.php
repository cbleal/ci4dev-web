<!-- Formulario Grupos -->

<div class="form-group">
    <label class="form-control-label">Grupo:</label>
    <input type="text" name="name" placeholder="Digite o Nome do Grupo..." class="form-control" value="<?= esc($grupo->name) ?? null ?>">
</div>

<div class="form-group">
    <label class="form-control-label">Descrição:</label>
    <textarea type="text" name="description" placeholder="Digite a descrição aqui..." class="form-control"><?= esc($grupo->description) ?? null ?></textarea>
</div>

<div class="custom-control custom-checkbox">

    <input type="hidden" name="view" value="0">
    <input type="checkbox" name="view" value="1" class="custom-control-input" id="view" <?= ($grupo->view == '1') ? 'checked' : '' ?>>
    <label class="custom-control-label" for="view">Exibir grupo</label>

    <a tabindex="0" style="text-decoration: none;" role="button" data-toggle="popover" data-trigger="focus" title="Importante" data-content="Esse grupo <?= $grupo->view === true ? 'será' : 'não será' ?> exibido na hora da definição do <strong>Responsável Técnico</strong> pela Ordem de Serviço">&nbsp;&nbsp;<i class="fa fa-question-circle"></i></a>

</div>
