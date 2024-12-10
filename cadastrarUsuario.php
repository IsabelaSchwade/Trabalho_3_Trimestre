<?php

require_once __DIR__."/vendor/autoload.php";

class CadastroUsuario {
    private string $nome;
    private string $email;
    private string $senha;

    public function __construct(string $nome, string $email, string $senha) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function validarEmail(): bool {
        return preg_match("/@aluno\.feliz\.ifrs\.edu\.br$/", $this->email);
    }

    public function usuarioJaExiste(): bool {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario WHERE emailUsuario = '{$this->email}'";
        $resultado = $conexao->consulta($sql);
        return count($resultado) > 0;
    }

    public function cadastrar(): bool {
        if (!$this->validarEmail()) {
            echo "O email deve ser do domínio @aluno.feliz.ifrs.edu.br.";
            return false;
        }

        if ($this->usuarioJaExiste()) {
            echo "Usuário já cadastrado.";
            return false;
        }

        $senhaCriptografada = password_hash($this->senha, PASSWORD_DEFAULT);
        $conexao = new MySQL();
        $sql = "INSERT INTO usuario (nomeUsuario, emailUsuario, senhaUsuario) VALUES ('{$this->nome}', '{$this->email}', '{$senhaCriptografada}')";
        return $conexao->executa($sql);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $cadastro = new CadastroUsuario($nome, $email, $senha);

    if ($cadastro->cadastrar()) {
        echo "Usuário cadastrado com sucesso!";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <h1>Cadastrar Usuário</h1>
    <form action="cadastrarUsuario.php" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>