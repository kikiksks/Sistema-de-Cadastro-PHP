
<?php

include("conexao.php");

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome_completo"]);
    $nascimento = $_POST["data_nascimento"];
    $email = trim($_POST["email"]);
    $telefone = trim($_POST["telefone"]);
    $cpf = trim($_POST["cpf"]);
    $cidade = trim($_POST["cidade"]);
    $endereco = trim($_POST["endereco"]);
    $sexo = $_POST["sexo"] ?? "";
    $cursoEscolhido = $_POST["curso"] ?? "";

    $cursos = [
        "Informática",
        "Desenvolvimento de Sistemas",
        "Administração",
        "Nutrição",
        "Logística"
    ];

    if ($cursoEscolhido == "Outros") {

        $curso = trim($_POST["curso_outro"] ?? "");

    } else {

        $curso = $cursoEscolhido;

    }

    if (
        $nome == "" || $nascimento == "" ||
        $email == "" || $telefone == "" ||
        $cpf == "" || $cidade == "" ||
        $endereco == "" || $curso == ""
    ) {

        $mensagem = "Preencha todos os campos!";

    } elseif (!in_array($sexo, ["M", "F", "N"])) {

        $mensagem = "Selecione o sexo!";

    } elseif (
        $cursoEscolhido != "Outros" &&
        !in_array($cursoEscolhido, $cursos)
    ) {

        $mensagem = "Selecione um curso válido!";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $mensagem = "Digite um e-mail válido!";

    } else {

        $sql = "INSERT INTO usuarios
        (nome_completo, data_nascimento, email, telefone,
        cpf, cidade, endereco, curso, sexo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conexao, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssssssss",
            $nome,
            $nascimento,
            $email,
            $telefone,
            $cpf,
            $cidade,
            $endereco,
            $curso,
            $sexo
        );

        if (mysqli_stmt_execute($stmt)) {

            $mensagem = "Cadastro realizado com sucesso!";

        } else {

            $mensagem = "Erro ao realizar cadastro.";

        }

        mysqli_stmt_close($stmt);

    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Incluir Cadastro</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

<div class="container formulario">

    <h1>Cadastro de Usuário</h1>

    <?php if ($mensagem != "") { ?>
        <p class="mensagem">
            <?php echo h($mensagem); ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Nome completo:</label>
        <input type="text" name="nome_completo" required>

        <label>Data de nascimento:</label>
        <input type="date" name="data_nascimento" required>

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <label>Telefone:</label>
        <input type="tel" name="telefone" required>

        <label>CPF:</label>
        <input type="text" name="cpf" required>

        <label>Cidade:</label>
        <input type="text" name="cidade" required>

        <label>Endereço:</label>
        <input type="text" name="endereco" required>

        <label>Sexo:</label>

        <div class="opcoes">

            <label>
                <input type="radio" name="sexo" value="M" required>
                M - Masculino
            </label>

            <label>
                <input type="radio" name="sexo" value="F">
                F - Feminino
            </label>

            <label>
                <input type="radio" name="sexo" value="N">
                N - Não declarar
            </label>

        </div>

        <label>Curso:</label>

        <select name="curso" id="curso" required>

            <option value="">Selecione um curso</option>

            <option value="Informática">Informática</option>

            <option value="Desenvolvimento de Sistemas">
                Desenvolvimento de Sistemas
            </option>

            <option value="Administração">Administração</option>

            <option value="Nutrição">Nutrição</option>

            <option value="Logística">Logística</option>

            <option value="Outros">Outros</option>

        </select>

        <div id="campo_outro" style="display:none;">

            <label>Digite o nome do curso:</label>

            <input type="text" name="curso_outro"
            id="curso_outro">

        </div>

        <button type="submit" class="botao">
            Cadastrar
        </button>

    </form>

    <a href="index.php">Voltar ao menu</a>

</div>

<script>

const curso = document.getElementById("curso");

const campoOutro = document.getElementById("campo_outro");

const inputOutro = document.getElementById("curso_outro");

curso.addEventListener("change", function() {

    if (curso.value === "Outros") {

        campoOutro.style.display = "block";
        inputOutro.required = true;

    } else {

        campoOutro.style.display = "none";
        inputOutro.required = false;
        inputOutro.value = "";

    }

});

</script>

</body>
</html>
