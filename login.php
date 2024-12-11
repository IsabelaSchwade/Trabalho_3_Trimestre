
<?php

require_once __DIR__."/vendor/autoload.php";

class Login {
    private string $email;
    private string $senha;

    public function __construct(string $email, string $senha) {
        $this->email = $email;
        $this->senha = $senha;
    }

    public function autenticar(): bool {
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario WHERE emailUsuario = '{$this->email}'";
        $resultado = $conexao->consulta($sql);

        if (count($resultado) === 1) {
            $senhaHash = $resultado[0]['senhaUsuario'];
            if (password_verify($this->senha, $senhaHash)) {
                session_start();
                $_SESSION['usuario'] = $resultado[0]['nomeUsuario'];
                $_SESSION['email'] = $resultado[0]['emailUsuario'];
                return true;
            }
        }

        return false;
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $login = new Login($email, $senha);

    if ($login->autenticar()) {
       
        if ($email === 'admin@aluno.feliz.ifrs.edu.br') {
            header("Location: visualizarRanking.php");
        } else {
            header("Location: visualizarRankingUsuario.php"); 
        }
        exit();
    } else {
        echo "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='1.css'>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Senha:</label>
        <input type="password" name="senha" required><br>
        <button type="submit">Entrar</button>
    </form>

    <br>
    
    <div class="center-div">
    <p><a href='cadastrarUsuario.php'  class="logout-btn">Criar conta</a></p>
    <br> 
</body>
</html>