<div class="form-group">
    <label class="form-control-label">Nome:</label>
    <input type="text" name="name" placeholder="Digite seu Nome..." class="form-control" value="<?= esc($user->name) ?? null ?>">
</div>

<div class="form-group">
    <label class="form-control-label">E-mail:</label>
    <input type="text" name="email" placeholder="Digite seu Email..." class="form-control" value="<?= esc($user->email) ?? null ?>">
</div>

<div class="form-group">
    <label class="form-control-label">Senha:</label>
    <input type="password" name="password" placeholder="Digite sua Senha..." class="form-control">
</div>

<div class="form-group">
    <label class="form-control-label">Confirmação de Senha:</label>
    <input type="password" name="password_confirmation" placeholder="Confirme sua Senha..." class="form-control">
</div>

<div class="custom-control custom-checkbox">
    <input type="hidden" name="active" value="0">
    <input type="checkbox" name="active" value="1" class="custom-control-input" id="active" <?= ($user->active == '1') ? 'checked' : '' ?>>
    <label class="custom-control-label" for="active">Usuário ativo</label>
</div>