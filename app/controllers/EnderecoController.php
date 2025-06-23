<?php
require_once 'config/database.php';
require_once 'app/models/enderecoModel.php';

class EnderecoController
{
    private $enderecoModel;

    // Construtor: Recebe a conexão como parâmetro
    public function __construct()
    {
        $this->enderecoModel = new EnderecoModel();
    }

    public function showForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            session_abort();
            header("Location: login");
            exit();
        } else {
            include 'app/views/endereco_form.php';
        }
    }

    public function buscarCep()
    {
        // Verifica se o CEP foi enviado via POST
        if (isset($_POST['cep'])) {
            $cep = $_POST['cep'];
        } else {
            // Se não, tenta pegar via GET (caso o CEP venha via URL)
            $cep = $_GET['cep'] ?? null;
        }

        // Se o CEP não estiver presente, retorna um erro
        if (empty($cep)) {
            $erro = "CEP não informado";
            include 'app/views/endereco_form.php';
            return;
        }

        // Remove caracteres não numéricos do CEP
        $cep = preg_replace('/\D/', '', $cep);

        // Verifica se o CEP tem exatamente 8 números
        if (strlen($cep) !== 8) {
            $erro = "CEP inválido";
            include 'app/views/endereco_form.php';
            return;
        }

        // Faz a requisição à API do ViaCEP
        $url = "https://viacep.com.br/ws/$cep/json/";
        $response = file_get_contents($url);
        $endereco = json_decode($response, true);

        // Verifica se a API retornou erro
        if (isset($endereco['erro'])) {
            $erro = "CEP não encontrado";
            include 'app/views/endereco_form.php';
            return;
        }

        // Retorna os dados encontrados no formulário
        include 'app/views/endereco_form.php';
    }

    public function salvar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Recebe os dados do formulário
            $this->enderecoModel->cep = trim($_POST['cep']);
            $this->enderecoModel->rua = trim($_POST['rua']);
            $this->enderecoModel->bairro = trim($_POST['bairro']);
            $this->enderecoModel->cidade = trim($_POST['cidade']);
            $this->enderecoModel->uf = trim($_POST['uf']);
            $this->enderecoModel->numero = trim($_POST['numero']);
            $this->enderecoModel->complemento = trim($_POST['complemento']);

            if (
                empty($this->enderecoModel->cep) || empty($this->enderecoModel->rua) || empty($this->enderecoModel->bairro) || empty($this->enderecoModel->cidade)
                || empty($this->enderecoModel->uf) || empty($this->enderecoModel->numero)
            ) {
                $erro = "Todos os campos obrigatórios devem ser preenchidos!";
                include 'app/views/endereco_form.php';
                exit;
            }

            if ($this->enderecoModel->salvar()) {
                header("Location: endereco?sucesso=1");
                exit();
            } else {
                $erro = "Erro ao salvar endereço.";
                include 'app/views/endereco_form.php';
            }
        }
    }

    public function excluir()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit();
        }

        if (isset($_GET['id'])) {
            $id_endereco = $_GET['id'];
            
            if ($this->enderecoModel->excluir($id_endereco)) {
                header("Location: perfil");
                exit();
            } else {
                header("Location: perfil?erro=1");
                exit();
            }
        } else {
            header("Location: perfil?erro=1");
            exit();
        }
    }
}
