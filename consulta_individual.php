
<?php

include("conexao.php");

$usuario = null;
$mensagem = "";

if (isset($_GET["id"])) {

    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && $id > 0) {

        $sql = "SELECT * FROM usuarios WHERE id = ?";

        $stmt = mysqli_prepare($conexao, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);

        $usuario = mysqli_fetch_assoc($resultado);

        if (!$usuario) {
            $mensagem = "Usuário não encontrado!";
        }

        mysqli_stmt_close($stmt);

    } else {

        $mensagem = "Digite um ID válido!";

    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Consulta Individual</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

<div class="container">

    <h1>  color: #;  Consulta Individual</h1>

    <form method="GET">

        <label>Digite o ID do usuário:</label>

        <input type="number" name="id" min="1" required>

        <button type="submit" class="botao">
            Pesquisar
        </button>

    </form>

    <?php if ($mensagem != "") { ?>

        <p class="mensagem">
            <?php echo h($mensagem); ?>
        </p>

    <?php } ?>

    <?php if ($usuario) { ?>

        <h2>Dados do usuário</h2>

        <p><strong>ID:</strong> <?php echo h($usuario["id"]); ?></p>

        <p><strong>Nome:</strong> <?php echo h($usuario["nome_completo"]); ?></p>

        <p><strong>Data de nascimento:</strong> <?php echo h($usuario["data_nascimento"]); ?></p>

        <p><strong>E-mail:</strong> <?php echo h($usuario["email"]); ?></p>

        <p><strong>Telefone:</strong> <?php echo h($usuario["telefone"]); ?></p>

        <p><strong>CPF:</strong> <?php echo h($usuario["cpf"]); ?></p>

        <p><strong>Cidade:</strong> <?php echo h($usuario["cidade"]); ?></p>

        <p><strong>Endereço:</strong> <?php echo h($usuario["endereco"]); ?></p>

        <p><strong>Sexo:</strong> <?php echo h($usuario["sexo"]); ?></p>

        <p><strong>Curso:</strong> <?php echo h($usuario["curso"]); ?></p>

    <?php } ?>

    <a href="index.php">Voltar ao menu</a>

</div>

</body>
</html>
