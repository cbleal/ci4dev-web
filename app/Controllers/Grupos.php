<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GrupoModel;
use App\Entities\Grupo;

class Grupos extends BaseController
{
    private $grupoModel;

    public function __construct() {
        $this->grupoModel = new GrupoModel();
    }

    public function index()
    {
        // echo "aqui"; exit;

        # array
        $data = [
            'title' => 'Grupos',
        ];

        # view
        return view('Grupos/index', $data);
    }

    public function getGrupos()
    {
        # se não for uma requisição AJAX, aborta execução
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        # array que representa os campos a recuperar
        $fields = [
            'id',
            'name',
            'description',
            'view',
            'deleted_at',
        ];

        # objeto grupos recuperados da tabela
        $grupos = $this->grupoModel->select($fields)
                                ->withDeleted(true)
                                ->orderBy('id', 'DESC')
                                ->findAll();

        # array data => vai receber os grupos
        $data = [];

        # percorrer o objeto grupos
        foreach ($grupos as $grupo) {

            # adicionar ao array data
            $data[] = [
                'name'   => anchor(
                    "grupos/view/{$grupo->id}",
                    esc($grupo->name),
                    'title="Exibir Grupo ' . esc($grupo->name) . '"'
                ),
                'description'  => esc($grupo->description),
                'view' => $grupo->viewSituation(),
            ];
        }

        # array retorno => vai receber o array data
        $retorno = [
            'data' => $data,
        ];       

        # retornar no formato Json o array retorno
        return $this->response->setJSON($retorno);
    }

    private function getGrupoOr404(int $id = null)
    {
        if (!$id || !$grupo = $this->grupoModel->withDeleted(true)->find($id)) {

            # exibe uma exceção
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não foi possível encontrar o usuário $id");
        }

        # se existir o usuario, retorna o objeto usuario
        return $grupo;
    }

    public function view(int $id = null)
    {
        $grupo = $this->getGrupoOr404($id);

        $data = [
            'title' => 'Detalhando o Grupo ' . esc($grupo->name),
            'grupo'  => $grupo,
        ];

        return view('Grupos/view', $data);
    }

    public function edit(int $id = null)
    {
        $grupo = $this->getGrupoOr404($id);

        if ($grupo->id < 3) {

            return redirect()
                    ->back()
                    ->with('atencao', 'O grupo <strong> ' . esc($grupo->name) . '</strong> não pode ser alterado ou removido.');
            
        }

        $data = [
            'title' => 'Editando o Grupo ' . esc($grupo->name),
            'grupo'  => $grupo,
        ];

        return view('Grupos/edit', $data);
    }

    public function update()
    {
        # se não for uma requisição AJAX, aborta execução
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        # envio de um novo hash do token do formulario
        $retorno['token'] = csrf_hash();

        # recupear o post da requisição
        $post = $this->request->getPost();

        # validando a existencia de um grupo
        $grupo = $this->getGrupoOr404($post['id']);      

        # validar a operação para os grupos Administrador e Clientes
        if ($grupo->id < 3) {

            # mensagem de erro
            $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';

            # mensagem de erros de validação
            $retorno['erros_model'] = ['grupo' => "Esse grupo não pode ser alterado ou excluído."];

            # retorno para o ajax request
            return $this->response->setJSON($retorno);
            
        }

        # preenchemos os atributos do grupo com os valores do post
        $grupo->fill($post);

        # verifica se houve alteração no grupo
        if ($grupo->hasChanged() == false) {
            $retorno['info'] = 'Não há dados para serem atualizados.';
            return $this->response->setJSON($retorno);
        }

        # grava os dados (protect(false) = retira a protecao dos dados)
        if ($this->grupoModel->protect(false)->save($grupo)) {

            session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

            return $this->response->setJSON($retorno);
        }

        # mensagem de erro
        $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';

        # mensagem de erros de validação
        $retorno['erros_model'] = $this->grupoModel->errors();

        # retorno para o ajax request
        return $this->response->setJSON($retorno);
    }
}
