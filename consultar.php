
<?php
include("conexao.php");

$sql = "SELECT * FROM usuarios ORDER BY id DESC";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro ao consultar os cadastros: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Consulta Geral</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

<div class="container">

    <h1>Consulta Geral</h1>

    <h2>Todos os cadastros realizados</h2>

    <?php if (mysqli_num_rows($resultado) > 0) { ?>

        <div style="overflow-x: auto;">

            <table border="1" cellpadding="10" cellspacing="0">

                <tr>
                    <th>ID</th>
                    <th>Nome completo</th>
                    <th>Data de nascimento</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Cidade</th>
                    <th>Endereço</th>
                    <th>Sexo</th>
                    <th>Curso</th>
                </tr>

                <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>

                    <tr>
                        <td><?php echo h($usuario["id"]); ?></td>
                        <td><?php echo h($usuario["nome_completo"]); ?></td>
                        <td><?php echo h($usuario["data_nascimento"]); ?></td>
                        <td><?php echo h($usuario["email"]); ?></td>
                        <td><?php echo h($usuario["telefone"]); ?></td>
                        <td><?php echo h($usuario["cpf"]); ?></td>
                        <td><?php echo h($usuario["cidade"]); ?></td>
                        <td><?php echo h($usuario["endereco"]); ?></td>
                        <td><?php echo h($usuario["sexo"]); ?></td>
                        <td><?php echo h($usuario["curso"]); ?></td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    <?php } else { ?>

        <p>Nenhum cadastro encontrado.</p>

    <?php } ?>

    <br>

    <a href="index.php">Voltar ao menu</a>

</div>

</body>
</html>
