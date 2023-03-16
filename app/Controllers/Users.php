<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Entities\User;
use App\Models\GrupoModel;
use App\Models\GruposUsersModel;

class Users extends BaseController
{
  private $userModel;
  private $gruposUserModel;
  private $grupoModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->gruposUserModel = new GruposUsersModel();
    $this->grupoModel = new GrupoModel();
  }

  public function index()
  {
    # array
    $data = [
      'title' => 'Usuários',
    ];

    # view
    return view('Users/index', $data);
  }

  public function getUsers()
  {
    # se não for uma requisição AJAX, aborta execução
    if (!$this->request->isAJAX()) {
      return redirect()->back();
    }

    # array que representa os campos a recuperar
    $fields = [
      'id',
      'name',
      'email',
      'active',
      'image',
      'deleted_at',

    ];

    # objeto users recuperados da tabela
    $users = $this->userModel->select($fields)
      ->withDeleted(true)
      ->orderBy('id', 'DESC')
      ->findAll();

    # array data => vai receber os users
    $data = [];

    # percorrer o objeto users
    foreach ($users as $user) {

      # definindo o caminho da imagem do usuario
      if ($user->image != null) {

        # Tem imagem
        $imagem = [
          'src' => site_url("users/image/$user->image"),
          'class' => 'rounded-circle img-fluid',
          'alt' => esc($user->name),
          'width' => 50
        ];
      } else {

        # Não tem imagem
        $imagem = [
          'src' => site_url('features/img/no-image.png'),
          'class' => 'rounded-circle img-fluid',
          'alt' => 'Usuário sem imagem',
          'width' => 50
        ];
      }

      # adicionar ao array data
      $data[] = [
        'image'  => $user->image = img($imagem),
        'name'   => anchor(
          "users/view/{$user->id}",
          esc($user->name),
          'title="Exibir Usuário ' . esc($user->name) . '"'
        ),
        'email'  => esc($user->email),
        'active' => $user->viewSituation(),
      ];
    }

    # array retorno => vai receber o array data
    $retorno = [
      'data' => $data,
    ];

    # debug
    // echo "<pre>";
    // print_r($retorno);

    # retornar no formato Json o array retorno
    return $this->response->setJSON($retorno);
  }

  public function view(int $id = null)
  {
    $user = $this->getUserOr404($id);

    $data = [
      'title' => 'Detalhando o Usuário ' . esc($user->name),
      'user'  => $user,
    ];

    return view('Users/view', $data);
  }

  public function viewImage(int $id = null)
  {
    $user = $this->getUserOr404($id);

    $data = [
      'title' => 'Alterando a Imagem do Usuário ' . esc($user->name),
      'user'  => $user,
    ];

    return view('Users/viewImage', $data);
  }

  public function uploadImage()
  {
    # se não for uma requisição AJAX, aborta execução
    if (!$this->request->isAJAX()) {
      return redirect()->back();
    }

    # envio de um novo hash do token do formulario
    $retorno['token'] = csrf_hash();

    # carregrando a bibioteca validation
    $validation = \Config\Services::validation();

    # configurando as regras de validação
    $rules = [
      'image' => 'uploaded[image]|max_size[image,1024]|ext_in[image,png,jpg,jpeg,webp]',
    ];

    $messages = [
      'image' => [
        'uploaded' => 'Você deve escolher uma imagem',
        'max_size' => 'Tamanho da imagem deve ser até 1024',
        'ext_in'   => 'Extensões permitidas: png, jpg, jpeg ou webp',
      ],
    ];

    $validation->setRules($rules, $messages);

    if (!$validation->withRequest($this->request)->run()) {

      # mensagem de erro
      $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';

      # mensagem de erros de validação
      $retorno['erros_model'] = $validation->getErrors();

      # retorno para o ajax request
      return $this->response->setJSON($retorno);
    }

    # recuperar o post da requisição
    $post = $this->request->getPost();

    # validando a existencia de um usuario
    $user = $this->getUserOr404($post['id']);

    # recuperar a imagem do formulario já devidamente validada
    $image = $this->request->getFile('image');

    # recuperar o tamanho da imagem
    list($largura, $altura) = getimagesize($image->getPathname());

    # validar o tamanho da imagem
    if ($largura < '300' || $altura < '300') {

      # mensagem de erro
      $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';

      # mensagem de erros de validação
      $retorno['erros_model'] = ['dimensao' => 'O tamanho da imagem não pode ser inferior a 300 x 300 pixels'];

      # retorno para o ajax request
      return $this->response->setJSON($retorno);
    }

    # criar uma pasta em writable para armazenamento da imagem
    $pathImage = $image->store('users');

    # fazer o upload da imagem para a respectiva pasta
    $pathImage = WRITEPATH . 'uploads/' . $pathImage;

    # redimensiona e coloca marca d'água na imagem
    $this->manipulateImage($pathImage, $user->id);

    # imagem antiga
    $oldImage = $user->image;

    # atualiza a imagem na tabela
    $user->image = $image->getName();
    $this->userModel->save($user);

    # subscreve a imagem ao atualizar
    if ($oldImage != null) {
      $this->removeImageOfFileSystem($oldImage);
    }

    # coloca a mensagem de sucesso na sessão para ser apresentada
    session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

    # retorna a resposta da página
    return $this->response->setJSON($retorno);
  }

  public function create()
  {
    $user = new User();

    // dd($user);

    $data = [
      'title' => 'Criando novo usuário',
      'user'  => $user,
    ];

    return view('Users/create', $data);
  }

  public function store()
  {
    # se não for uma requisição AJAX, aborta execução
    if (!$this->request->isAJAX()) {
      return redirect()->back();
    }

    # envio de um novo hash do token do formulario
    $retorno['token'] = csrf_hash();

    # recuperar o post da requisição
    $post = $this->request->getPost();

    # cria novo objeto da entidade usuario
    $user = new User($post);

    # grava os dados (protect(false) = retira a protecao dos dados)
    if ($this->userModel->protect(false)->save($user)) {

      // criar um botão para redirecionar para página de criar novo usuario
      $btnCreate = anchor('users/create', 'Cadastrar Novo Usuário', ['class' => 'btn btn-danger']);

      session()->setFlashdata('sucesso', "Dados salvos com sucesso. <br> $btnCreate");

      // retorna o id do usuario recem criado
      $retorno['id'] = $this->userModel->getInsertID();

      return $this->response->setJSON($retorno);
    }

    # mensagem de erro
    $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';

    # mensagem de erros de validação
    $retorno['erros_model'] = $this->userModel->errors();

    # retorno para o ajax request
    return $this->response->setJSON($retorno);
  }

  public function edit(int $id = null)
  {
    $user = $this->getUserOr404($id);

    $data = [
      'title' => 'Alterando o Usuário ' . esc($user->name),
      'user'  => $user,
    ];

    return view('Users/edit', $data);
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

    # validando a existencia de um usuario
    $user = $this->getUserOr404($post['id']);

    # se o post do campo password está vazio
    # desativa para não ser feito o hash da senha vazia
    if (empty($post['password'])) {

      unset($post['password']);
      unset($post['password_confirmation']);
    }

    # preenchemos os atributos do usuario com os valores do post
    $user->fill($post);

    # verifica se houve alteração no usuario
    if ($user->hasChanged() == false) {
      $retorno['info'] = 'Não há dados para serem atualizados.';
      return $this->response->setJSON($retorno);
    }

    # grava os dados (protect(false) = retira a protecao dos dados)
    if ($this->userModel->protect(false)->save($user)) {

      session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');

      return $this->response->setJSON($retorno);
    }

    # mensagem de erro
    $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';

    # mensagem de erros de validação
    $retorno['erros_model'] = $this->userModel->errors();

    # retorno para o ajax request
    return $this->response->setJSON($retorno);
  }

  public function delete(int $id = null)
  {
    $user = $this->getUserOr404($id);

    # se o usuario está excluido, aborta a execução e exibe uma mensagem
    if ($user->deleted_at != null) {
      return redirect()->back()->with('info', 'Esse usuário já encontra-se excluído');
    }

    # se a requisição foi do tipo post
    if ($this->request->getMethod() === 'post') {

      # remove o usuario
      $this->userModel->delete($user->id);

      # se o usuario tem imagem, excluímos a imagem
      if ($user->image != null) {

        # removemos a imagem
        $this->removeImageOfFileSystem($user->image);
      }

      # atualizar campos imagem e ativo do usuario
      $this->uploadUserDeleted($user);

      # retornamos p/a página principal de usuarios e mostramos uma mensagem de sucesso
      return redirect()->to(site_url('users'))
        ->with('sucesso', 'Usuário ' . esc($user->name) . ' excluído com sucesso.');
    }

    $data = [
      'title' => 'Excluindo o Usuário ' . esc($user->name),
      'user'  => $user,
    ];

    return view('Users/delete', $data);
  }

  public function restoreUser(int $id = null)
  {
    # busca o usuario pelo id
    $user = $this->getUserOr404($id);

    # usuario não deletado não pode ser restaurado
    if ($user->deleted_at == null) {
      return redirect()->back()->with('info', 'Apenas usuários excluídos podem ser restaurados.');
    }

    # restaurar o usuario deletado
    $user->deleted_at = null;
    $this->userModel->protect(false)->save($user);

    return redirect()->back()->with('sucesso', "Usuário {$user->name} restaurado com sucesso.");
  }

  private function getUserOr404(int $id = null)
  {
    # se o parametro id não foi passado ou não existe usuario na tabela
    if (!$id || !$user = $this->userModel->withDeleted(true)->find($id)) {
      # exibe uma exceção
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não foi possível encontrar o usuário $id");
    }

    # se existir o usuario, retorna o objeto usuario
    return $user;
  }

  private function getGrupoUserOr404(int $principal_id = null)
  {
    if (!$principal_id || !$grupoUser = $this->gruposUserModel->find($principal_id)) {
      # exibe uma exceção
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não foi possível encontrar a associação ao grupo de acesso $principal_id");
    }

    # se existir o usuario, retorna o objeto usuario
    return $grupoUser;
  }

  private function manipulateImage($pathImage, $userID)
  {
    # redimensionar a imagem
    \Config\Services::image()
      ->withFile($pathImage)
      ->fit(300, 300, 'center')
      ->save($pathImage);

    # adicionar marca d´água
    $year = date('Y');
    \Config\Services::image('imagick')
      ->withFile($pathImage)
      ->text("Ordem $year - User-ID $userID", [
        'color'      => '#fff',
        'opacity'    => 0.5,
        'withShadow' => true,
        'hAlign'     => 'center',
        'vAlign'     => 'bottom',
        'fontSize'   => 10,
      ])
      ->save($pathImage);
  }

  // remove a imagem antiga
  private function removeImageOfFileSystem(string $image)
  {
    $pathImage = WRITEPATH . "uploads/users/$image";

    if (is_file($pathImage)) {
      unlink($pathImage);
    }
  }

  // método responsável por atualizar os campos de imagem e ativo do usuario
  private function uploadUserDeleted($user)
  {
    $user->image = null;
    $user->active = false;

    $this->userModel->protect(false)->save($user);
  }

  // exibindo a imagem do usuario
  public function image(string $image = null)
  {
    if ($image != null) {
      $this->viewFile('users', $image);
    }
  }

  public function grupos(int $id = null)
  {
    $user = $this->getUserOr404($id);

    $user->grupos = $this->gruposUserModel->getGruposOfUser($user->id, 5);
    $user->pager = $this->gruposUserModel->pager;

    $data = [
      'title' => 'Gerenciando o Grupo de Permissão do Usuário ' . esc($user->name),
      'user'  => $user,
    ];

    # se vier no post um usuario como cliente (2), retorna uma msg erro...
    if (in_array(2, array_column($user->grupos, 'grupo_id'))) {
      return redirect()->to(site_url("users/view/$user->id"))->with('info', 'Este usuário é cliente, portanto não há necessidade de atribuir ou remover permissão de grupo.');
    }

    # se o usuario for administrador, exibe uma msg info tratada na view
    if (in_array(1, array_column($user->grupos, 'grupo_id'))) {
      $user->full_control = true;
      return view('Users/grupos', $data);
    }

    $user->full_control = false;

    # se o usuario tiver algum grupo
    if (!empty($user->grupos)) {
      # recuperar todos os grupos que este usuario não possui e também com exceção do grupo clientes
      $gruposExists = array_column($user->grupos, 'grupo_id');
      $data['gruposAvailables'] = $this->grupoModel->where('id != 2')
        ->whereNotIn('id', $gruposExists)
        ->findAll();
    } else {
      $data['gruposAvailables'] = $this->grupoModel->where('id != 2')
        ->findAll();
    }

    return view('Users/grupos', $data);
  }

  // salvar o(s) grupo(s) do usuario
  public function storeGrupos()
  {
    # se não for uma requisição AJAX, aborta execução
    if (!$this->request->isAJAX()) {
      return redirect()->back();
    }

    # envio de um novo hash do token do formulario
    $retorno['token'] = csrf_hash();

    # recuperar o(s) post(s) da requisição
    $post = $this->request->getPost();

    # validando a existencia de um usuario
    $user = $this->getUserOr404($post['id']);

    # informar que o usuario precisa de um grupo selecionado para poder salvar
    if (empty($post['grupo_id'])) {
      $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';
      $retorno['erros_model'] = ['grupo_id' => 'Você deve escolher um ou mais grupos para salvar.'];
      return $this->response->setJSON($retorno);
    }

    # validar caso o usuario seja cliente
    if (in_array(2, $post['grupo_id'])) {
      $retorno['erro'] = 'Por favor, verifique os dados abaixo e tente novamente:';
      $retorno['erros_model'] = ['grupo_id' => 'Desculpe, usuário do tipo cliente não pode fazer parte de nenhum grupo'];
      return $this->response->setJSON($retorno);
    }

    # validar caso o usuario seja administrador
    if (in_array(1, $post['grupo_id'])) {
      $grupoAdmin = [
        'grupo_id' => 1,
        'user_id' => $user->id
      ];

      # inserir na tabela
      $this->gruposUserModel->insert($grupoAdmin);

      # remove os demais grupos que façam parte anteriormente do usuario
      $this->gruposUserModel->where('grupo_id !=', 1)->where('user_id', $user->id)->delete();

      session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
      session()->setFlashdata('info', 'Notamos que foi escolhido o grupo Administrador, portanto, não há a necessidade de informar outros grupos, pois apenas o grupo Administrador será associado ao usuário');
      return $this->response->setJSON($retorno);
    }

    # inserir os dados na tabela grupos_users
    $grupoPush = [];
    foreach ($post['grupo_id'] as $grupo) {
      array_push($grupoPush, [
        'grupo_id' => $grupo,
        'user_id' => $user->id
      ]);
    }
    $this->gruposUserModel->insertBatch($grupoPush);
    session()->setFlashdata('sucesso', 'Dados salvos com sucesso.');
    return $this->response->setJSON($retorno);
  }

  public function removeGrupo(int $principal_id = null)
  {
    # se os dados vierem via post da requisição...
    if ($this->request->getMethod() === 'post') {
      # recuperar o registro
      $grupoUser = $this->getGrupoUserOr404($principal_id);

      # proteger caso o grupo escolhido seja "Cliente"
      if ($grupoUser->grupo_id == 2) {
        # retorna para view de exibição de usuários
        return redirect()->to(site_url("users/view/$grupoUser->user_id"))->with('info', 'Não é permitida a exclusão do usuário do grupo Cliente');        
      }

      # remover o usuario do grupo de acesso
      $this->gruposUserModel->delete($principal_id);
      # retorna com mensagem de sucesso
      return redirect()->back()->with('success', 'Usuário removido com sucesso do grupo de acesso');

    }

    # não é post (aborta a ação)
    return redirect()->back();
  }
}
